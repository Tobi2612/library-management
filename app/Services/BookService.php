<?php

namespace App\Services;

use App\Models\Book;
use App\Models\User;
use Exception;

class BookService
{

    public function create(array $data): Book
    {
        $book = Book::create([
            'title' => $data['title'],
            'edition' => $data['edition'],
            'description' => $data['description'],
            'prologue' => $data['prologue'],
            'status' => 'available',
        ]);

        return $book;
    }

    /**
     * Return information about all books to admin.
     *
     * @return mixed
     */
    public function getAllBooks()
    {
        return Book::paginate(50);
    }

    /**
     * Return all information about a book.
     *
     * @param $id
     */
    public function getBook(int $id)
    {
        $book = Book::findOrFail($id);

        return $book;
    }


    /**
     * Update a book.
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateBook(int $id, array $data)
    {

        $book = Book::findOrFail($id);

        $book->title = $data['title'] ?? $book->title;
        $book->edition = $data['edition'] ?? $book->edition;
        $book->description = $data['description'] ?? $book->description;
        $book->prologue = $data['prologue'] ?? $book->prologue;

        $book->save();
        return $book;
    }



    /**
     * Update book status.
     *
     * @return mixed
     */
    public function updateBookStatus(int $id, string $status)
    {
        $book = Book::findOrFail($id);
        $book->status = $status;

        $book->save();

        return $book;
    }

    /**
     * Deletes a book.
     */
    public function deleteBook(int $id)
    {
        $book = Book::findOrFail($id);

        $book->delete($id);


        return true;
    }

    public function verifyAuthor($book_id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $book = Book::with('author')->where('id', $book_id)
            ->whereHas('author', function ($t) use ($user_id) {
                $t->where('user_id', $user_id);
            })
            ->get();

        if ($book->count() < 1) {
            if ($user->role != 'admin') {
                throw new Exception('Not the author of this book or an admin');
            }
        }
    }
}
