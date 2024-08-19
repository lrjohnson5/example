<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function index()
    {
        // eager loading employer relationship
        // 'latest()' adds an order by to the query
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
        'jobs' => $jobs
        ]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => 'required'
        ]);

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        // send email to employer's user's email address when a job is posted
        // Mail::to($job->employer->user)->send(
        //     new JobPosted($job)
        // );

        // queue email to be sent to the employer's user's email address when a job is posted
        Mail::to($job->employer->user)->queue(
            new JobPosted($job)
        );

        return redirect('/jobs');
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {

        // must authorize the user

        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => 'required'
        ]);

        //  more traditional way of updating a row
        //$job->title = request('title');
        //$job->salary = request('salary');
        //$job->save();

        // Also may update with following code:
        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        return redirect('/jobs/' . $job->id);
    }
    public function destroy(Job $job)
    {

        // must authorize the user first

        $job->delete();

        return redirect('/jobs');
    }
}
