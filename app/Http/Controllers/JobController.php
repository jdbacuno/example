<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        // dd('Hello');

        // when you reload the Laravel debugger, you'll see fewer queries compare
        // to N+1 lazy loading
        // sometimes people disable this
        // $jobs = Job::with('employer')->get(); // solves N+1 problem, called 'eager loading'
        // $jobs = Job::with('employer')->paginate(3); // will only shows 3 items per page
        // $jobs = Job::with('employer')->simplePaginate(3); // previous and next
        // $jobs = Job::with('employer')->cursorPaginate(3); // previous and next but uses URL in the id, good for many results
        // $jobs = Job::with('employer')->latest()->simplePaginate(3); // previous and next
        $jobs = Job::with('employer')->latest('updated_at')->simplePaginate(3); // show the most updated one

        return view('jobs.index', [
            // 'jobs' => Job::all()
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        // dd("hello there");
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        if (!$job) abort(404);
        return view('jobs.show', ['job' => $job]);
    }

    public function store()
    {
        // Validation...
        request()->validate([
            'title' => ['required', 'min:3'], // this comes from inputs' name="title"; required and minimum of 3 chars
            // 'salary' => '', // this comes from inputs' name="salary"
            'salary' => ['required']
        ]);

        // dd("hello from the POST request");
        // dd(request()->all()); // returns an array
        // dd(request('title')); // returns the 'title' value

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1 // not input in the form, assume grabbing this from the currently authenticated employer account
        ]);

        // assuming a job has been successfully posted, redirect back to the Jobs Page
        return redirect('/jobs');
    }

    public function edit(Job $job)
    {
        // $job = Job::find($id);

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        // validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // authorize (On hold...) // do you have permission to update?

        // update & persist
        // $job = Job::find($id); 
        // $job = Job::findOrFail($id); // fail: will return not found page

        // option 1
        // $job->title = request('title');
        // $job->title = request('salary');
        // $job->save();

        // option 2
        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        // redirect to the job page
        // return redirect('/jobs/' . $job->id);
        return redirect('/jobs/' . $job->job);
    }

    public function destroy(Job $job)
    {
        // authorize (On hold...) // do you have permission to delete?

        // delete the job
        // $job = Job::findOrFail($id);
        // $job->delete();
        // Job::findOrFail($id)->delete(); 
        $job->delete();

        return redirect('/jobs');
    }
}
