<?php

namespace App\Http\Controllers;

use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function __construct(PlanService $planservice)
    {
        $this->planservice = $planservice;
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'duration' => 'required',
            'price' => 'required',
        ])->validate();

        $plan = $this->planservice->create($request->all());

        return response()->json(['data' => $plan], 200);
    }

    public function getAllPlans()
    {
        $plan = $this->planservice->getAllPlans();

        return response()->json(['data' => $plan], 200);
    }

    public function getPlan(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $plan = $this->planservice->getPlan($request->id);

        return response()->json(['data' => $plan], 200);
    }

    public function updatePlan(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'nullable',
            'duration' => 'nullable',
            'price' => 'nullable',
        ])->validate();

        $plan = $this->planservice->updatePlan($request->id, $request->all());

        return response()->json(['data' => $plan], 200);
    }

    public function updatePlanStatus(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $plan = $this->planservice->updatePlanStatus($request->id, $request->status);

        return response()->json(['data' => $plan], 200);
    }

    public function deletePlan(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $plan = $this->planservice->deletePlan($request->id);

        return response()->json(['data' => $plan], 200);
    }
}
