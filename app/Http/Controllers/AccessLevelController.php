<?php

namespace App\Http\Controllers;

use App\Services\AccessLevelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccessLevelController extends Controller
{
    public function __construct(AccessLevelService $accesslevel)
    {
        $this->accesslevel = $accesslevel;
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        $access = $this->accesslevel->create($request->all());

        return response()->json(['data' => $access], 200);
    }

    public function getAllAccessLevels()
    {
        $access = $this->accesslevel->getAllAccessLevels();

        return response()->json(['data' => $access], 200);
    }

    public function getAccessLevel(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $access = $this->accesslevel->getAccessLevel($request->id);

        return response()->json(['data' => $access], 200);
    }

    public function updateAccessLevel(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'nullable',
        ])->validate();

        $access = $this->accesslevel->updateAccessLevel($request->id, $request->all());

        return response()->json(['data' => $access], 200);
    }

    public function updateAccessLevelStatus(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $access = $this->accesslevel->updateAccessLevelStatus($request->id, $request->status);

        return response()->json(['data' => $access], 200);
    }

    public function deleteAccessLevel(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $access = $this->accesslevel->deleteAccessLevel($request->id);

        return response()->json(['data' => $access], 200);
    }
}
