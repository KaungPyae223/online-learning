<?php

namespace App\Repositories;

use App\Models\Review;
use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Support\Facades\Storage;

class ReviewRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Review::class;
    }

    public function all()
    {
        $reviews = $this->model::paginate(10);

        return $reviews;
    }

    public function find($id)
    {
        $review = $this->model::find($id);

        return $review;
    }

    public function create(array $data)
    {
        $review = $this->model::create($data);

        return $review;
    }

    public function update($id, array $data)
    {
        $review = $this->model::find($id);
        if ($review) {
            $review->update($data);
            return $review;
        }
    }

    public function delete($id)
    {
        $review = $this->model::find($id);
        if ($review) {
            $review->delete();
            return $review;
        }
    }

    public function searchAndFilter(array $filters) {}
}
