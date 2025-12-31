@extends('layouts.app')
@section('title','تعديل المهمة')

@section('content')
<a href="{{ route('tasks.show', $task['id']) }}" class="btn-back">
    <i class="fas fa-arrow-right"></i> رجوع للمهمة
</a>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 25px;">
        <i class="fas fa-pen"></i> تعديل المهمة
    </h2>

    <form method="POST" action="{{ route('tasks.update', $task['id']) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>عنوان المهمة</label>
            <input class="form-control" name="title" value="{{ old('title', $task['title']) }}">
            @error('title') <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>تاريخ التسليم</label>
            <input class="form-control" type="date" name="due_date" value="{{ old('due_date', $task['due_date']) }}">
            @error('due_date') <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>الحالة</label>
            <select class="form-control" name="status">
                <option value="pending" {{ old('status', $task['status']) === 'pending' ? 'selected' : '' }}>قيد التنفيذ</option>
                <option value="done" {{ old('status', $task['status']) === 'done' ? 'selected' : '' }}>منجزة</option>
            </select>
            @error('status') <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>وصف إضافي (اختياري)</label>
            <textarea class="form-control" name="description" rows="4">{{ old('description', $task['description'] ?? '') }}</textarea>
            @error('description') <div style="color:var(--danger); margin-top:6px;">{{ $message }}</div> @enderror
        </div>

        <button class="btn-submit" type="submit">حفظ التعديل</button>
    </form>
</div>
@endsection
