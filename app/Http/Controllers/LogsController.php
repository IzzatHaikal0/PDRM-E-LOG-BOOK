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
    public function index(Request $request)
    {
            // ==========================================
            // DATABASE (REQUIRE AUTH)
            // ==========================================
            $month = $request->input('month', now()->format('Y-m'));
            $user = Auth::user();

            // 2. Build Query
            // We want to show the history of the LOGGED-IN user (Personal History)
            // regardless of whether they are Anggota or Penyelia.
            $logs = ActivityLog::where('user_id', $user->id)
                ->where('date', 'like', "$month%") // Filter by YYYY-MM
                ->with('officer') // Eager load officer details
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get()
                ->groupBy('date'); // Group by date for the view

            if ($user->role === 'penyelia') {
                return view('Penyelia.Logs.History', compact('logs', 'month')); 
            } else {
                return view('Users.Logs.History', compact('logs', 'month'));
            }
        
        

        

        // ==========================================
        // DYNAMIC VIEW RETURN
        // ==========================================

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
        $penugasans = \Illuminate\Support\Facades\DB::table('penugasan')
            ->whereNull('deleted_at')
            ->get();

            // 2. Check the User's Role to decide which View to load
            // Assuming your users table has a 'role' column. 
            // Change 'penyelia' to whatever value you use in your DB (e.g. 'supervisor', 'admin', 1, etc.)
            $user = Auth::user();
            //dd($penugasans, auth()->user()->role);
            if (auth()->user()->role === 'penyelia') {
                // Return Penyelia View
                return view('Penyelia.Logs.Create', compact('penugasans'));
            } else {
                // Return Anggota View
                return view('Users.Logs.Create', compact('penugasans'));
            }

      
    }

    /*public function create()
{
    $penugasans = \Illuminate\Support\Facades\DB::table('penugasan')
        ->whereNull('deleted_at')
        ->get();

    $view = auth()->user()->role === 'penyelia' 
        ? 'Penyelia.Logs.Create' 
        : 'Users.Logs.Create';

    return view($view, ['penugasans' => $penugasans]);
}*/


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
            'end_time' => null,
            'officer_id' => null,
            'is_off_duty' => $request->has('is_off_duty') ? 1:0,
            'remarks' => $request->remarks,
            'status' => 'draft', // Default status
            'images' => $imagePaths,
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




// 1. SHOW THE LIST (Grouped by User)
public function verifyList()
    {
        // --- PART A: PENDING LOGS (Existing Logic) ---
        $pendingLogs = \App\Models\ActivityLog::where('status', 'pending')
            ->where('user_id', '!=', Auth::id()) // Exclude self-submitted logs
            ->with('user')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        $groupedTasks = $this->groupLogsByUser($pendingLogs);

        // --- PART B: VERIFIED LOGS ---
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

                //Group tasks by Date
                'tasks' => $userLogs->groupBy('date')->map(function ($dailyLogs) {
                    return $dailyLogs->map(function ($log) {

                    $officerName = $log->officer ? $log->officer->name : 'Penyelia';
                    $officerId = $log->officer ? $log->officer->id : '-';

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
                        'officer_name' => $officerName,
                        'officer_badge' => $officerId,
                        //'officer_name' => $log->officer ? $log->officer->name : 'Penyelia',
                        'verified_at' => $log->updated_at->format('d M, h:i A'),
                        // Images
                        'images' => ($imgs && count($imgs) > 0) 
                        ? array_map(fn($path) => asset('storage/'.$path), $imgs) 
                        : [],
                        // Signature
                        'signature_url' => $log->signature_path ? asset('storage/'.$log->signature_path) : null,
                        'all_images' => $imgs
                    ];
                });
                })->sortKeysDesc() // Sort so newest dates are at the top
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
    \App\Models\ActivityLog::whereIn('id', $request->task_ids)
    ->where('user_id', '!=', Auth::id()) // Security: NOT the current user
    ->update([
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

    public function history(Request $request)
    {
        // Get selected month or default to current month
        $month = $request->input('month', now()->format('Y-m'));
        
        // Fetch logs ONLY for the currently logged-in Penyelia
        // Grouped by Date for the view structure
        $logs = ActivityLog::where('user_id', Auth::id())
            ->where('date', 'like', "$month%")
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get()
            ->groupBy('date');

        return view('Penyelia.History', compact('logs', 'month'));
    }

    public function batchSubmit(Request $request)
    {
        $request->validate([
            'log_ids' => 'required|array',
            'log_ids.*' => 'exists:activity_logs,id'
        ]);

        // Logic: Update status from 'draft' to 'pending'
        // We DO NOT approve it here. It goes to the pool for OTHER Penyelia to see.
        ActivityLog::whereIn('id', $request->log_ids)
            ->where('user_id', Auth::id()) // Security: Ensure they own the logs
            ->where('status', 'draft')
            ->update([
                'status' => 'pending',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Semua tugasan draf berjaya dihantar untuk pengesahan.');
    }

    public function verificationList()
    {
        $logsToVerify = ActivityLog::where('status', 'pending')
            ->where('user_id', '!=', Auth::id()) // <--- KEY LOGIC: Exclude self
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('user_id');

        return view('Penyelia.VerifyList', compact('logsToVerify'));
    }



}