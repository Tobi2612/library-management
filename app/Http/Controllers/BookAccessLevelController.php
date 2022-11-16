<?php

namespace App\Http\Controllers;

use App\Services\BookAccessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookAccessLevelController extends Controller
{
    public function __construct(BookAccessService $bookaccess)
    {
        $this->bookaccess = $bookaccess;
    }

    public function subscribe(Request $request)
    {

        Validator::make($request->all(), [
            'book_id' => 'required',
            'access_level_name' => 'required',
        ])->validate();

        $subscribe =  $this->bookaccess->subscribe($request->all());

        return response()->json(['data' => $subscribe], 200);
    }

    public function updateStatus(Request $request)
    {

        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $status =  $this->bookaccess->updateStatus($request->all());

        return response()->json(['data' => $status], 200);
    }


    public function view(Request $request)
    {

        Validator::make($request->all(), [
            'book_id' => 'required',
        ])->validate();

        $status =  $this->bookaccess->view($request->all());

        return response()->json(['data' => $status], 200);
    }
}
