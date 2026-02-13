<?php
    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Pangkat; 
    use App\Models\Penugasan;
    use App\Models\Kecemasan;
    use App\Models\ActivityLog;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    class DashboardController extends Controller
    {
        public function getAdminDashboard()
        {
            $all_logs = ActivityLog::latest()->count();
            $count_anggota = User::where('role', 'anggota')->count();
            $count_penyelia = User::where('role', 'penyelia')->count();
            $count_penugasan = Penugasan::count();
            // 2. Get count of users created yesterday
            $new_anggota_today = User::where('role', 'anggota')->whereDate('created_at', Carbon::today())->count();
            $new_penyelia_today = User::where('role', 'penyelia')->whereDate('created_at', Carbon::today())->count();
            $new_logs_today = ActivityLog::whereDate('created_at',Carbon::today())->count();
            $new_penugasan_today = Penugasan::whereDate('created_at', Carbon::today())->count();

            $recent_logs = ActivityLog::with('user.pangkat') ->latest()->take(3)->get();

            $recent_users = User::with('pangkat')->whereIn('role', ['anggota', 'penyelia'])->latest()->take(3) ->get();
            
            return view('Admin.Dashboard', compact('all_logs', 'count_anggota', 'count_penyelia', 'new_anggota_today', 'new_penyelia_today', 'new_logs_today', 'recent_logs', 'recent_users', 'count_penugasan', 'new_penugasan_today'));
        }           
    }