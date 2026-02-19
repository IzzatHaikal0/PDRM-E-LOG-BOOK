<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pangkat; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Imports\UsersImport; 
use Maatwebsite\Excel\Facades\Excel;     
use Illuminate\Support\Facades\Response; 
use App\Exports\TemplateExport;

class RegistrationController extends Controller
{

    public function showForm()
    {
        // 1. Get all ranks from the 'pangkats' table
        $pangkats = Pangkat::orderBy('level', 'asc')->get();
        
        // 2. Return the view and pass the data using 'compact'
        return view('Admin.Registration', compact('pangkats'));
    }

    // 2. Handle Manual Registration Submission
    public function storeManual(Request $request)
    {
        // A. Validation
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'role'          => 'required|in:admin,penyelia,anggota',
            'pangkat_id'    => 'required|exists:pangkats,id',
            'no_badan'      => 'required|string|unique:users,no_badan',
            'no_ic'         => 'required|string|unique:users,no_ic',
            'no_telefon'    => 'required|string',
        ], [
            'no_badan.unique' => 'Nombor badan ini telah didaftarkan.',
            'no_ic.unique'    => 'No. Kad Pengenalan ini telah wujud.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'manual');
        }

        // B. Create User
        // Note: No random password generation needed anymore.
        $user = User::create([
            'name'           => $request->name,
            'role'           => $request->role, 
            'no_badan'       => $request->no_badan,
            'no_ic'          => $request->no_ic,
            'no_telefon'     => $request->no_telefon,
            'pangkat_id'     => $request->pangkat_id,
            // UPDATE: Use 'no_ic' as the default password
            'password'       => Hash::make($request->no_ic),
        ]);

        // C. Redirect
        // Removed email logic block. Updated success message to inform admin about the default password.
        return redirect()->route('Admin.Registration')
            ->with('success', 'Anggota berjaya didaftarkan. Kata laluan adalah No. Kad Pengenalan pengguna.');
    }


    public function listUsers(Request $request)
    {
        // 1. Start the query with Eager Loading (Do not put get() or paginate() yet)
        $query = User::with('pangkat');

        // 2. Filter by Role (Admin, Penyelia, Anggota)
        // Checks if the user selected a role from the dropdown
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 3. Search by Name, No Badan, No IC, or No Tel
        // Checks if the user typed something in the search bar
        if ($request->filled('search')) {
            $search = $request->search;
            
            // We wrap the search in a logical group (WHERE role = 'X' AND (name LIKE 'Y' OR no_badan LIKE 'Y'))
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('no_badan', 'LIKE', "%{$search}%")
                ->orWhere('no_ic', 'LIKE', "%{$search}%")
                ->orWhere('no_telefon', 'LIKE', "%{$search}%");
            });
        }

        // 4. Execute the query and Paginate by 10 per page
        $users = $query->latest()->paginate(10);

        // 5. Calculate Stats dynamically
        // (We leave this querying the whole User table so the top dashboard numbers don't shrink when you search)
        $statsData = [
            'inspektor' => User::whereHas('pangkat', function($q) {
                $q->where('pangkat_name', 'LIKE', '%Inspektor%');
            })->count(),

            'sarjan'    => User::whereHas('pangkat', function($q) {
                $q->where('pangkat_name', 'LIKE', '%Sarjan%');
            })->count(),

            'koperal'   => User::whereHas('pangkat', function($q) {
                // Exact match to avoid counting "Lans Koperal" twice
                $q->where('pangkat_name', 'Koperal (Kpl)');
            })->count(),

            'low_rank'  => User::whereHas('pangkat', function($q) {
                $q->where('pangkat_name', 'LIKE', '%Konstabel%')
                ->orWhere('pangkat_name', 'LIKE', '%Lans%');
            })->count(),
        ];

        return view('Admin.ListAnggota', compact('users', 'statsData'));
    }

    // 3. Show Edit Form (Fetch User & Pangkats)
    public function edit($id)
    {
        // Find the user by ID or fail with 404
        $user = User::findOrFail($id);
        
        // Get all ranks for the dropdown
        $pangkats = Pangkat::all();

        return view('Admin.EditUser', compact('user', 'pangkats'));
    }

    // 4. Handle Update Submission
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validation (Notice 'unique' ignores the current user ID)
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'role'          => 'required|in:admin,penyelia,anggota',
            'pangkat_id'    => 'required|exists:pangkats,id',
            'no_badan'      => 'required|string|unique:users,no_badan,' . $user->id,
            'no_ic'         => 'required|string|unique:users,no_ic,' . $user->id,
            'no_telefon'    => 'required|string',
            'email'         => 'nullable|email|unique:users,email,' . $user->id,
            'alamat'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update User Data
        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'no_badan'   => $request->no_badan,
            'no_ic'      => $request->no_ic,
            'no_telefon' => $request->no_telefon,
            'alamat'     => $request->address, // Map form 'address' to db 'alamat'
            'pangkat_id' => $request->pangkat_id,
        ]);

        return redirect()->route('Admin.ListAnggota')
            ->with('success', 'Maklumat anggota berjaya dikemaskini!');
    }

    //soft delete users
    public function softdelete(Request $request, $id)
    {
        // 1. Find the user
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berjaya dipadam. Data masih ada dalam pangkalan data.');
    }

    // 1. PROCESS THE FILE UPLOAD
    public function storeBulk(Request $request) 
    {
        // Validate file type
        $request->validate([
            'bulk_file' => 'required|mimes:xlsx,csv,xls|max:5120', 
        ]);

        try {
            // Run the Import
            Excel::import(new UsersImport, $request->file('bulk_file'));
            
            return redirect()->back()->with('success', 'Pendaftaran serentak berjaya diproses!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             // Handle Excel Data Validation Errors
             $failures = $e->failures();
             $messages = [];
             foreach ($failures as $failure) {
                 $messages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
             }
             return redirect()->back()->withErrors($messages);
        } catch (\Exception $e) {
            // General Error
            return redirect()->back()->withErrors(['Ralat fail: ' . $e->getMessage()]);
        }
    }

    // 2. DOWNLOAD TEMPLATE
    public function downloadTemplate()
    {
        // It MUST be .xlsx to support Dropdowns (CSV does not support this)
        return Excel::download(new TemplateExport, 'template_pendaftaran_anggota.xlsx');
    }
}