<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Lending;
use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Exception;

class PlanSubscriptionService
{
    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    public function viewSubscriptions($id)
    {
        $subscribe = PlanSubscription::where('user_id', $id)->paginate(50);
        return $subscribe;
    }


    public function subscribe(array $data)
    {
        DB::beginTransaction();

        $plan = Plan::findOrFail($data['plan_id']);
        $user = User::findOrFail($data['user_id']);

        if ($user->current_plan != 1) {
            throw new Exception("Already on an existing plan");
        }

        if ($plan->duration === 'forever') {
            $expiry_date = null;
        } else {
            $date = now();
            $expiry_date = date('Y-m-d', strtotime($date . ' + ' . $plan->duration . 'days'));
        }


        $subscribe = PlanSubscription::create([
            'user_id' => $data['user_id'],
            'plan_id' => $data['plan_id'],
            'status' => 'active',
            'expiry_date' => $expiry_date
        ]);


        $user->current_plan = $plan->id;

        $user->save();

        DB::commit();

        return $subscribe;
    }
}
