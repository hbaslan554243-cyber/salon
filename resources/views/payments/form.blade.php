@extends('layouts.app')
@section('title', isset($payment) ? 'Edit Payment' : 'Record Payment')
@section('content')
<div class="card" style="max-width:580px;margin:0 auto;">
    <div class="card-title">{{ isset($payment) ? 'Edit Payment' : 'Record Payment' }}</div>

    @if($errors->any())
        <div class="errors">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($payment) ? route('payments.update', $payment) : route('payments.store') }}" method="POST">
        @csrf
        @if(isset($payment)) @method('PUT') @endif

        <div class="form-group">
            <label>Appointment *</label>
            <select name="appointment_id" class="form-control" required onchange="fillAmount(this)">
                <option value="">-- Select Appointment --</option>
                @foreach($appointments as $appt)
                    <option value="{{ $appt->id }}"
                        data-price="{{ $appt->service->price ?? 0 }}"
                        {{ old('appointment_id', $payment->appointment_id ?? request('appointment_id')) == $appt->id ? 'selected' : '' }}>
                        #{{ $appt->id }} - {{ $appt->customer_name }} ({{ $appt->service->name ?? '?' }} - {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Amount Paid (₱) *</label>
                <input type="number" name="amount_paid" id="amount_paid" class="form-control"
                    value="{{ old('amount_paid', $payment->amount_paid ?? '') }}"
                    step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control">
                    @foreach(['cash'=>'Cash','gcash'=>'GCash','card'=>'Card','bank_transfer'=>'Bank Transfer','other'=>'Other'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('payment_method', $payment->payment_method ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Payment Status *</label>
                <select name="status" class="form-control" required onchange="toggleDate(this)">
                    <option value="unpaid" {{ old('status', $payment->status ?? '') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ old('status', $payment->status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="form-group" id="paid-date-group">
                <label>Date Paid</label>
                <input type="date" name="paid_at" class="form-control"
                    value="{{ old('paid_at', isset($payment) && $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : date('Y-m-d')) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Notes (optional)</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $payment->notes ?? '') }}</textarea>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn btn-primary">{{ isset($payment) ? 'Update Payment' : 'Save Payment' }}</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
function fillAmount(sel) {
    const opt = sel.options[sel.selectedIndex];
    if (opt.value && !document.getElementById('amount_paid').value) {
        document.getElementById('amount_paid').value = parseFloat(opt.dataset.price).toFixed(2);
    }
}
function toggleDate(sel) {
    document.getElementById('paid-date-group').style.display = sel.value === 'paid' ? 'block' : 'none';
}
window.addEventListener('load', function() {
    const s = document.querySelector('select[name=appointment_id]');
    const st = document.querySelector('select[name=status]');
    if (s && s.value) fillAmount(s);
    if (st) toggleDate(st);
});
</script>
@endsection
