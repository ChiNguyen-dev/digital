<?php

namespace App\Repositories\Abstracts;

use App\Repositories\Interfaces\IBaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

abstract class BaseRepository implements IBaseRepository
{
    protected $model;

    protected $column = [];

    public function __construct()
    {
        $this->setModel();
    }

    public abstract function getModel();

    public function setModel()
    {
        $this->model = App::make($this->getModel());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, ...$data)
    {
        $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        $this->model->find($id)->delete();
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function setColumn(...$column)
    {
        $this->column = $column;
    }

    public function pagination($data, $numberOnPage)
    {
        if ($data != null) {
            $totalGroup = count($data);
            $perPage = $numberOnPage;
            $page = Paginator::resolveCurrentPage('page');
            return new LengthAwarePaginator($data->forPage($page, $perPage), $totalGroup, $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);
        }
    }

    public function with(...$relations)
    {
        return $this->model->with($relations);
    }

}
