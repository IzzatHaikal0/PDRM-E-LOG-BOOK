<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogsController extends Controller
{
    // --- TOGGLE THIS TO FALSE LATER TO USE REAL DATABASE ---
    public function index()
    {
        // --- TOGGLE THIS TO FALSE LATER TO USE REAL DATABASE ---
        $testMode = true; 

        if ($testMode) {
            // ==========================================
            // OPTION A: MOCK DATA (FOR UI TESTING)
            // ==========================================
            $logs = collect([
                // 1. TODAY - Approved Log
                (object)[
                    'id' => 1,
                    'date' => Carbon::today()->format('Y-m-d'),
                    'time' => '08:00:00',
                    'type' => 'Lapor Masuk',
                    'status' => 'approved',
                    'remarks' => 'Melapor diri masuk tugas Sif A di Balai.',
                    'rejection_reason' => null,
                    'officer' => (object)['name' => 'Sistem']
                ],
                // 2. TODAY - Pending Log
                (object)[
                    'id' => 2,
                    'date' => Carbon::today()->format('Y-m-d'),
                    'time' => '10:30:00',
                    'type' => 'Rondaan MPV',
                    'status' => 'pending',
                    'remarks' => 'Rondaan sektor A dan B bersama Kpl. Muthu.',
                    'rejection_reason' => null,
                    'officer' => (object)['name' => 'Insp. Razak']
                ],
                // 3. YESTERDAY - Rejected Log
                (object)[
                    'id' => 3,
                    'date' => Carbon::yesterday()->format('Y-m-d'),
                    'time' => '14:00:00',
                    'type' => 'Latihan Menembak',
                    'status' => 'rejected',
                    'remarks' => 'Latihan tahunan di lapang sasar.',
                    'rejection_reason' => 'Gambar kehadiran tidak jelas. Sila hantar semula.',
                    'officer' => (object)['name' => 'Asp. Tiong']
                ],
                // 4. OLDER DATE - Approved
                (object)[
                    'id' => 4,
                    'date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                    'time' => '22:00:00',
                    'type' => 'Tugas Pejabat',
                    'status' => 'approved',
                    'remarks' => 'Mengemaskini fail siasatan.',
                    'rejection_reason' => null,
                    'officer' => (object)['name' => 'Sjn. Mejar Halim']
                ]
            ])->groupBy('date'); // Group by date just like the real query

        } else {
            // ==========================================
            // OPTION B: REAL DATABASE (REQUIRE AUTH)
            // ==========================================
            $user_id = Auth::id() ?? 1; // Fallback to ID 1 if not logged in
            
            $logs = ActivityLog::where('user_id', $user_id)
                ->with('officer') 
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get()
                ->groupBy(function($val) {
                    return Carbon::parse($val->date)->format('Y-m-d');
                });
        }

        return view('Users.Logs.History', compact('logs'));
    }


    
    // Show the History Page
    /*public function index()
    {
        // 1. Fetch logs for the logged-in user
        // 2. Order by newest first
        // 3. Get relationships (officer details) to avoid N+1 query performance issues
        $logs = ActivityLog::where('user_id', Auth::id())
            ->with('officer') 
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get()
            ->groupBy(function($val) {
                // Group by Date for the UI (e.g., "Hari Ini", "Yesterday")
                return Carbon::parse($val->date)->format('Y-m-d');
            });

        return view('Users.Logs.History', compact('logs'));
    }*/
}