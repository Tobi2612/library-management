<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookPlan;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Exception;


class BookPlanService
{
    public function subscribe(array $data)
    {
        DB::beginTransaction();

        $book = Book::findOrFail($data['book_id']);
        $plan = Plan::findOrFail($data['plan_id']);

        $bookplan = BookPlan::where('book_id', $book->id)->where('plan_id', $plan->id)->get();

        if ($bookplan->count() > 0) {
            throw new Exception('This book already has this plan');
        }


        $subscribe = BookPlan::create([
            'book_id' => $book->id,
            'plan_id' => $plan->id,
            'status' => 'active',
        ]);

        DB::commit();
        return $subscribe;
    }

    public function updateStatus(array $data)
    {
        $bookplan = BookPlan::findOrFail($data['id']);
        $bookplan->status = $data['status'];
        $bookplan->save();

        return $bookplan;
    }

    public function view(array $data)
    {
        // $bookplan = BookPlan::where('book_id', $data['book_id'])->paginate(50);
        $bookplan = Book::with('bookplan')->findOrFail($data['book_id']);


        return $bookplan;
    }
}
