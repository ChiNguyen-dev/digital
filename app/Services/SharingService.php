<?php

namespace App\Services;


class SharingService
{
    private $data = array();

    public function share($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        return !empty($this->data[$key]) ? $this->data[$key] : null;
    }
}
