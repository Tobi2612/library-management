<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LendingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LendingController extends Controller
{
    public function __construct(LendingService $lendingservice)
    {
        $this->lendingservice = $lendingservice;
    }


    public function viewBorrowed(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        $lending = $this->lendingservice->viewBorrowed($request->user_id);

        return response()->json(['data' => $lending], 200);
    }

    public function viewReturned(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        $lending = $this->lendingservice->viewReturned($request->user_id);

        return response()->json(['data' => $lending], 200);
    }

    public function borrowBook(Request $request): JsonResponse
    {

        Validator::make($request->all(), [
            'book_id' => 'required',
            'user_id' => 'required',
            'date_time_borrowed' => 'required',
            'date_time_due' => 'required',
        ])->validate();

        $lending = $this->lendingservice->borrowBook($request->all());

        return response()->json(['data' => $lending], 200);
    }

    public function returnBook(Request $request): JsonResponse
    {
        Validator::make($request->all(), [
            'book_id' => 'required',
            'user_id' => 'required',
            'date_time_returned' => 'required',
        ])->validate();

        $lending = $this->lendingservice->returnBook($request->all());


        return response()->json(['data' => $lending], 200);
    }

    public function getAllLendings()
    {
        $lending = $this->lendingservice->getAllLendings();

        return response()->json(['data' => $lending], 200);
    }

    public function getLending(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $lending = $this->lendingservice->getLending($request->id);

        return response()->json(['data' => $lending], 200);
    }

    public function updateLending(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'book_id' => 'nullable',
            'user_id' => 'nullable',
            'date_time_borrowed' => 'nullable',
            'date_time_due' => 'nullable',
            'date_time_returned' => 'nullable',
            'points' => 'nullable',
            'is_returned' => 'nullable',
        ])->validate();

        $lending = $this->lendingservice->updateLending($request->id, $request->all());

        return response()->json(['data' => $lending], 200);
    }

    public function deleteLending(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $lending = $this->lendingservice->deleteLending($request->id);

        return response()->json(['data' => $lending], 200);
    }
}
