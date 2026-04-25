<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServices      = Service::count();
        $totalAppointments  = Appointment::count();
        $todayAppointments  = Appointment::whereDate('appointment_date', today())->count();
        $totalRevenue       = Payment::where('status', 'paid')->sum('amount_paid');
        $recentAppointments = Appointment::with(['service', 'payment'])
                                ->orderBy('appointment_date', 'desc')
                                ->limit(10)
                                ->get();

        return view('dashboard', compact(
            'totalServices',
            'totalAppointments',
            'todayAppointments',
            'totalRevenue',
            'recentAppointments'
        ));
    }
}
