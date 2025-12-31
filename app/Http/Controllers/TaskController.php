<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // قائمة المهام
    public function index()
    {
        $tasks = session()->get('tasks', []);
        return view('tasks.index', compact('tasks'));
    }

    // صفحة إضافة مهمة
    public function create()
    {
        return view('tasks.create');
    }

    // حفظ مهمة (Validation + Session)
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:100',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,done',
            'description' => 'nullable|string|max:500',
        ]);

        $tasks = session()->get('tasks', []);

        $newId = empty($tasks) ? 1 : (max(array_column($tasks, 'id')) + 1);

        $task = [
            'id' => $newId,
            'title' => $validated['title'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $tasks[] = $task;
        session()->put('tasks', $tasks);

        return redirect()->route('tasks.index')->with('success', 'تمت إضافة المهمة بنجاح ✅');
    }


    public function show($id)
    {
        $tasks = session()->get('tasks', []);

        // ابحث عن المهمة بالـ id
        $task = collect($tasks)->firstWhere('id', (int)$id);

        abort_unless($task, 404);

        // تاريخ عربي مثل: ١ نوفمبر ٢٠١٢
        $task['due_date_ar'] = $this->arabicDate($task['due_date']);

        return view('tasks.show', compact('task'));
    }

    // دالة لإظهار التاريخ بالعربي: ١ نوفمبر ٢٠١٢
    private function arabicDate($date)
    {
        $months = [
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر'
        ];

        $ts = strtotime($date);
        $day = (int)date('j', $ts);
        $month = (int)date('n', $ts);
        $year = (int)date('Y', $ts);

        // تحويل الأرقام إلى هندية عربية
        $map = ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩'];
        $toArabicDigits = function ($num) use ($map) {
            return strtr((string)$num, $map);
        };

        return $toArabicDigits($day) . ' ' . $months[$month] . ' ' . $toArabicDigits($year);
    }

    public function edit($id)
    {
        $tasks = session()->get('tasks', []);
        $task = collect($tasks)->firstWhere('id', (int)$id);

        abort_unless($task, 404);

        return view('tasks.edit', compact('task'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:100',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,done',
            'description' => 'nullable|string|max:500',
        ]);

        $tasks = session()->get('tasks', []);

        $index = collect($tasks)->search(fn($t) => (int)$t['id'] === (int)$id);
        abort_unless($index !== false, 404);

        $tasks[$index] = array_merge($tasks[$index], [
            'title' => $validated['title'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? '',
        ]);

        session()->put('tasks', $tasks);

        return redirect()->route('tasks.show', $id)->with('success', 'تم تحديث المهمة ✅');
    }

    public function destroy($id)
    {
        $tasks = session()->get('tasks', []);

        $tasks = array_values(array_filter($tasks, fn($t) => (int)$t['id'] !== (int)$id));

        session()->put('tasks', $tasks);

        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة ✅');
    }
}
