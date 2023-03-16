<?php

namespace App\Repositories\Interfaces;

interface IBaseRepository
{
    public function getAll();

    public function find($id);

    public function create(...$data);

    public function update($id, ...$data);

    public function delete($id);

    public function pagination($data, $numberOnPage);

    public function with(...$relations);
}
