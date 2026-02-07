<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function index()
    {
        // --- TOGGLE THIS TO FALSE LATER TO USE REAL DATABASE ---
        $testMode = true; 

        if ($testMode) {
            // ==========================================
            //  DUMMY DATA (FOR UI TESTING)
            // ==========================================
            $logs = collect([
                // 1. TODAY - Approved Log
                (object)[
                    'id' => 1,
                    'date' => Carbon::today()->format('Y-m-d'),
                    'time' => '08:00:00',
                    'end_time' => '16:00:00',
                    'type' => 'Lapor Masuk',
                    'status' => 'pending',
                    'remarks' => 'Melapor diri masuk tugas Sif A di Balai.',
                    'rejection_reason' => null,
                    'officer' => (object)['name' => 'Sistem']
                ],
                // 2. TODAY - Pending Log
                (object)[
                    'id' => 2,
                    'date' => Carbon::today()->format('Y-m-d'),
                    'time' => '10:30:00',
                    'end_time' => '12:00:00',
                    'type' => 'Rondaan MPV',
                    'status' => 'ongoing',
                    'remarks' => 'Rondaan sektor A dan B bersama Kpl. Muthu.',
                    'rejection_reason' => null,
                    'officer' => (object)['name' => 'Insp. Razak']
                ],
                // 3. YESTERDAY - Rejected Log
                (object)[
                    'id' => 3,
                    'date' => Carbon::yesterday()->format('Y-m-d'),
                    'time' => '14:00:00',
                    'end_time' => '16:00:00',
                    'type' => 'Latihan Menembak',
                    'status' => 'ongoing',
                    'remarks' => 'Latihan tahunan di lapang sasar.',
                    'rejection_reason' => 'Gambar kehadiran tidak jelas. Sila hantar semula.',
                    'officer' => (object)['name' => 'Asp. Tiong']
                ],
                // 4. OLDER DATE - Approved
                (object)[
                    'id' => 4,
                    'date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                    'time' => '22:00:00',
                    'end_time' => '23:00:00',
                    'type' => 'Tugas Pejabat',
                    'status' => 'approved',
                    'remarks' => 'Mengemaskini fail siasatan.',
                    'rejection_reason' => null,
                    'officer' => (object)['name' => 'Sjn. Mejar Halim']
                ]
                
            ])->groupBy('date');

        } else {
            // ==========================================
            // REAL DATABASE (REQUIRE AUTH)
            // ==========================================
            $user = Auth::user();
            
            // If Supervisor, maybe fetch ALL pending logs or their specific unit's logs
            if ($user && ($user->role === 'penyelia' || $user->role === 'admin')) {
                // Example: Fetch all logs for verification (Adjust query as needed)
                $logs = ActivityLog::with('user', 'officer') // Eager load user relationship
                    ->orderBy('date', 'desc')
                    ->orderBy('time', 'desc')
                    ->get()
                    ->groupBy(function($val) {
                        return Carbon::parse($val->date)->format('Y-m-d');
                    });
            } else {
                // If Anggota, fetch ONLY their own logs
                $logs = ActivityLog::where('user_id', $user->id)
                    ->with('officer') 
                    ->orderBy('date', 'desc')
                    ->orderBy('time', 'desc')
                    ->get()
                    ->groupBy(function($val) {
                        return Carbon::parse($val->date)->format('Y-m-d');
                    });
            }
        }

        

        // ==========================================
        // DYNAMIC VIEW RETURN
        // ==========================================
        $user = Auth::user();

        // Check if user is Supervisor or Admin
        if ($user && ($user->role === 'penyelia')) {
            // Return Supervisor View
            // Ensure this view exists: resources/views/Supervisor/VerifyList.blade.php
            return view('Penyelia.Logs.History', compact('logs')); 
        }else{
             // Default: Return Anggota View
            return view('Users.Logs.History', compact('logs'));
        }

        

       
    }

    public function create()
    {
        return view('Users.Logs.Create');
    }

    // 2. HANDLE THE FORM SUBMISSION (WITH IMAGES)
    public function store(Request $request)
    {
        // A. Validation
        $request->validate([
            'area' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'officer_id' => 'required',
            'remarks' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120', // Max 5MB per image
            'images' => 'max:8', // Max 8 files total
        ]);

        // B. Handle Image Uploads
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store in 'storage/app/public/log_evidence'
                // Make sure you ran: php artisan storage:link
                $path = $image->store('log_evidence', 'public');
                $imagePaths[] = $path;
            }
        }

        // C. Save to Database
        ActivityLog::create([
            'user_id' => Auth::id() ?? 1, // Fallback for test mode
            'balai' => Auth::check() ? Auth::user()->balai : 'Balai Muar', // Fallback
            'area' => $request->area,
            'type' => $request->type,
            'date' => $request->date,
            'time' => $request->time,
            'end_time' => null, // Empty initially
            'officer_id' => $request->officer_id,
            'remarks' => $request->remarks,
            'status' => 'ongoing', // Default status
            'images' => $imagePaths, // Laravel casts this array to JSON automatically
        ]);

        return redirect()->route('logs.history')->with('success', 'Laporan berjaya dihantar!');
    }


    // 3. UPDATE END TIME
    public function updateEndTime(Request $request, $id)
        {
            $log = \App\Models\ActivityLog::findOrFail($id);
            $log->update([
                'end_time' => $request->end_time,
                'status' => 'pending' // Change from 'ongoing' to 'pending' so officer can see it
            ]);
            return back()->with('success', 'Masa tamat direkodkan.');
        }

    public function submitBatch(Request $request)
        {
            // 1. Validate
            $request->validate([
                'log_ids' => 'required|array',
                'log_ids.*' => 'exists:activity_logs,id' // Ensure IDs exist in DB
            ]);

            // 2. Update Status
            // We update all IDs in the array to 'pending'
            \App\Models\ActivityLog::whereIn('id', $request->log_ids)
                ->update(['status' => 'pending']);

            // 3. Redirect
            $count = count($request->log_ids);
            return back()->with('success', "$count laporan berjaya dihantar ke penyelia.");
        }
}