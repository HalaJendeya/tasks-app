@extends('layouts.app')
@section('title','عرض المهمة')

@section('content')

<a href="{{ route('tasks.index') }}" class="btn-back" style="float:left;">
    <i class="fas fa-arrow-left"></i> عودة للقائمة
</a>
<div style="clear:both;"></div>

@php
    $status = $task['status'] ?? 'pending';
    $due = $task['due_date'] ?? date('Y-m-d');

    $isExpired = ($status === 'pending' && strtotime($due) < strtotime(date('Y-m-d')));

    if ($status === 'done') {
        $badgeClass = 'bg-done';
        $badgeText  = 'Done';
    } elseif ($isExpired) {
        // إذا عندك في css كلاس expired استخدميه، وإذا لا خليه pending مع لون مختلف
        $badgeClass = 'bg-expired';
        $badgeText  = 'Expired';
    } else {
        $badgeClass = 'bg-pending';
        $badgeText  = 'Pending';
    }
@endphp

<div class="card">

    <div class="task-detail-header">
        <div>
            <h2 style="margin:0;">{{ $task['title'] }}</h2>
            <p style="margin:8px 0 0; color:#888;">رقم المهمة: #{{ $task['id'] }}</p>
        </div>

        <div>
            <span class="status-badge {{ $badgeClass }}">{{ $badgeText }}</span>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-calendar"></i> تاريخ التسليم:</div>
        <div class="detail-value">{{ $task['due_date_ar'] ?? $task['due_date'] }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-info-circle"></i> الوصف:</div>
        <div class="detail-value">
            {{ $task['description'] ?: '—' }}
        </div>
    </div>

    <div class="detail-row" style="border-bottom:none;">
        <div class="detail-label"><i class="fas fa-clock"></i> المدة المتبقية:</div>
        <div class="detail-value">
            @if($status === 'done')
                تم الانتهاء ✅
            @else
                @php
                    $days = floor((strtotime($due) - strtotime(date('Y-m-d'))) / 86400);
                @endphp

                @if($days > 0)
                    متبقي {{ $days }} يوم
                @elseif($days == 0)
                    اليوم آخر موعد للتسليم
                @else
                    متأخرة منذ {{ abs($days) }} يوم
                @endif
            @endif
        </div>
    </div>

<div style="margin-top:20px; display:flex; gap:10px;">
    <a href="{{ route('tasks.edit', $task['id']) }}" class="action-btn" style="background:#95a5a6;">تعديل</a>

    <form method="POST" action="{{ route('tasks.destroy', $task['id']) }}" onsubmit="return confirm('متأكد بدك تحذف المهمة؟')">
        @csrf
        @method('DELETE')
        <button type="submit" class="action-btn" style="background:var(--danger);">حذف</button>
    </form>
</div>


</div>
@endsection
