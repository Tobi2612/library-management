<?php

namespace App\Services;

use App\Models\Plan;


use Exception;

class PlanService
{

    public function create(array $data)
    {


        $plan = Plan::create([
            'name' => $data['name'],
            'duration' => $data['duration'],
            'price' => $data['price'],
            'status' => 'active',
        ]);
        return $plan;
    }

    /**
     * Return information about all plans.
     *
     * @return mixed
     */
    public function getAllPlans()
    {
        return Plan::paginate(50);
    }

    /**
     * Return all information about a plan.
     *
     * @param $id
     */
    public function getPlan(int $id)
    {
        $plan = Plan::findOrFail($id);

        return $plan;
    }


    /**
     * Update a plan.
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updatePlan(int $id, array $data)
    {
        $plan = Plan::findOrFail($id);

        $plan->name = $data['name'] ?? $plan->name;
        $plan->duration = $data['duration'] ?? $plan->duration;
        $plan->price = $data['price'] ?? $plan->price;
        $plan->status = $data['status'] ?? $plan->status;


        $plan->save();
        return $plan;
    }



    /**
     * Update plan status.
     *
     * @return mixed
     */
    public function updatePlanStatus(int $id, string $status)
    {
        $plan = Plan::findOrFail($id);
        $plan->status = $status;

        $plan->save();

        return $plan;
    }

    /**
     * Deletes a plan.
     */
    public function deletePlan(int $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->delete($id);


        return true;
    }
}
