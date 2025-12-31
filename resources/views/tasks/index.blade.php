@extends('layouts.app')
@section('title','قائمة المهام')

@section('content')
<div class="card">
    <h2><i class="fas fa-tasks"></i> قائمة المهام</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>عنوان المهمة</th>
                <th>تاريخ التسليم</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tasks as $t)
            @php
                $badge = $t['status'] === 'done' ? 'bg-done' : 'bg-pending';
                $text  = $t['status'] === 'done' ? 'Done' : 'Pending';
            @endphp
            <tr>
                <td>{{ $t['id'] }}</td>
                <td>{{ $t['title'] }}</td>
                <td>{{ $t['due_date'] }}</td>
                <td><span class="status-badge {{ $badge }}">{{ $text }}</span></td>
                <td>
                    <a class="action-btn btn-view" href="{{ route('tasks.show', $t['id']) }}">عرض</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:25px;">لا توجد مهام بعد.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
