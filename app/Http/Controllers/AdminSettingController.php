<?php
    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Pangkat; 
    use App\Models\Penugasan;
    use App\Models\Kecemasan;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;

    class AdminSettingController extends Controller
    {
        public function getAllSettings()
        {
            $all_pangkat = Pangkat::orderBy('level', 'asc')->get();
            $all_penugasan = Penugasan::all();
            $contact_kecemasan = Kecemasan::all();

            return view('Admin.Settings', compact('all_pangkat', 'all_penugasan', 'contact_kecemasan'));
        }

        //add a new pangkat
        public function addNewPangkat(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Auto-calculate level: Put it at the bottom (Max Level + 1)
            $nextLevel = Pangkat::max('level') + 1;

            Pangkat::create([
                'pangkat_name' => $request->name,
                'level' => $nextLevel // Use the calculated value
            ]);

            return redirect()->back()->with('success', 'Pangkat berjaya ditambah!');
        }

        // 2. UPDATE
        public function updatePangkat(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $pangkat = Pangkat::findOrFail($id);
            $pangkat->update([
                'pangkat_name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Pangkat berjaya dikemaskini!');
        }

        // 3. DELETE (Soft Delete)
        public function deletePangkat($id)
        {
            $pangkat = Pangkat::findOrFail($id);
            $pangkat->delete();

            return redirect()->back()->with('success', 'Pangkat berjaya dipadam.');
        }

        public function reorderPangkat(Request $request)
        {
            $request->validate([
                'order' => 'required|array',
            ]);

            $order = $request->input('order'); 

            foreach ($order as $index => $id) {
                // Update level based on the array index (starting from 1)
                Pangkat::where('id', $id)->update(['level' => $index + 1]);
            }

            return response()->json(['status' => 'success', 'message' => 'Susunan pangkat berjaya dikemaskini.']);
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

        // 1. UPDATE Function
        public function updatePenugasan(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|in:Kawasan Luar,Kawasan Dalam',
                'description' => 'nullable|string|max:255',
            ]);

            $task = Penugasan::findOrFail($id);
            $task->update([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Jenis penugasan berjaya dikemaskini!');
        }

        // 2. DELETE Function (Soft Delete)
        public function deletePenugasan($id)
        {
            $task = Penugasan::findOrFail($id);
            $task->delete();

            return redirect()->back()->with('success', 'Jenis penugasan berjaya dipadam.');
        }

        public function storeKecemasan(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'no_telefon' => 'required|string|max:255',
            ]);

            Kecemasan::create([
                'name' => $request->name,
                'no_telefon' => $request->no_telefon 
            ]);

            return redirect()->back()->with('success', 'Nombor kecemasan berjaya ditambah!');
        }

        public function updateKecemasan(Request $request, $id)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'no_telefon' => 'required|string|max:255',
            ]);

            $contact_kecemasan = Kecemasan::findOrFail($id);
            $contact_kecemasan->update([
                'name' => $request->name,
                'no_telefon' => $request->no_telefon
            ]);

            return redirect()->back()->with('success', 'Nombor kecemasan berjaya dikemaskini!');
        }

        public function deleteKecemasan(Request $request, $id)
        {
            $contact = Kecemasan::findOrFail($id);
            $contact->delete();

            return redirect()->back()->with('success', 'Nombor kecemasan berjaya dipadam.');
        }
    }
