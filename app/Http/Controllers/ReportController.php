<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class ReportController extends Controller
{
    public function GetAnggotaReportPage()
    {
        $user = Auth::user();

        // 1. Get ONLY the 'approved' logs for this specific user
        $approvedLogs = ActivityLog::where('user_id', $user->id)
            ->where('status', 'approved')
            ->orderBy('date', 'desc')
            ->get();

        $monthlyStats = [];
        $weeklyStats = [];
        
        $totalApproved = 0;
        $totalHours = 0;

        foreach ($approvedLogs as $log) {
            // Determine the actual date of the log
            $date = Carbon::parse($log->date ?? $log->created_at);
            
            // --- Keys & Labels for Grouping ---
            $monthKey = $date->format('Y-m'); // e.g., "2026-01"
            $monthLabel = $date->translatedFormat('F Y'); // e.g., "January 2026"
            
            $weekKey = $date->format('Y-\WW'); // e.g., "2026-W04"
            $weekStart = $date->copy()->startOfWeek()->format('d M');
            $weekEnd = $date->copy()->endOfWeek()->format('d M');
            $weekLabel = "Minggu " . $date->weekOfYear . " ($weekStart - $weekEnd)";

            // --- Calculate Hours ---
            $hours = 0;
            if (!empty($log->time) && !empty($log->end_time)) {
                $logDate = $log->date ?? $log->created_at;
                $start = Carbon::parse($logDate . ' ' . $log->time);
                $end = Carbon::parse($logDate . ' ' . $log->end_time);
                
                // If end time is before start time, assume it's next day
                if ($end->lt($start)) {
                    $end->addDay();
                }
                
                // Calculate hours with 2 decimal places
                $hours = round($start->diffInMinutes($end) / 60, 2);
            }
            
            // Add to grand totals
            $totalApproved++;
            $totalHours += $hours;

            // --- Populate Monthly Array ---
            if (!isset($monthlyStats[$monthKey])) {
                $monthlyStats[$monthKey] = ['label' => $monthLabel, 'count' => 0, 'hours' => 0];
            }
            $monthlyStats[$monthKey]['count']++;
            $monthlyStats[$monthKey]['hours'] += $hours;

            // --- Populate Weekly Array ---
            if (!isset($weeklyStats[$weekKey])) {
                $weeklyStats[$weekKey] = ['label' => $weekLabel, 'count' => 0, 'hours' => 0];
            }
            $weeklyStats[$weekKey]['count']++;
            $weeklyStats[$weekKey]['hours'] += $hours;
        }

        // Round the total hours in the stats arrays
        foreach ($monthlyStats as $key => $stat) {
            $monthlyStats[$key]['hours'] = round($stat['hours'], 2);
        }
        
        foreach ($weeklyStats as $key => $stat) {
            $weeklyStats[$key]['hours'] = round($stat['hours'], 2);
        }

        return view('Users.Logs.Report', compact(
            'monthlyStats', 
            'weeklyStats', 
            'totalApproved', 
            'totalHours'
        ));
    }

    public function generatePDF(Request $request)
    {
        $loggedInUser = Auth::user();
        
        // 1. Check if a specific Anggota was requested from the Penyelia dropdown
        $targetUserId = $request->input('anggota_id');
        
        // 2. SECURITY: If an Anggota tries to hack the form to download someone else's report, block them.
        if ($targetUserId && $targetUserId != $loggedInUser->id && $loggedInUser->role === 'anggota') {
            abort(403, 'Anda tidak mempunyai kebenaran untuk mengakses laporan ini.');
        }

        // 3. Determine the final target user for the PDF
        // (If an Anggota clicked download, this simply defaults back to themselves)
        $user = $targetUserId ? \App\Models\User::findOrFail($targetUserId) : $loggedInUser;

        $reportType = $request->input('report_type', 'monthly');
        $startDate = null;
        $endDate = null;
        $periodLabel = '';

        // 4. Safely determine the exact Start and End dates using Carbon
        if ($reportType === 'monthly') {
            $periodValue = $request->input('month_value'); // format: "2026-01"
            
            // Parse the month and get the first and last day
            $date = Carbon::createFromFormat('Y-m', $periodValue);
            $startDate = $date->copy()->startOfMonth()->format('Y-m-d');
            $endDate = $date->copy()->endOfMonth()->format('Y-m-d');
            
            $periodLabel = $date->translatedFormat('F Y');

        } else {
            $periodValue = $request->input('week_value'); // format: "2026-W04"
            
            // Extract Year and Week Number safely
            list($year, $weekNum) = explode('-W', $periodValue);
            
            // Let Carbon calculate the exact start and end of that specific week
            $date = Carbon::now()->setISODate((int)$year, (int)$weekNum);
            $startDate = $date->copy()->startOfWeek()->format('Y-m-d');
            $endDate = $date->copy()->endOfWeek()->format('Y-m-d');
            
            $weekStartLabel = $date->copy()->startOfWeek()->translatedFormat('d M Y');
            $weekEndLabel = $date->copy()->endOfWeek()->translatedFormat('d M Y');
            $periodLabel = "Minggu $weekNum ($weekStartLabel - $weekEndLabel)";
        }

        // 5. Query the database using secure 'whereBetween'
        $logs = ActivityLog::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate])
                      ->orWhereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->orderByRaw('COALESCE(date, DATE(created_at)) ASC') // Sort by date first
            ->orderBy('time', 'asc') // Then by time
            ->get();

        // 6. Calculate statistics and handle night shifts
        $totalLogs = $logs->count();
        $totalHours = 0;
        
        $logs->transform(function ($log) use (&$totalHours) {
            $hours = 0;
            
            if (!empty($log->time) && !empty($log->end_time)) {
                $logDate = $log->date ?? $log->created_at->format('Y-m-d');
                
                $start = Carbon::parse($logDate . ' ' . $log->time);
                $end = Carbon::parse($logDate . ' ' . $log->end_time);
                
                // If end time is before start time, it means they worked past midnight
                if ($end->lt($start)) {
                    $end->addDay();
                }
                
                // Calculate exact hours (e.g., 1.5 hours)
                $hours = round($start->diffInMinutes($end) / 60, 2);
            }
            
            $log->calculated_hours = $hours;
            $totalHours += $hours;
            
            return $log;
        });

        // 7. Generate the PDF
        $pdf = Pdf::loadView('Users.Logs.ReportPDF', [
            'user' => $user,
            'logs' => $logs,
            'periodLabel' => $periodLabel,
            'reportType' => $reportType,
            'totalLogs' => $totalLogs,
            'totalHours' => round($totalHours, 2),
            'generatedDate' => Carbon::now()->translatedFormat('d F Y, H:i')
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Clean the filename (Remove spaces and slashes)
        $cleanLabel = preg_replace('/[^A-Za-z0-9_\-]/', '_', $periodLabel);
        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $user->name);
        $filename = "Laporan_Aktiviti_{$cleanLabel}_{$cleanName}.pdf";

        return $pdf->download($filename);
    }

    public function GetPenyeliaReportPage()
    {
        $user = Auth::user();

        // 1. Fetch all Anggota under this Penyelia
        // (You can adjust this query if they only supervise specific stations/branches)
        $subordinates = User::where('role', 'anggota')->orderBy('name', 'asc')->get();
        
        // Create an array of ALL relevant User IDs (Penyelia + Anggota)
        $userIds = $subordinates->pluck('id')->toArray();
        array_push($userIds, $user->id);

        // 2. Fetch ALL approved logs for everyone in one optimized query
        $allLogs = ActivityLog::whereIn('user_id', $userIds)
            ->where('status', 'approved')
            ->get();

        // 3. Setup our data structures
        $userStats = []; // Holds the math for Javascript
        $availableMonths = []; // Master list for the dropdown
        $availableWeeks = []; // Master list for the dropdown

        foreach ($allLogs as $log) {
            $uid = $log->user_id;
            $date = Carbon::parse($log->date ?? $log->created_at);
            
            // Grouping Keys
            $monthKey = $date->format('Y-m'); 
            $monthLabel = $date->translatedFormat('F Y'); 
            
            $weekKey = $date->format('Y-\WW'); 
            $weekStart = $date->copy()->startOfWeek()->format('d M');
            $weekEnd = $date->copy()->endOfWeek()->format('d M');
            $weekLabel = "Minggu " . $date->weekOfYear . " ($weekStart - $weekEnd)";

            // Add to Master Dropdown Lists
            $availableMonths[$monthKey] = $monthLabel;
            $availableWeeks[$weekKey] = $weekLabel;

            // Calculate Hours Safely
            $hours = 0;
            if (!empty($log->time) && !empty($log->end_time)) {
                $logDate = $log->date ?? $log->created_at->format('Y-m-d');
                $start = Carbon::parse($logDate . ' ' . $log->time);
                $end = Carbon::parse($logDate . ' ' . $log->end_time);
                if ($end->lt($start)) $end->addDay();
                $hours = round($start->diffInMinutes($end) / 60, 2);
            }

            // Initialize user array if not exists
            if (!isset($userStats[$uid])) {
                $userStats[$uid] = ['monthly' => [], 'weekly' => []];
            }

            // Populate Monthly Math
            if (!isset($userStats[$uid]['monthly'][$monthKey])) {
                $userStats[$uid]['monthly'][$monthKey] = ['count' => 0, 'hours' => 0];
            }
            $userStats[$uid]['monthly'][$monthKey]['count']++;
            $userStats[$uid]['monthly'][$monthKey]['hours'] += $hours;

            // Populate Weekly Math
            if (!isset($userStats[$uid]['weekly'][$weekKey])) {
                $userStats[$uid]['weekly'][$weekKey] = ['count' => 0, 'hours' => 0];
            }
            $userStats[$uid]['weekly'][$weekKey]['count']++;
            $userStats[$uid]['weekly'][$weekKey]['hours'] += $hours;
        }

        // Sort the master lists so the newest dates are at the top
        krsort($availableMonths);
        krsort($availableWeeks);

        return view('Penyelia.Logs.Report', compact(
            'subordinates', 
            'userStats', 
            'availableMonths', 
            'availableWeeks'
        ));
    }
}