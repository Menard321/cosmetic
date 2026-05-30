@extends('layouts.admin')
@section('title', 'Performance Reviews')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-[10px] uppercase font-black tracking-[0.3em] text-primary mb-1">EMS · HR</p>
        <h1 class="font-headline-sm text-2xl text-on-surface">Performance Management</h1>
    </div>
    <button onclick="document.getElementById('review-modal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-on-background text-white rounded-xl text-sm font-bold hover:bg-primary transition-all">
        <span class="material-symbols-outlined text-[18px]">rate_review</span> Add Review
    </button>
</div>

{{-- Top Performer Card --}}
@if($topPerformer)
<div class="bg-gradient-to-r from-on-background via-primary to-on-background rounded-2xl p-6 mb-6 text-white shadow-xl flex items-center gap-6">
    <div class="w-16 h-16 rounded-2xl bg-primary-container/20 border-2 border-primary-container overflow-hidden flex-shrink-0">
        <img src="{{ $topPerformer->employee->photo_url }}" class="w-full h-full object-cover" alt="">
    </div>
    <div>
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-container mb-1">🏆 Top Performer — {{ \Carbon\Carbon::createFromDate($year,$month,1)->format('F Y') }}</p>
        <h2 class="font-bold text-xl">{{ $topPerformer->employee->full_name }}</h2>
        <p class="text-white/60 text-sm">{{ $topPerformer->employee->position }} · {{ $topPerformer->employee->branch?->name }}</p>
    </div>
    <div class="ml-auto text-right">
        <p class="font-black text-4xl text-primary-container">{{ $topPerformer->overall_score }}%</p>
        <p class="text-white/60 text-xs uppercase font-bold">Overall Score</p>
    </div>
</div>
@endif

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-violet-200 rounded-2xl p-4 shadow-sm">
        <p class="text-xl font-black text-violet-600">{{ number_format($stats['avg_score'],1) }}%</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Avg Score</p>
    </div>
    <div class="bg-white border border-emerald-200 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-emerald-600">{{ $stats['outstanding'] }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Outstanding</p>
    </div>
    <div class="bg-white border border-blue-200 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-blue-600">{{ $stats['excellent'] }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Excellent</p>
    </div>
    <div class="bg-white border border-primary/30 rounded-2xl p-4 shadow-sm">
        <p class="text-2xl font-black text-primary">{{ $reviews->total() }}</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase mt-1">Total Reviews</p>
    </div>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl p-4 mb-6 shadow-sm">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <select name="month" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            @for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $month==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>@endfor
        </select>
        <input type="number" name="year" value="{{ $year }}" min="2020" max="2030" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
        <select name="branch_id" class="border border-outline-variant rounded-xl px-4 py-2 text-sm">
            <option value="">All Branches</option>
            @foreach($branches as $b)<option value="{{ $b->id }}" {{ request('branch_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
        </select>
        <button type="submit" class="bg-primary text-white rounded-xl py-2 text-sm font-bold">Filter</button>
    </form>
</div>

<div class="bg-white border border-outline-variant/30 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="px-4 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">#</th>
                    <th class="px-6 py-3 text-left text-[10px] font-black uppercase text-on-surface-variant">Employee</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Sales</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Attendance</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Tasks</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Customer</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Overall</th>
                    <th class="px-4 py-3 text-center text-[10px] font-black uppercase text-on-surface-variant">Rating</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($reviews as $i => $rev)
                <tr class="hover:bg-surface-container-low {{ $i===0?'bg-primary/3':'' }}">
                    <td class="px-4 py-3">
                        <div class="w-7 h-7 rounded-full {{ $i===0?'bg-primary text-white':($i===1?'bg-secondary text-white':($i===2?'bg-amber-600 text-white':'bg-surface-container-high text-on-surface-variant')) }} flex items-center justify-center text-xs font-black">
                            {{ $reviews->firstItem() + $i }}
                        </div>
                    </td>
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $rev->employee->photo_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-bold text-on-surface">{{ $rev->employee->full_name }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $rev->employee->branch?->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span class="font-black text-sm">{{ $rev->sales_score }}%</span>
                            <div class="w-12 bg-surface-container-high rounded-full h-1.5 mt-1"><div class="bg-blue-500 h-1.5 rounded-full" style="width:{{ $rev->sales_score }}%"></div></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span class="font-black text-sm">{{ $rev->attendance_score }}%</span>
                            <div class="w-12 bg-surface-container-high rounded-full h-1.5 mt-1"><div class="bg-emerald-500 h-1.5 rounded-full" style="width:{{ $rev->attendance_score }}%"></div></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span class="font-black text-sm">{{ $rev->task_completion }}%</span>
                            <div class="w-12 bg-surface-container-high rounded-full h-1.5 mt-1"><div class="bg-violet-500 h-1.5 rounded-full" style="width:{{ $rev->task_completion }}%"></div></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span class="font-black text-sm">{{ $rev->customer_rating }}%</span>
                            <div class="w-12 bg-surface-container-high rounded-full h-1.5 mt-1"><div class="bg-amber-500 h-1.5 rounded-full" style="width:{{ $rev->customer_rating }}%"></div></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center"><span class="font-black text-lg text-primary">{{ $rev->overall_score }}%</span></td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase
                            {{ $rev->rating==='outstanding'?'bg-emerald-100 text-emerald-700':($rev->rating==='excellent'?'bg-blue-100 text-blue-700':($rev->rating==='good'?'bg-violet-100 text-violet-700':($rev->rating==='fair'?'bg-amber-100 text-amber-700':'bg-red-100 text-red-700'))) }}">
                            {{ $rev->rating }}{{ $rev->top_performer?' 🏆':'' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">No reviews this period. Add reviews with the button above.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())<div class="px-6 py-4 border-t border-outline-variant/20">{{ $reviews->links() }}</div>@endif
</div>

{{-- Add Review Modal --}}
<div id="review-modal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-on-surface">Add Performance Review</h3>
            <button onclick="document.getElementById('review-modal').classList.add('hidden')" class="w-8 h-8 bg-surface-container-high rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        </div>
        <form action="{{ route('admin.ems.performance.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Employee</label>
                    <select name="employee_id" required class="w-full border border-outline-variant rounded-xl px-4 py-2 text-sm">
                        <option value="">Select employee</option>
                        @foreach(\App\Models\Employee::where('status','active')->orderBy('full_name')->get() as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Month</label>
                        <select name="month" class="w-full border border-outline-variant rounded-xl px-3 py-2 text-sm">
                            @for($m=1;$m<=12;$m++)<option value="{{ $m }}" {{ $month==$m?'selected':'' }}>{{ \Carbon\Carbon::create()->month($m)->format('M') }}</option>@endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Year</label>
                        <input type="number" name="year" value="{{ $year }}" class="w-full border border-outline-variant rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>
            </div>
            @foreach(['sales_score'=>'Sales Score','attendance_score'=>'Attendance Score','task_completion'=>'Task Completion','customer_rating'=>'Customer Rating'] as $field=>$label)
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">{{ $label }} (0–100)</label>
                <div class="flex items-center gap-3">
                    <input type="range" name="{{ $field }}" min="0" max="100" value="80" class="flex-1" oninput="document.getElementById('val-{{ $field }}').textContent=this.value+'%'">
                    <span id="val-{{ $field }}" class="font-black text-primary w-12 text-right">80%</span>
                </div>
            </div>
            @endforeach
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Feedback</label>
                <textarea name="feedback" rows="2" class="w-full border border-outline-variant rounded-xl px-4 py-2 text-sm" placeholder="Overall feedback..."></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Areas of Improvement</label>
                <textarea name="areas_of_improvement" rows="2" class="w-full border border-outline-variant rounded-xl px-4 py-2 text-sm" placeholder="Areas to improve..."></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-primary text-white rounded-xl font-bold hover:bg-on-background transition-all">Save Review</button>
        </form>
    </div>
</div>
@endsection
