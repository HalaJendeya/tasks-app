<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    $tasks = session()->get('tasks', []);

    $total = count($tasks);
    $done = count(array_filter($tasks, fn($t) => ($t['status'] ?? '') === 'done'));
    $pending = count(array_filter($tasks, fn($t) => ($t['status'] ?? '') === 'pending'));
    $expired = count(array_filter($tasks, function ($t) {
        $due = $t['due_date'] ?? null;
        return ($t['status'] ?? '') === 'pending'
            && $due
            && strtotime($due) < strtotime(date('Y-m-d'));
    }));

    return view('home', compact('total', 'done', 'pending', 'expired'));
})->name('home');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

