<?php

/* TESTS
Route::get('/', function () {
    // return view('welcome'); // welcome.blade.php

    // testing model
    // $jobs = Job::all();
    // dd($jobs[0]->title); // 'title' column from the first row

    return view('home');
});

Route::get('/about', function () {
    return 'About Page';
});

Route::get('/about', function () {
    return ['foo' => 'bar'];
});

Route::get('/contact', function () {
    return view('contact');
});
*/

// --------------------------------------------------
/* Model v2
class Job
{
    public static function all()
    {
        return [
            [
                'id' => 1,
                'title' => 'Director',
                'salary' => '$50,000'
            ],
            [
                'id' => 2,
                'title' => 'Human Programmer',
                'salary' => '$10,000'
            ],
            [
                'id' => 3,
                'title' => 'Teacher',
                'salary' => '$40,000'
            ]
        ];
    }
}
*/

// --------------------------------------------------
/* Model v1
$jobs = [
    [
        'id' => 1,
        'title' => 'Director',
        'salary' => '$50,000'
    ],
    [
        'id' => 2,
        'title' => 'Human Programmer',
        'salary' => '$10,000'
    ],
    [
        'id' => 3,
        'title' => 'Teacher',
        'salary' => '$40,000'
    ]
];
*/

// --------------------------------------------------
// Route::get('/jobs/{job}', function () {});
// Route::get('/jobs/{job}', function () use ($jobs) {});
/* 
Route::get('/jobs/{id}', function ($id) {
    // dd($id);

    // $jobs = [
    //     [
    //         'id' => 1,
    //         'title' => 'Director',
    //         'salary' => '$50,000'
    //     ],
    //     [
    //         'id' => 2,
    //         'title' => 'Human Programmer',
    //         'salary' => '$10,000'
    //     ],
    //     [
    //         'id' => 3,
    //         'title' => 'Teacher',
    //         'salary' => '$40,000'
    //     ]
    // ];

    // Arr::first($jobs, function ($job) use ($id) {
    //     return $job['id'] == $id;
    // });

    // $job = Arr::first(Job::all(), fn($job) => $job['id'] == $id);
    $job = Job::find($id);

    if (!$job) abort(404);

    // dd($job);

    return view('jobs.show', ['job' => $job]);
});
*/

// --------------------------------------------------
/*
// Route::get('/jobs', function () {});
Route::get('/jobs', [JobController::class, 'index']); // using controllers

// Route::get('/jobs/create', function () {});
Route::get('/jobs/create', [JobController::class, 'create']);

// Route::get('/jobs/{job}', function (Job $job) {});
Route::get('/jobs/{job}', [JobController::class, 'show']);

// Route::post('/jobs', function () {});
Route::post('/jobs', [JobController::class, 'store']);

// Route::get('/jobs/{job}/edit', function (Job $job) {});
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);

// Route::patch('/jobs/{job}', function (Job $job) {});
Route::patch('/jobs/{job}', [JobController::class, 'update']);

// Route::delete('/jobs/{job}', function (Job $job) {});
Route::delete('/jobs/{job}', [JobController::class, 'destroy']);
*/

// --------------------------------------------------
/*
Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index'); // using controllers
    Route::get('/jobs/create', 'create');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store');
    Route::get('/jobs/{job}/edit', 'edit');
    Route::patch('/jobs/{job}', 'update');
    Route::delete('/jobs/{job}', 'destroy');
});
*/

/*
Route::resource('jobs', JobController::class, [
    // 'except' => ['edit'] // won't generate 'jobs/{job}/edit'
    'only' => ['index', 'show', 'create', 'store'] // only allows the three routes
]);
*/