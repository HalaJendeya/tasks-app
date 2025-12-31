<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام متابعة المهام الدراسية')</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>

<nav>
    <div class="logo">
        <i class="fas fa-graduation-cap"></i>
        مدرستي
    </div>

    <ul class="nav-links">
        <li>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                الرئيسية
            </a>
        </li>

        <li>
            <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.index') || request()->routeIs('tasks.show') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                قائمة المهام
            </a>
        </li>

        <li>
            <a href="{{ route('tasks.create') }}" class="btn-add {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i>
                إضافة مهمة
            </a>
        </li>
    </ul>
</nav>

<div class="container">
    @if(session('success'))
        <div class="card" style="border-right:4px solid var(--success); margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>
