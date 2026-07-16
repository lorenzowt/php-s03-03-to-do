<?php
$taskList = $this->taskList;
$totalTasks = count($taskList);
$stateCount = ['pending' => 0, 'started' => 0, 'completed' => 0];
foreach ($taskList as $task) {
    $state = $task->getTaskState()->value;
    $stateCount[$state]++;
}
$stateStyles = [
    'pending' => ['label' => 'To do', 'class' => 'bg-amber-50 text-amber-700 ring-amber-600/20'],
    'started' => ['label' => 'In progress', 'class' => 'bg-sky-50 text-sky-700 ring-sky-600/20'],
    'completed' => ['label' => 'Completed', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'],
];
?>
<div class="max-w-2xl mx-auto">
    <section class="mb-8 mt-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">My tasks</h1>
            <p class="mt-2 text-slate-600">A simple view of everything that needs your attention.</p>
        </div>
        <a href="<?= $this->baseUrl() ?>/task/new" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create a task <span aria-hidden="true">→</span></a>
    </section>

    <section class="mb-8 grid gap-4 sm:grid-cols-3" aria-label="Task summary">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">All tasks</p><p class="mt-2 text-3xl font-bold tracking-tight"><?= $totalTasks ?></p></div>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-5"><p class="text-sm font-medium text-amber-700">To do</p><p class="mt-2 text-3xl font-bold tracking-tight text-amber-900"><?= $stateCount['pending'] ?></p></div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-5"><p class="text-sm font-medium text-emerald-700">Completed</p><p class="mt-2 text-3xl font-bold tracking-tight text-emerald-900"><?= $stateCount['completed'] ?></p></div>
    </section>

    <?php if (empty($taskList)): ?>
        <section class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-soft">
            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-indigo-50 text-2xl text-indigo-600">✓</div>
            <h2 class="mt-5 text-xl font-bold">Your task list is clear</h2>
            <p class="mt-2 text-slate-600">Create your first task to start planning your day.</p>
            <a href="<?= $this->baseUrl() ?>/task/new" class="mt-6 inline-flex rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">Create first task</a>
        </section>
    <?php else: ?>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6"><h2 class="font-bold">Task list</h2><span class="text-sm text-slate-500"><?= $totalTasks ?> <?= $totalTasks === 1 ? 'task' : 'tasks' ?></span></div>
            <div class="divide-y divide-slate-100">
                <?php foreach ($taskList as $task): ?>
                    <?php $state = $task->getTaskState()->value; $style = $stateStyles[$state] ?? $stateStyles['pending']; ?>
                    <a href="<?= $this->baseUrl() ?>/task/show?id=<?= $task->getId() ?>" class="group flex flex-col gap-4 px-5 py-5 transition hover:bg-slate-50 sm:flex-row sm:items-center sm:px-6">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-slate-100 text-sm font-bold text-slate-600">#<?= $task->getId() ?></span>
                        <span class="min-w-0 flex-1"><span class="block truncate font-semibold text-slate-900 group-hover:text-indigo-700"><?= htmlspecialchars($task->getTitle()) ?></span><span class="mt-1 block text-sm text-slate-500"><?= $task->getStartTime() ? 'Started ' . htmlspecialchars($task->getStartTime()) : 'Not started yet' ?></span></span>
                        <span class="inline-flex w-fit items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset <?= $style['class'] ?>"><?= $style['label'] ?></span>
                        <span class="hidden text-lg text-slate-400 transition group-hover:translate-x-1 group-hover:text-indigo-600 sm:block" aria-hidden="true">→</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>