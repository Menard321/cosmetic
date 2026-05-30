@extends('layouts.admin')
@section('title', 'Edit Employee: ' . $employee->full_name)
@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.ems.employees.show', $employee) }}" class="w-9 h-9 flex items-center justify-center bg-surface-container-high rounded-xl hover:bg-surface-variant transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    </a>
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary">EMS · Edit Staff Member</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Update Profile: {{ $employee->full_name }}</h1>
    </div>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6">
    <ul class="text-sm text-red-700 space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ route('admin.ems.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PATCH')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Personal Info --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">person</span> Personal Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Full Name *</label>
                    <input name="full_name" value="{{ old('full_name', $employee->full_name) }}" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="Enter full name">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Gender *</label>
                    <select name="gender" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        <option value="male" {{ old('gender', $employee->gender)=='male'?'selected':'' }}>Male</option>
                        <option value="female" {{ old('gender', $employee->gender)=='female'?'selected':'' }}>Female</option>
                        <option value="other" {{ old('gender', $employee->gender)=='other'?'selected':'' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth?->format('Y-m-d')) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">National ID</label>
                    <input name="national_id" value="{{ old('national_id', $employee->national_id) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="National ID number">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Phone *</label>
                    <input name="phone" value="{{ old('phone', $employee->phone) }}" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="+255 7XX XXX XXX">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="employee@niffer.co.tz">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Residential Address</label>
                    <textarea name="address" rows="2" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Home address">{{ old('address', $employee->address) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Emergency Contact Name</label>
                    <input name="emergency_contact_name" value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Contact person name">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Emergency Contact Phone</label>
                    <input name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="+255 7XX XXX XXX">
                </div>
            </div>
        </div>

        {{-- Employment Info --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">work</span> Employment Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Position / Job Title *</label>
                    <input name="position" value="{{ old('position', $employee->position) }}" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="e.g. Sales Representative">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Department</label>
                    <input name="department" value="{{ old('department', $employee->department) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" list="dept-list" placeholder="e.g. Sales, HR, Finance">
                    <datalist id="dept-list">
                        @foreach(['Sales','Marketing','HR','Finance','Operations','IT','Customer Service','Inventory'] as $d)
                        <option value="{{ $d }}">
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Branch Assignment</label>
                    <select name="branch_id" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        <option value="">No Branch (HQ)</option>
                        @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ old('branch_id', $employee->branch_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Employment Type *</label>
                    <select name="employment_type" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        @foreach(['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','internship'=>'Internship'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('employment_type', $employee->employment_type)==$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Date Hired *</label>
                    <input type="date" name="date_hired" value="{{ old('date_hired', $employee->date_hired?->format('Y-m-d')) }}" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Contract End Date</label>
                    <input type="date" name="contract_end" value="{{ old('contract_end', $employee->contract_end?->format('Y-m-d')) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Reporting Manager</label>
                    <select name="reporting_manager_id" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        <option value="">None</option>
                        @foreach($managers as $m)
                        <option value="{{ $m->id }}" {{ old('reporting_manager_id', $employee->reporting_manager_id)==$m->id?'selected':'' }}>{{ $m->full_name }} · {{ $m->position }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Employment Status *</label>
                    <select name="status" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        @foreach(['active'=>'Active','inactive'=>'Inactive','suspended'=>'Suspended','terminated'=>'Terminated','on_leave'=>'On Leave'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status', $employee->status)==$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Payroll Info --}}
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">payments</span> Payroll Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Basic Salary (TZS) *</label>
                    <input type="number" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" required min="0" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Payment Method *</label>
                    <select name="payment_method" id="payment_method" required class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                        <option value="cash" {{ old('payment_method', $employee->payment_method)=='cash'?'selected':'' }}>Cash</option>
                        <option value="mobile_money" {{ old('payment_method', $employee->payment_method)=='mobile_money'?'selected':'' }}>Mobile Money (M-Pesa / Tigo)</option>
                        <option value="bank" {{ old('payment_method', $employee->payment_method)=='bank'?'selected':'' }}>Bank Transfer</option>
                    </select>
                </div>

                {{-- Bank Details --}}
                <div id="bank-details" class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 hidden">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Bank Name</label>
                        <input name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="e.g. CRDB, NMB">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Account Name</label>
                        <input name="account_name" value="{{ old('account_name', $employee->account_name) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Holder Name">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Account Number</label>
                        <input name="account_number" value="{{ old('account_number', $employee->account_number) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="XXXX XXXX XXXX">
                    </div>
                </div>

                {{-- Mobile Money Details --}}
                <div id="mobile-money-details" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Provider Name</label>
                        <select name="mobile_money_name" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20">
                            <option value="M-Pesa" {{ old('mobile_money_name', $employee->mobile_money_name)=='M-Pesa'?'selected':'' }}>M-Pesa</option>
                            <option value="Tigo Pesa" {{ old('mobile_money_name', $employee->mobile_money_name)=='Tigo Pesa'?'selected':'' }}>Tigo Pesa</option>
                            <option value="Airtel Money" {{ old('mobile_money_name', $employee->mobile_money_name)=='Airtel Money'?'selected':'' }}>Airtel Money</option>
                            <option value="Halopesa" {{ old('mobile_money_name', $employee->mobile_money_name)=='Halopesa'?'selected':'' }}>Halopesa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Mobile Number</label>
                        <input name="mobile_money_number" value="{{ old('mobile_money_number', $employee->mobile_money_number) }}" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="+255 7XX XXX XXX">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Notes</label>
                    <textarea name="notes" rows="2" class="w-full border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Additional notes about this employee">{{ old('notes', $employee->notes) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div class="space-y-6">
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">photo_camera</span> Profile Photo
            </h2>
            <div class="flex flex-col items-center gap-4">
                <div id="photo-preview" class="w-32 h-32 rounded-2xl bg-surface-container-high border border-outline-variant flex items-center justify-center overflow-hidden">
                    <img src="{{ $employee->photo_url }}" class="w-full h-full object-cover">
                </div>
                <label class="cursor-pointer w-full">
                    <input type="file" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                    <div class="w-full py-2.5 bg-surface-container-high hover:bg-primary hover:text-white text-on-surface text-center rounded-xl text-sm font-bold transition-all">
                        Change Photo
                    </div>
                </label>
            </div>
        </div>

        <button type="submit" class="w-full py-3.5 bg-primary text-white rounded-2xl font-black uppercase tracking-widest hover:bg-on-background transition-all shadow-lg shadow-primary/20">
            Save Changes
        </button>
        <a href="{{ route('admin.ems.employees.show', $employee) }}" class="block w-full py-3 bg-surface-container-high text-center text-on-surface rounded-2xl font-bold text-sm hover:bg-surface-variant transition-all">
            Cancel
        </a>
    </div>
</div>
</form>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photo-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle Payment Details
const paymentMethod = document.getElementById('payment_method');
const bankDetails = document.getElementById('bank-details');
const mobileMoneyDetails = document.getElementById('mobile-money-details');

function togglePaymentFields() {
    bankDetails.classList.add('hidden');
    mobileMoneyDetails.classList.add('hidden');
    
    if (paymentMethod.value === 'bank') {
        bankDetails.classList.remove('hidden');
    } else if (paymentMethod.value === 'mobile_money') {
        mobileMoneyDetails.classList.remove('hidden');
    }
}

paymentMethod.addEventListener('change', togglePaymentFields);
window.addEventListener('DOMContentLoaded', togglePaymentFields);
</script>
@endsection
