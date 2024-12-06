<?php

namespace App\Repositories;

use App\Models\Level;
use App\Repositories\Contracts\BaseRepository;

class LevelRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Level::class;
    }

    public function all()
    {
        $levels = $this->model::all();

        return $levels;
    }

    public function find($id) {}

    public function create(array $data)
    {
        $level = $this->model::create($data);
        return $level;
    }

    public function update($id, array $data)
    {
        $level = $this->model::find($id);
        if ($level) {
            $level->update($data);
            return $level;
        }
    }

    public function delete($id)
    {
        $level = $this->model::find($id);
        if ($level) {
            $level->delete();
            return $level;
        }
    }

    public function searchAndFilter(array $filters) {}
}
