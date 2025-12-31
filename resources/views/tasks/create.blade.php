@extends('layouts.app')
@section('title','إضافة مهمة')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 25px;">
        <i class="fas fa-file-signature"></i> إضافة مهمة
    </h2>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="form-group">
            <label>عنوان المهمة</label>
            <input class="form-control" name="title" value="{{ old('title') }}" placeholder="أدخل عنوان المهمة...">
            @error('title')
                <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>تاريخ التسليم</label>
            <input class="form-control" type="date" name="due_date" value="{{ old('due_date') }}">
            @error('due_date')
                <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>الحالة</label>
            <select class="form-control" name="status">
                <option value="pending" {{ old('status','pending') === 'pending' ? 'selected' : '' }}>قيد التنفيذ</option>
                <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>منجزة</option>
            </select>
            @error('status')
                <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>وصف إضافي</label>
            <textarea class="form-control" name="description" rows="4" placeholder="تفاصيل المهمة...">{{ old('description') }}</textarea>
            @error('description')
                <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn-submit" type="submit">حفظ المهمة</button>
    </form>
</div>
@endsection
