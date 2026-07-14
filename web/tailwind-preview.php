<!DOCTYPE html>
<?php
$task = [
    'title' => 'Complete a feature',
    'taskState' => 'pending',
    'startTime' => null,
    'endTime' => null,
    'userId' => 1,
    'id' => 1
];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4f46e5">
    <link rel="stylesheet" href="stylesheets/output.css">
    <title>Taskboard</title>
</head>
<body class="min-h-screen bg-cornsilk-200 text-stone-800 antialiased">
    <header class=" bg-orange-100">
        <div class="flex mx-auto max-w-6xl justify-between py-6">
            <a 
            href="/"
            class=" mx-auto text-3xl text-light-bronze-800 font-semibold tracking-tight hover:underline decoration-4 underline-offset-7"
            >
                Taskette
            </a>
            <a 
            href="/"
            class="mx-auto bg-light-bronze-300 rounded-2xl px-6 py-2.5 text-base font-semibold shadow-sm ring-2 ring-orange-100 text-light-bronze-900"
            >
                New task
            </a>
        </div>
    </header>
    <main>
	    <section class="mx-auto max-w-2xl px-4">
            <div class=" mx-auto mt-5 rounded-2xl max-w-xl shadow-sm bg-white text-light-bronze-800 ring-1 ring-chartreuse-100">
                <div class=" flex flex-col items-center justify-center rounded-t-2xl py-2 bg-linear-to-r from-chartreuse-50 to-malachite-green-100 border-b-2 border-chartreuse-100 ">
                    <p class =" py-5 px-5 pb-1 font-semibold text-2xl text-malachite-green-800">Task Created Successfully!</p>
                    <svg class=" w-12 h-12 mb-3 opacity-80 text-malachite-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path class="shadow-2xl" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="mx-auto max-w-md flex flex-col justify-center items-center">
                        <div class="mx-auto flex justify-center items-center py-4 pt-6">
                           <p class=" text-lg">The following task has been created</p>
                        </div>
                        <div class="mx-auto w-60 bg-chartreuse-50 opacity-50 flex flex-col justify-center items-center py-3 px-5 mb-6">
                            <p class="w-full break-words text-center">#<?= $task['id'] ?> <?= $task['title'] ?> </p>
                            <p class="w-full break-words text-center">State: <?= $task['taskState'] ?> </p>
                        </div>
                        <div class="mx-auto flex justify-center items-center gap-5 py-4">
                            <a class= "underline underline-offset-5"href="/">your tasks</a>
                            <button type="submit" class=" cursor-pointer bg-amber-50 ring-1 ring-amber-100  text-amber-600 text-base font-semibold tracking-tight shadow-md py-1 px-2 rounded-md ">Start Task</button>
                </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>