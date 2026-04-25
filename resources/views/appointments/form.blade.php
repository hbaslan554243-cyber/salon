@extends('layouts.app')
@section('title', isset($appointment) ? 'Edit Appointment' : 'New Appointment')
@section('content')
<div class="card" style="max-width:650px;margin:0 auto;">
    <div class="card-title">{{ isset($appointment) ? 'Edit Appointment' : 'Book New Appointment' }}</div>

    @if($errors->any())
        <div class="errors">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}" method="POST">
        @csrf
        @if(isset($appointment)) @method('PUT') @endif

        <div class="form-row">
            <div class="form-group">
                <label>Customer Name *</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $appointment->customer_name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Contact Number *</label>
                <input type="text" name="customer_contact" class="form-control" value="{{ old('customer_contact', $appointment->customer_contact ?? '') }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Email (optional)</label>
            <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $appointment->customer_email ?? '') }}">
        </div>
        <div class="form-group">
            <label>Service *</label>
            <select name="service_id" class="form-control" required onchange="updatePrice(this)">
                <option value="">-- Select Service --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        data-price="{{ $service->price }}"
                        data-duration="{{ $service->duration }}"
                        {{ old('service_id', $appointment->service_id ?? '') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }} (₱{{ number_format($service->price, 2) }} - {{ $service->duration }})
                    </option>
                @endforeach
            </select>
        </div>
        <div id="service-info" style="background:#f8f0ff;border-radius:4px;padding:10px 14px;font-size:13px;margin-bottom:16px;display:none;">
            <strong>Price:</strong> <span id="info-price">-</span> &nbsp;|&nbsp;
            <strong>Duration:</strong> <span id="info-duration">-</span>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Appointment Date *</label>
                <input type="date" name="appointment_date" class="form-control"
                    value="{{ old('appointment_date', isset($appointment) ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '') }}"
                    min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>Appointment Time *</label>
                <input type="time" name="appointment_time" class="form-control"
                    value="{{ old('appointment_time', isset($appointment) ? \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') : '') }}"
                    required>
            </div>
        </div>
        <div class="form-group">
            <label>Notes (optional)</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $appointment->notes ?? '') }}</textarea>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn btn-primary">{{ isset($appointment) ? 'Update Booking' : 'Book Appointment' }}</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
function updatePrice(sel) {
    const opt = sel.options[sel.selectedIndex];
    const info = document.getElementById('service-info');
    if (opt.value) {
        document.getElementById('info-price').textContent = '₱' + parseFloat(opt.dataset.price).toFixed(2);
        document.getElementById('info-duration').textContent = opt.dataset.duration;
        info.style.display = 'block';
    } else { info.style.display = 'none'; }
}
window.addEventListener('load', function() {
    const sel = document.querySelector('select[name=service_id]');
    if (sel && sel.value) updatePrice(sel);
});
</script>
@endsection
