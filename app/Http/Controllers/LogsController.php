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
                    'end_time' => '12:00:00',
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
                    'end_time' => '16:00:00',
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
        }

        

        // Default: Return Anggota View
        return view('Users.Logs.History', compact('logs'));
    }

    public function updateEndTime(Request $request, $id)
        {
            $log = \App\Models\ActivityLog::findOrFail($id);
            $log->update([
                'end_time' => $request->end_time,
                'status' => 'pending' // Change from 'ongoing' to 'pending' so officer can see it
            ]);
            return back()->with('success', 'Masa tamat direkodkan.');
        }
}