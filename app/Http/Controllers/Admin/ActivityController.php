<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::query()
            ->orderBy('id', 'DESC')
            ->with('causer')
            ->with('subject')
            ->paginate(20);

        return view('admin.activity.index', compact('activities'));
    }

    public function show(Activity $activity)
    {
        $activity
            ->load('causer')
            ->load('subject');

        return response()->json([
            'success' => 'true',
            'activity' => $activity,
        ]);
    }
}
