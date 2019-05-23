<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;

class ActivityController extends Controller
{
    public function index()
    {
        $superfilter = request()->input('filter', '');
        Session::put('admin.activity.index.superfilter', $superfilter);

        return view('admin.activity.index');
    }

    public function data(Datatables $datatables)
    {
        $superfilter = Session::get('admin.activity.index.superfilter', '');
        $query = Activity::query();

        switch ($superfilter) {
            default:
                $query = $query;

                break;
        }

        return $datatables->eloquent($query)
            ->addColumn('icon', function ($activity) {
                switch ($activity->properties['level'] ?? 'default') {
                    case 'error':
                    case 'critical':
                        return '<i class="fas fa-square text-warning"></i>';

                        break;
                    case 'notice':
                    case 'warning':
                        return '<i class="fas fa-square text-warning"></i>';

                        break;
                    case 'debug':
                        return '<i class="fas fa-square text-muted"></i>';

                    break;
                    case 'info':
                    default:
                        return '<i class="fas fa-square text-info"></i>';
                }
            })
            ->editColumn('created_at', function ($activity) {
                return $activity->created_at->diffForHumans();
            })
            ->addColumn('causer', function ($activity) {
                $markup = null;
                if ($activity->causer_id && $user = User::find($activity->causer_id)) {
                    $markup .= $user->name;
                }

                return $markup;
            })
            ->editColumn('actions', function ($activity) {
                $actions = '<div class="btn-group">';

                // $actions .= '<a class="btn btn-primary btn-sm" href="/poweruser/activitys/' . $activity->id . '#btabs-application"><i class="fa fa-bars"></i></a>';

                $actions .= '</div>';

                return $actions;
            })
            ->rawColumns(['icon', 'causer', 'actions'])
            ->setRowId('id')
            ->make(true);
    }
}
