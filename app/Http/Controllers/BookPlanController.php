<?php

namespace App\Http\Controllers;

use App\Services\BookPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookPlanController extends Controller
{
    public function __construct(BookPlanService $bookplan)
    {
        $this->bookplan = $bookplan;
    }

    public function subscribe(Request $request)
    {

        Validator::make($request->all(), [
            'book_id' => 'required',
            'plan_id' => 'required',
        ])->validate();

        $subscribe =  $this->bookplan->subscribe($request->all());

        return response()->json(['data' => $subscribe], 200);
    }

    public function updateStatus(Request $request)
    {

        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $status =  $this->bookplan->updateStatus($request->all());

        return response()->json(['data' => $status], 200);
    }


    public function view(Request $request)
    {

        Validator::make($request->all(), [
            'book_id' => 'required',
        ])->validate();

        $status =  $this->bookplan->view($request->all());

        return response()->json(['data' => $status], 200);
    }
}
