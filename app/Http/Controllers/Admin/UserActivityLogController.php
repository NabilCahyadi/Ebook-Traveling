<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserActivityLogController extends Controller
{
    /**
     * Display a listing of user activity logs (excluding admin activities).
     */
    public function index(Request $request)
    {
        // Check if ActionLog model exists
        if (!class_exists('App\\Models\\ActionLog')) {
            return view('admin.user-activity-logs.index', [
                'logs' => collect([]),
                'users' => collect([]),
                'actions' => ['all', 'create', 'update', 'delete', 'login', 'logout', 'view', 'download']
            ])->with('warning', 'ActionLog model is not available. Please check your database migrations.');
        }

        $query = ActionLog::with(['user.roles']);

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action type
        if ($request->has('action') && $request->action && $request->action !== 'all') {
            $query->where('action_type', $request->action);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('table_name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $logs = $query->latest()->paginate(20);

        // Get all users for filter
        $users = User::with('roles')->orderBy('name')->get();

        $actions = ['all', 'create', 'update', 'delete', 'login', 'logout', 'view', 'download'];

        return view('admin.user-activity-logs.index', compact('logs', 'users', 'actions'));
    }

    /**
     * Display the specified activity log.
     */
    public function show($id)
    {
        $log = ActionLog::with(['user.roles'])->findOrFail($id);

        return view('admin.user-activity-logs.show', compact('log'));
    }

    /**
     * Export activity logs to CSV.
     */
    public function export(Request $request)
    {
        $query = ActionLog::with(['user.roles']);

        // Apply same filters as index
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->has('action') && $request->action !== 'all') {
            $query->where('action_type', $request->action);
        }
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->get();

        $filename = 'user-activity-logs-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'User', 'Email', 'Role', 'Action', 'Table', 'Record ID', 'IP Address', 'Date/Time']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user->name ?? 'N/A',
                    $log->user->email ?? 'N/A',
                    $log->user->roles->first()->name ?? 'N/A',
                    $log->action_type,
                    $log->table_name ?? 'N/A',
                    $log->record_id ?? 'N/A',
                    $log->ip_address ?? 'N/A',
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
