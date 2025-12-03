<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MayarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MayarWebhookController extends Controller
{
    protected $mayarService;

    public function __construct(MayarService $mayarService)
    {
        $this->mayarService = $mayarService;
    }

    /**
     * Handle webhook callback from Mayar.id
     */
    public function handleCallback(Request $request)
    {
        try {
            Log::info('Mayar Webhook Received', $request->all());

            // Verify webhook signature if Mayar provides one
            // $this->verifySignature($request);

            $data = $request->all();

            // Handle the callback
            $result = $this->mayarService->handleCallback($data);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Callback processed successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to process callback'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Mayar Webhook Error', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify webhook signature (implement based on Mayar documentation)
     */
    protected function verifySignature(Request $request)
    {
        // Implement signature verification if Mayar provides it
        // Example:
        // $signature = $request->header('X-Mayar-Signature');
        // $payload = $request->getContent();
        // $expected = hash_hmac('sha256', $payload, config('mayar.webhook_secret'));
        //
        // if (!hash_equals($signature, $expected)) {
        //     throw new \Exception('Invalid webhook signature');
        // }
    }
}
