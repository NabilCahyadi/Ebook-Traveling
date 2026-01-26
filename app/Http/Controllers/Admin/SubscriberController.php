<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    protected $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    /**
     * Display a listing of active subscribers.
     */
    public function index(Request $request)
    {
        // Prepare filters from request
        $filters = [
            'role' => $request->input('role'),
            'subscription_plan' => $request->input('subscription_plan'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'search' => $request->input('search'),
        ];

        // Get per page value from request (multiples of 5)
        $perPage = $request->input('per_page', 15);
        // Ensure it's a valid multiple of 5, min 5, max 100
        $perPage = max(5, min(100, intval($perPage)));
        $perPage = ceil($perPage / 5) * 5; // Round to nearest multiple of 5

        // Get filtered subscriptions through service
        $subscriptions = $this->subscriberService->getFilteredSubscribers($filters, $perPage);

        // Get roles and subscription plans for filters
        $roles = $this->subscriberService->getAllRoles();
        $subscriptionPlans = $this->subscriberService->getAllSubscriptionPlans();

        return view('admin.subscribers.index', compact('subscriptions', 'roles', 'subscriptionPlans'));
    }
}
