<?php

namespace App\Repositories\Interfaces;

interface IBaseRepository
{
    public function getAll();

    public function find($id);

    public function create($data);

    public function update($id, $data);

    public function delete($id);

    public function count();

    public function countSoftDelete();

    public function pagination($data, $numberOnPage);

    public function getAllByWhere($column, $condition);

    public function getAllPaginateLatest($numberOnPage);

    public function search($column, $condition);
}
