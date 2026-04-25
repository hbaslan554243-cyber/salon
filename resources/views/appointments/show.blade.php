@extends('layouts.app')
@section('title', 'Appointment Details')
@section('content')
<div class="card" style="max-width:650px;margin:0 auto;">
    <div class="action-bar">
        <div class="card-title" style="margin:0;">Appointment #{{ $appointment->id }}</div>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-sm">← Back</a>
    </div>

    <table style="margin-top:8px;">
        <tr><th style="width:35%;">Customer Name</th><td>{{ $appointment->customer_name }}</td></tr>
        <tr><th>Contact</th><td>{{ $appointment->customer_contact }}</td></tr>
        <tr><th>Email</th><td>{{ $appointment->customer_email ?: '-' }}</td></tr>
        <tr><th>Service</th><td>{{ $appointment->service->name ?? '-' }}</td></tr>
        <tr><th>Price</th><td>₱{{ number_format($appointment->service->price ?? 0, 2) }}</td></tr>
        <tr><th>Duration</th><td>{{ $appointment->service->duration ?? '-' }}</td></tr>
        <tr><th>Date & Time</th><td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y h:i A') }}</td></tr>
        <tr><th>Notes</th><td>{{ $appointment->notes ?: '-' }}</td></tr>
        <tr>
            <th>Payment Status</th>
            <td>
                @if($appointment->payment)
                    <span class="badge badge-{{ $appointment->payment->status === 'paid' ? 'success' : 'danger' }}">
                        {{ ucfirst($appointment->payment->status) }}
                    </span>
                    &nbsp;
                    @if($appointment->payment->status === 'paid')
                        Paid ₱{{ number_format($appointment->payment->amount_paid, 2) }} on {{ \Carbon\Carbon::parse($appointment->payment->paid_at)->format('M d, Y') }}
                    @endif
                @else
                    <span class="badge badge-warning">No payment record</span>
                @endif
            </td>
        </tr>
    </table>

    <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning btn-sm">Edit</a>
        @if(!$appointment->payment)
            <a href="{{ route('payments.create', ['appointment_id' => $appointment->id]) }}" class="btn btn-success btn-sm">Process Payment</a>
        @elseif($appointment->payment->status === 'unpaid')
            <a href="{{ route('payments.edit', $appointment->payment) }}" class="btn btn-success btn-sm">Mark as Paid</a>
        @endif
    </div>
</div>
@endsection
