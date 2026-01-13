<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    /**
     * Display a listing of admin activity logs.
     */
    public function index(Request $request)
    {
        $query = ActionLog::with(['admin'])
            ->where('user_type', 'admin')
            ->whereNotNull('admin_id');

        // Filter by admin
        if ($request->has('admin_id') && $request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }

        // Filter by action type
        if ($request->has('action') && $request->action && $request->action !== 'all') {
            $query->where('action_type', $request->action);
        }

        // Filter by table
        if ($request->has('table') && $request->table && $request->table !== 'all') {
            $query->where('table_name', $request->table);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('table_name', 'like', "%{$search}%")
                    ->orWhere('record_id', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('admin', function ($adminQuery) use ($search) {
                        $adminQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $logs = $query->latest()->paginate(10);

        // Get all admins for filter
        $admins = Admin::orderBy('name')->get();

        // Get unique tables from logs
        $tables = ActionLog::where('user_type', 'admin')
            ->whereNotNull('table_name')
            ->distinct()
            ->pluck('table_name')
            ->sort()
            ->values();

        $actions = ['all', 'create', 'update', 'delete', 'restore', 'force_delete', 'login', 'logout'];

        return view('admin.admin-activity-logs.index', compact('logs', 'admins', 'actions', 'tables'));
    }

    /**
     * Display the specified admin activity log.
     */
    public function show($id)
    {
        $log = ActionLog::with(['admin'])
            ->where('user_type', 'admin')
            ->findOrFail($id);

        return view('admin.admin-activity-logs.show', compact('log'));
    }

    /**
     * Export admin activity logs to CSV.
     */
    public function export(Request $request)
    {
        $query = ActionLog::with(['admin'])
            ->where('user_type', 'admin')
            ->whereNotNull('admin_id');

        // Apply same filters as index
        if ($request->has('admin_id') && $request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }
        if ($request->has('action') && $request->action !== 'all') {
            $query->where('action_type', $request->action);
        }
        if ($request->has('table') && $request->table !== 'all') {
            $query->where('table_name', $request->table);
        }
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->get();

        $filename = 'admin-activity-logs-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['ID', 'Admin', 'Email', 'Action', 'Table', 'Record ID', 'IP Address', 'URL', 'Date/Time']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->admin->name ?? 'N/A',
                    $log->admin->email ?? 'N/A',
                    $log->action_type,
                    $log->table_name ?? 'N/A',
                    $log->record_id ?? 'N/A',
                    $log->ip_address ?? 'N/A',
                    $log->url ?? 'N/A',
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Delete old admin activity logs.
     */
    public function cleanup(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365'
        ]);

        $date = now()->subDays($request->days);
        $deleted = ActionLog::where('user_type', 'admin')
            ->where('created_at', '<', $date)
            ->delete();

        return redirect()->route('admin.admin-activity-logs.index')
            ->with('success', "Successfully deleted {$deleted} old admin activity logs.");
    }
}
