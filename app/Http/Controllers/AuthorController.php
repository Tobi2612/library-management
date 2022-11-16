<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\AuthorService;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function __construct(AuthorService $authorservice, BookService $bookservice)
    {
        $this->author = $authorservice;
        $this->bookservice = $bookservice;
    }


    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'book_id' => 'required',
        ])->validate();

        $author = $this->author->create($request->all());

        return response()->json(['data' => $author], 200);
    }


    public function getAllAuthors()
    {
        $author = $this->author->getAllAuthors();

        return response()->json(['data' => $author], 200);
    }

    public function getAuthor(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $author = $this->author->getAuthor($request->id);
        return response()->json(['data' => $author], 200);
    }

    public function updateAuthor(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'user_id' => 'nullable',
            'book_id' => 'nullable',
        ])->validate();

        $author = $this->author->updateAuthor($request->id, $request->all());
        return response()->json(['data' => $author], 200);
    }


    public function deleteAuthor(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $author = $this->author->deleteAuthor($request->id);
        return response()->json(['data' => $author], 200);
    }

    public function getBook(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();


        $this->bookservice->verifyAuthor($request->id, auth()->id());
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

        $this->bookservice->verifyAuthor($request->id, auth()->id());
        $book = $this->bookservice->updateBook($request->id, $request->all());

        return response()->json(['data' => $book], 200);
    }

    public function updateBookStatus(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ])->validate();

        $this->bookservice->verifyAuthor($request->id, auth()->id());
        $book = $this->bookservice->updateBookStatus($request->id, $request->status);

        return response()->json(['data' => $book], 200);
    }

    public function deleteBook(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        $this->bookservice->verifyAuthor($request->id, auth()->id());
        $book = $this->bookservice->deleteBook($request->id);

        return response()->json(['data' => $book], 200);
    }
}
