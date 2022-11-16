<?php

namespace App\Http\Controllers;

use App\Services\PlanSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanSubscriptionController extends Controller
{

    public function __construct(PlanSubscriptionService $subscription)
    {
        $this->subscription = $subscription;
    }


    public function viewSubscriptions(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'user_id' => 'required'
        ])->validate();

        $subscribe = $this->subscription->viewSubscriptions($request->user_id);

        return response()->json(['data' => $subscribe], 200);
    }



    public function subscribe(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'plan_id' => 'required',
        ])->validate();

        $subscribe = $this->subscription->subscribe($request->all());

        return response()->json(['data' => $subscribe], 200);
    }
}
