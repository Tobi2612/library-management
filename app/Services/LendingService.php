<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Lending;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Exception;

class LendingService
{
    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    public function viewBorrowed($id)
    {
        $lending = Lending::where('user_id', $id)->where('is_returned', 0)->paginate(50);
        return $lending;
    }

    public function viewReturned($id)
    {
        $lending = Lending::where('user_id', $id)->where('is_returned', 1)->paginate(50);
        return $lending;
    }

    public function borrowBook(array $data)
    {
        DB::beginTransaction();

        $logged_in_user = User::findOrFail(auth()->id());

        $user_id = $logged_in_user->role == 'admin' ? $data['user_id'] : $logged_in_user->id;

        $user = User::findOrFail($user_id);

        $current_plan = $user->current_plan;
        $access_level = $user->access_level;
        $book = Book::with('bookplan', 'book_access_level')->where('id', $data['book_id'])
            ->whereHas('bookplan', function ($t) use ($current_plan) {
                $t->where('plan_id', $current_plan)->where('status', 'active');
            })
            ->whereHas('book_access_level', function ($q) use ($access_level) {
                $q->where('access_level', $access_level)->where('status', 'active');
            })
            ->first();

        if ($book->count() < 1) {
            throw new Exception("You cant access this book with your current plan or access level");
        }

        if (!$book->status == 'available') {
            throw new Exception("Book already borrowed");
        }

        $lending = Lending::create([
            'book_id' => $book->id,
            'user_id' => $user_id,
            'date_time_borrowed' => $data['date_time_borrowed'],
            'date_time_due' => $data['date_time_due'],
            'date_time_returned' => null,
            'points' => 0,
            'is_returned' => false
        ]);

        $book->current_lend_id = $lending->id;
        $book->status = 'borrowed';
        $book->save();

        DB::commit();

        return $lending;
    }

    public function returnBook(array $data): Lending
    {

        DB::beginTransaction();
        $logged_in_user = User::findOrFail(auth()->id());

        $user_id = $logged_in_user->role == 'admin' ? $data['user_id'] : $logged_in_user->id;

        $user = User::findOrFail($user_id);
        $book = Book::findOrFail($data['book_id']);
        $lending = Lending::findOrFail($book->current_lend_id);

        if ($user->id != $lending->user_id) {
            throw new Exception("This user  did not borrow this book");
        }


        if (!$book->status == 'borrowed') {
            throw new Exception("Can't return a book that is not borrowed");
        }

        $book->status = 'available';
        $book->current_lend_id = null;

        $lending->points += 1;

        $lending->date_time_returned = $data['date_time_returned'] ?? now();
        $lending->is_returned = true;

        if ($lending->date_time_returned->lt($lending->date_time_due)) {
            $lending->points += 2;
        }

        if ($lending->date_time_returned->gt($lending->date_time_due)) {
            $lending->points -= 1;
        }
        $user->points += $lending->points;



        $access_level = $this->authservice->calculateAccessLevel($user->age, $user->points);
        if ($access_level !== $user->access_level) {
            $user->access_level = $access_level;
        }

        $book->save();
        $user->save();
        $lending->save();


        DB::commit();

        return $lending;
    }

    public function getAllLendings()
    {
        return Lending::paginate(50);
    }


    public function getLending(int $id)
    {
        $lending = Lending::findOrFail($id);

        return $lending;
    }



    public function updateLending(int $id, array $data)
    {

        $lending = Lending::findOrFail($id);

        $lending->book_id = $data['book_id'] ?? $lending->book_id;
        $lending->user_id = $data['user_id'] ?? $lending->user_id;
        $lending->date_time_borrowed = $data['date_time_borrowed'] ?? $lending->date_time_borrowed;
        $lending->date_time_due = $data['date_time_due'] ?? $lending->date_time_due;
        $lending->date_time_returned = $data['date_time_returned'] ?? $lending->date_time_returned;
        $lending->points = $data['points'] ?? $lending->points;
        $lending->is_returned = $data['is_returned'] ?? $lending->is_returned;


        $lending->save();
        return $lending;
    }



    public function deleteLending(int $id)
    {
        $lending = Lending::findOrFail($id);

        $lending->delete($id);


        return true;
    }
}
