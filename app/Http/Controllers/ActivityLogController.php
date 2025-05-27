<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date');

        $logs = ActivityLog::query()
            ->when($search, function($query) use ($search) {
                $query->where(function($query) use ($search) {
                    $query->where('description', 'like', '%' . $search . '%')
                        ->orWhere('causer_type', 'like', '%' . $search . '%')
                        ->orWhere('subject_type', 'like', '%' . $search . '%');
                });
            })
            ->when($date, function($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->latest()
            ->paginate(10);

        return view('activity-logs.index', [
            'logs' => $logs,
            'search' => $search,
            'date' => $date
        ]);
    }
} 