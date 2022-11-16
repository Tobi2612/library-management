<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function __construct(BookService $bookservice)
    {
        $this->bookservice = $bookservice;
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'edition' => 'required',
            'description' => 'required',
            'prologue' => 'required',
        ])->validate();

        $book = $this->bookservice->create($request->all());

        return response()->json(['data' => $book], 200);
    }

    public function getAllBooks()
    {
        $book = $this->bookservice->getAllBooks();

        return response()->json(['data' => $book], 200);
    }

    public function getBook(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $book = $this->bookservice->getBook($request->id);

        return response()->json(['data' => $book], 200);
    }

    public function updateBook(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'nullable',
            'edition' => 'nullable',
            'description' => 'nullable',
            'prologue' => 'nullable',
        ])->validate();

        $book = $this->bookservice->updateBook($request->id, $request->all());

        return response()->json(['data' => $book], 200);
    }

    public function updateBookStatus(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $book = $this->bookservice->updateBookStatus($request->id, $request->status);

        return response()->json(['data' => $book], 200);
    }

    public function deleteBook(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $book = $this->bookservice->deleteBook($request->id);

        return response()->json(['data' => $book], 200);
    }
}
