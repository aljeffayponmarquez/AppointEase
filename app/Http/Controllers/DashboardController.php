<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers        = User::count();
        $totalAppointments = Appointment::count();
        $myAppointments    = Appointment::where('user_id', Auth::id())->count();
        $scheduledCount    = Appointment::where('user_id', Auth::id())->where('status', 'Scheduled')->count();
        $completedCount    = Appointment::where('user_id', Auth::id())->where('status', 'Completed')->count();
        $cancelledCount    = Appointment::where('user_id', Auth::id())->where('status', 'Cancelled')->count();

        // Monthly appointments (last 6 months)
        $monthlyData  = [];
        $monthLabels  = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabels[] = $date->format('M Y');
            $monthlyData[] = Appointment::where('user_id', Auth::id())
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Upcoming appointments
        $upcomingAppointments = Appointment::where('user_id', Auth::id())
            ->where('status', 'Scheduled')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        // Appointments by service (top 5)
        $serviceData = Appointment::where('user_id', Auth::id())
            ->selectRaw('service, count(*) as count')
            ->groupBy('service')
            ->orderByDesc('count')
            ->take(5)
            ->pluck('count', 'service');

        return view('dashboard.index', compact(
            'totalUsers', 'totalAppointments', 'myAppointments',
            'scheduledCount', 'completedCount', 'cancelledCount',
            'monthlyData', 'monthLabels', 'upcomingAppointments', 'serviceData'
        ));
    }
}
