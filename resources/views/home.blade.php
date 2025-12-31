@extends('layouts.app')
@section('title','الرئيسية')

@section('content')
<div class="hero-card">
    <h1>مرحباً بك في نظام متابعة المهام الدراسية</h1>
    <p>النظام الذي يساعدك على تنظيم واجباتك ومواعيد التسليم بكل سهولة</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $total }}</div>
        <p>إجمالي المهام</p>
    </div>

    <div class="stat-card">
        <div class="stat-number" style="color: #e67e22">{{ $pending }}</div>
        <p>قيد الانتظار</p>
    </div>

    <div class="stat-card">
        <div class="stat-number" style="color: var(--danger)">{{ $expired }}</div>
        <p>متأخرة</p>
    </div>

    <div class="stat-card">
        <div class="stat-number" style="color: var(--success)">{{ $done }}</div>
        <p>منجزة</p>
    </div>
</div>
@endsection
