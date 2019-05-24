<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::query()
            ->orderBy('created_at', 'DESC')
            ->with('causer')
            ->paginate(20);

        return view('admin.activity.index', compact('activities'));
    }
}
