<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Example controller showing how to implement permission checks
 * in your admin panel controllers.
 * 
 * This is a REFERENCE/EXAMPLE file - copy patterns to your actual controllers.
 */
class PermissionExampleController extends Controller
{
    /**
     * Method 1: Permission check via middleware in constructor
     * Best for applying permissions to all or multiple methods
     */
    public function __construct()
    {
        // Apply permission to all methods
        $this->middleware('permission:admin.ebooks.view');
        
        // Or apply to specific methods only
        $this->middleware('permission:admin.ebooks.create')->only(['create', 'store']);
        $this->middleware('permission:admin.ebooks.edit')->only(['edit', 'update']);
        $this->middleware('permission:admin.ebooks.delete')->only(['destroy']);
        $this->middleware('permission:admin.ebooks.approve')->only(['approve', 'reject']);
    }

    /**
     * Method 2: Manual permission check in method
     * Best for complex conditional logic or multiple permission checks
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        
        // Check if user has permission
        if (!$user->hasPermission('admin.ebooks.view')) {
            abort(403, 'You do not have permission to view ebooks.');
        }
        
        // Your logic here...
        return view('admin.ebooks.index');
    }

    /**
     * Method 3: Creator-specific logic
     * Creators can only edit their own content
     */
    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        $ebook = \App\Models\Ebook::findOrFail($id);
        
        // Check base permission
        if (!$user->hasPermission('admin.ebooks.edit')) {
            abort(403, 'You do not have permission to edit ebooks.');
        }
        
        // If user is creator (not admin), only allow editing own ebooks
        if ($user->type === 'creator' && $ebook->creator_id !== $user->id) {
            abort(403, 'You can only edit your own ebooks.');
        }
        
        return view('admin.ebooks.edit', compact('ebook'));
    }

    /**
     * Method 4: Approve function - Admin only
     * Creators should not have access to approve
     */
    public function approve($id)
    {
        $user = Auth::guard('admin')->user();
        
        // This should be protected by middleware, but double-check
        if (!$user->hasPermission('admin.ebooks.approve')) {
            abort(403, 'Only administrators can approve ebooks.');
        }
        
        $ebook = \App\Models\Ebook::findOrFail($id);
        $ebook->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Ebook approved successfully.');
    }

    /**
     * Method 5: Multiple permission check (OR logic)
     * User needs at least one of the permissions
     */
    public function viewAnalytics()
    {
        $user = Auth::guard('admin')->user();
        
        // User needs either permission
        $canView = $user->hasPermission('admin.dashboard.view') || 
                   $user->hasPermission('view_ebook_analytics');
        
        if (!$canView) {
            abort(403, 'You do not have permission to view analytics.');
        }
        
        return view('admin.analytics');
    }

    /**
     * Method 6: Multiple permission check (AND logic)
     * User needs ALL permissions
     */
    public function deleteWithAudit($id)
    {
        $user = Auth::guard('admin')->user();
        
        // User needs both permissions
        if (!$user->hasPermission('admin.ebooks.delete') || 
            !$user->hasPermission('admin.activity_logs.view')) {
            abort(403, 'You do not have sufficient permissions for this action.');
        }
        
        // Delete and log...
        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    /**
     * Method 7: Conditional UI based on permissions
     * Pass permission checks to view for conditional rendering
     */
    public function dashboard()
    {
        $user = Auth::guard('admin')->user();
        
        // Pass permission booleans to view
        $permissions = [
            'can_view_users' => $user->hasPermission('admin.users.view'),
            'can_approve_ebooks' => $user->hasPermission('admin.ebooks.approve'),
            'can_manage_settings' => $user->hasPermission('admin.settings.edit'),
            'can_view_logs' => $user->hasPermission('admin.activity_logs.view'),
        ];
        
        return view('admin.dashboard', compact('permissions'));
    }

    /**
     * Method 8: Query filtering based on role/permission
     * Show different data based on user type
     */
    public function getEbooks(Request $request)
    {
        $user = Auth::guard('admin')->user();
        
        // Start query
        $query = \App\Models\Ebook::query();
        
        // If creator, only show their ebooks
        if ($user->type === 'creator') {
            $query->where('creator_id', $user->id);
        }
        // If admin with view all permission, show all
        elseif ($user->hasPermission('admin.ebooks.view')) {
            // Show all ebooks
        }
        // Otherwise, no access
        else {
            abort(403, 'You do not have permission to view ebooks.');
        }
        
        $ebooks = $query->paginate(20);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Method 9: API response with permission check
     * For AJAX endpoints
     */
    public function apiDeleteEbook(Request $request, $id)
    {
        $user = Auth::guard('admin')->user();
        
        if (!$user->hasPermission('admin.ebooks.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'Permission denied.',
            ], 403);
        }
        
        $ebook = \App\Models\Ebook::findOrFail($id);
        
        // Creator can only delete own ebooks
        if ($user->type === 'creator' && $ebook->creator_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your own ebooks.',
            ], 403);
        }
        
        $ebook->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Ebook deleted successfully.',
        ]);
    }

    /**
     * Method 10: Helper for getting user's role
     */
    private function getUserRole()
    {
        $user = Auth::guard('admin')->user();
        return $user->getRole(); // Returns Role model
    }
}
