<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Contracts\BaseRepository;

class LanguageRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Language::class;
    }

    public function all()
    {
        $languages = $this->model::all();
        return $languages;
    }

    public function find($id)
    {
        $language = $this->model::find($id);
        return $language;
    }

    public function create(array $data)
    {
        $language = $this->model::create($data);
        return $language;
    }

    public function update($id, array $data)
    {
        $language = $this->model::find($id);
        if ($language) {
            $language->update($data);
            return $language;
        }
    }

    public function delete($id)
    {
        $language = $this->model::find($id);
        if ($language) {
            $language->delete();
            return $language;
        }
    }

    public function searchAndFilter(array $filters) {}
}
