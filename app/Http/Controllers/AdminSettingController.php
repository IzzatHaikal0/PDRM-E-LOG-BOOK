<?php
    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Pangkat; 
    use App\Models\Penugasan;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;

    class AdminSettingController extends Controller
    {
        public function getAllSettings()
        {
            $all_pangkat = Pangkat::all();
            $all_penugasan = Penugasan::all();

            return view('Admin.Settings', compact('all_pangkat', 'all_penugasan'));
        }

       public function storePenugasan(Request $request)
        {
            // 1. Validation
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|in:Kawasan Luar,Kawasan Dalam', 
                'description' => 'nullable|string|max:255',
            ]);

            // 2. Create
            Penugasan::create([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
            ]);

            // 3. Redirect
            return redirect()->back()->with('success', 'Jenis penugasan berjaya ditambah!');
        }
    }
