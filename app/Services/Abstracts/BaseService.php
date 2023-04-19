<?php

namespace App\Services\Abstracts;

use App\Services\Interfaces\IBaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

abstract class BaseService implements IBaseService
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

    public function update($id, $data)
    {
        $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        $this->model->find($id)->delete();
    }

    public function deleteMany(array $id)
    {
        return $this->model->whereIn('id', $id)->delete();
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

    public function getAllPaginateLatest($numberOnPage)
    {
        return $this->model->latest()->paginate($numberOnPage);
    }

    public function countSoftDelete()
    {
        return $this->model->onlyTrashed()->count();
    }

    public function count()
    {
        return $this->model->count();
    }

    public function getAllByWhere($column, $condition)
    {
        return $this->model->where($column, $condition)->get();
    }

    public function search($column, $condition)
    {
        return $this->model->where($column, 'LIKE', "%{$condition}%")->latest()->paginate(15);
    }
}
