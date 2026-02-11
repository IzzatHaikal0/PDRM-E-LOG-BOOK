<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function index()
    {
        // --- TOGGLE THIS TO FALSE LATER TO USE REAL DATABASE ---
        $testMode = false;

        

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
        //return view('Users.Logs.Create');
        $penugasans = \Illuminate\Support\Facades\DB::table('penugasan')->get();
        return view('Users.Logs.Create', compact('penugasans'));
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
            //'officer_id' => 'required',
            'is_off_duty' => 'nullable|boolean',
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
            'balai' => Auth::user()->balai ??  'Balai Pekan', // Fallback
            'area' => $request->area,
            'type' => $request->type,
            'date' => $request->date,
            'time' => $request->time,
            'end_time' => null, // Empty initially
            'officer_id' => null,
            'is_off_duty' => $request->has('is_off_duty') ? 1:0,
            'remarks' => $request->remarks,
            'status' => 'draft', // Default status
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

    
    // In LogsController.php

// 1. SHOW THE LIST (Grouped by User)
public function verifyList()
    {
        // --- PART A: PENDING LOGS (Existing Logic) ---
        $pendingLogs = \App\Models\ActivityLog::where('status', 'pending')
            ->with('user')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        $groupedTasks = $this->groupLogsByUser($pendingLogs);

        // --- PART B: VERIFIED LOGS (New Logic) ---
        // Fetch logs approved or rejected (Limit to 50 recent to avoid clutter)
        $verifiedLogs = \App\Models\ActivityLog::whereIn('status', ['approved', 'rejected'])
            ->with(['user', 'officer']) // Load officer for signature info
            ->orderBy('updated_at', 'desc')
            ->take(50)
            ->get();

        $verifiedGroups = $this->groupLogsByUser($verifiedLogs);

        return view('Penyelia.VerifyList', compact('groupedTasks', 'verifiedGroups'));
    }

// Helper function to keep code clean (Put this at bottom of Controller)
private function groupLogsByUser($logs)
    {
        return $logs->groupBy('user_id')->map(function ($userLogs) {
            $user = $userLogs->first()->user;
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'initials' => collect(explode(' ', $user->name))->map(fn($w) => $w[0])->take(2)->join(''),
                'count' => $userLogs->count(),
                'pending_count' => $userLogs->count(),

                'tasks' => $userLogs->map(function ($log) {
                    $imgs = $log->images; 
                    return [
                        'id' => $log->id,
                        'date' => \Carbon\Carbon::parse($log->date)->format('d M Y'),
                        'time' => \Carbon\Carbon::parse($log->time)->format('h:i A'),
                        'type' => $log->type,
                        'location' => $log->area ?? $log->balai,
                        'desc' => $log->remarks,
                        'status' => $log->status,
                        'rejection_reason' => $log->rejection_reason,
                        // Get Officer Name (who verified it)
                        'officer_name' => $log->officer ? $log->officer->name : 'Penyelia',
                        'verified_at' => $log->updated_at->format('d M, h:i A'),
                        // Images
                        'image' => ($imgs && count($imgs) > 0) ? asset('storage/'.$imgs[0]) : null,
                        'signature_url' => $log->signature_path ? asset('storage/'.$log->signature_path) : null,
                        'all_images' => $imgs
                    ];
                })
            ];
        });
    }

// 2. HANDLE VERIFICATION (Save Signature & Update Status)
public function verifyStore(Request $request)
{
    $request->validate([
        'task_ids' => 'required|array', // Can be one ID or multiple
        'signature' => 'required', // Base64 string from signature pad
        'comment' => 'nullable|string'
    ]);

    $signaturePath = null;
    if ($request->signature) {
        // Convert Base64 to Image File
        $image = $request->signature;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'signatures/sig_' . time() . '_' . uniqid() . '.png';
        
        // Save to Storage (public/signatures folder)
        \Illuminate\Support\Facades\Storage::disk('public')->put($imageName, base64_decode($image));
        $signaturePath = $imageName;
    }

    // Update the logs
    \App\Models\ActivityLog::whereIn('id', $request->task_ids)->update([
        'status' => 'approved',
        'officer_id' => Auth::id(), // The currently logged-in supervisor
        'rejection_reason' => $request->comment, // Using this field for general comments/remarks
        'signature_path' => $signaturePath, // Signature path
        'updated_at' => now()
    ]);
    
    // Note: You might want to save the signature image to storage 
    // and save the path in DB if you want to be strict.
    // For now, we assume the signature is verified by the action itself.

    return response()->json(['success' => true, 'message' => 'Tugasan berjaya disahkan.']);
}


// In app/Http/Controllers/LogsController.php

public function edit($id)
    {
        $log = \App\Models\ActivityLog::findOrFail($id);

        // Security Check: Ensure user owns this log
        if ($log->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch penugasan list for the dropdown
        $penugasans = \Illuminate\Support\Facades\DB::table('penugasan')->get();

        return view('Users.Logs.Edit', compact('log', 'penugasans'));
    }

public function update(Request $request, $id)
    {
        $log = \App\Models\ActivityLog::findOrFail($id);

        // 1. Validation
        $request->validate([
            'area' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'remarks' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        // 2. Handle New Image Uploads
        $currentImages = $log->images ?? []; // Get existing images array
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('log_evidence', 'public');
                $currentImages[] = $path; // Append new image to list
            }
        }

        // 3. Update Database
        $log->update([
            'area' => $request->area,
            'type' => $request->type,
            'date' => $request->date,
            'time' => $request->time,
            // If checkbox is checked send 1, else 0
            'is_off_duty' => $request->has('is_off_duty') ? 1 : 0, 
            'remarks' => $request->remarks,
            'images' => $currentImages, // Save merged array
            // Optionally reset status to draft/pending if it was rejected
            'status' => 'pending', 
        ]);

        return redirect()->route('logs.history')->with('success', 'Laporan berjaya dikemaskini!');
    }

// Optional: Helper to delete a single image via AJAX or Link
public function deleteImage(Request $request, $id)
    {
        $log = \App\Models\ActivityLog::findOrFail($id);
        $images = $log->images;
        $imageToDelete = $request->image_path;

        // Filter out the image to delete
        $updatedImages = array_filter($images, fn($img) => $img !== $imageToDelete);

        // Update DB
        $log->update(['images' => array_values($updatedImages)]);

        // Delete file from storage (optional, to save space)
        if(\Illuminate\Support\Facades\Storage::disk('public')->exists($imageToDelete)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($imageToDelete);
        }

        return back()->with('success', 'Gambar dipadam.');
    }



}