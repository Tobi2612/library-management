<?php

namespace App\Services;

use App\Models\AccessLevel;
use App\Models\Book;
use App\Models\BookAccessLevel;
use Illuminate\Support\Facades\DB;
use Exception;


class BookAccessService
{
    public function subscribe(array $data)
    {
        DB::beginTransaction();

        $book = Book::findOrFail($data['book_id']);
        $access_level = AccessLevel::where('name', $data['access_level_name'])->first();

        if ($access_level->count() < 1) {
            throw new Exception('Access Level does not exist.');
        }

        $book_access_level = BookAccessLevel::where('book_id', $book->id)->where('access_level', $access_level->name)->get();

        if ($book_access_level->count() > 0) {
            throw new Exception('This book already has this access level');
        }


        $subscribe = BookAccessLevel::create([
            'book_id' => $book->id,
            'access_level' => $access_level->name,
            'status' => 'active',
        ]);

        DB::commit();
        return $subscribe;
    }

    public function updateStatus(array $data)
    {
        $bookplan = BookAccessLevel::findOrFail($data['id']);
        $bookplan->status = $data['status'];
        $bookplan->save();

        return $bookplan;
    }

    public function view(array $data)
    {
        // $bookplan = BookAccessLevel::where('book_id', $data['book_id'])->paginate(50);
        $bookplan = Book::with('book_access_level')->findOrFail($data['book_id']);

        return $bookplan;
    }
}
