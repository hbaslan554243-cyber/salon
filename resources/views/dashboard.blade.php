@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="stat-grid">
    <div class="stat-card">
        <div class="number">{{ $totalServices }}</div>
        <div class="label">Total Services</div>
    </div>
    <div class="stat-card">
        <div class="number">{{ $totalAppointments }}</div>
        <div class="label">Total Appointments</div>
    </div>
    <div class="stat-card">
        <div class="number">{{ $todayAppointments }}</div>
        <div class="label">Today's Bookings</div>
    </div>
    <div class="stat-card">
        <div class="number">₱{{ number_format($totalRevenue, 2) }}</div>
        <div class="label">Total Revenue</div>
    </div>
</div>

<div class="card">
    <div class="card-title">Recent Appointments</div>
    @if($recentAppointments->isEmpty())
        <p style="color:#888;font-size:14px;">No appointments yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Price</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentAppointments as $appt)
                <tr>
                    <td>{{ $appt->id }}</td>
                    <td>{{ $appt->customer_name }}</td>
                    <td>{{ $appt->service->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y h:i A') }}</td>
                    <td>₱{{ number_format($appt->service->price ?? 0, 2) }}</td>
                    <td>
                        @if($appt->payment)
                            <span class="badge badge-{{ $appt->payment->status === 'paid' ? 'success' : 'danger' }}">
                                {{ ucfirst($appt->payment->status) }}
                            </span>
                        @else
                            <span class="badge badge-warning">No Payment</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
