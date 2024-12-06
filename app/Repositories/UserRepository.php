<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Support\Facades\Storage;

class UserRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function all()
    {
        $users = $this->model::paginate(15);

        return $users;
    }

    public function find($id)
    {
        $user = $this->model::find($id);

        return $user;
    }

    public function create(array $data)
    {
        $user = $this->model::create($data);
        return $user;
    }

    public function update($id, array $data)
    {

        $user = $this->model::find($id);

        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->model::find($id);
        if ($user) {
            if ($user->user_photo) {
                $userPhoto = $user->user_photo;
                Storage::delete('images/usersPhoto/' . $userPhoto);
            }
            $user->delete();
            return $user;
        }
    }

    public function searchAndFilter(array $filters)
    {
        $query = $this->model::query();

        if (!empty($filters['query'])) {
            $query->where('name', 'LIKE', '%' . $filters['query'] . '%')
                ->orWhere('email', 'LIKE', '%' . $filters['query'] . '%');
        }

        if (!empty($filters['order_by'])) {
            $query->orderBy($filters['order_by'], $filters['sort']);
        }

        if (!empty($filters['filter'])) {
            $query->where('user_type', $filters['filter']);
        }

        $limit = $filters['limit'] ?? 10;

        $users = $query->paginate($limit);
        return $users;
    }
}
