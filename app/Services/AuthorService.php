<?php

namespace App\Services;

use App\Models\Author;
use App\Models\User;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthorService
{

    public function create(array $data)
    {
        DB::beginTransaction();
        $user = User::findOrFail($data['user_id']);
        $book = User::findOrFail($data['book_id']);

        $author = Author::create([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id'],

        ]);

        DB::commit();
        return $author;
    }

    /**
     * Return information about all authors to admin.
     *
     * @return mixed
     */
    public function getAllAuthors()
    {
        return Author::paginate(50);
    }

    /**
     * Return all information about a author.
     *
     * @param $id
     */
    public function getAuthor(int $id)
    {
        $author = Author::findOrFail($id);

        return $author;
    }


    /**
     * Update a author.
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateAuthor(int $id, array $data)
    {
        DB::beginTransaction();

        $user = User::findOrFail($data['user_id']);
        $book = User::findOrFail($data['book_id']);

        $author = Author::findOrFail($id);

        $author->user_id = $data['user_id'] ?? $author->user_id;
        $author->book_id = $data['book_id'] ?? $author->book_id;


        $author->save();

        DB::commit();
        return $author;
    }




    /**
     * Deletes a author.
     */
    public function deleteAuthor(int $id)
    {
        $author = Author::findOrFail($id);

        $author->delete($id);

        return true;
    }
}
