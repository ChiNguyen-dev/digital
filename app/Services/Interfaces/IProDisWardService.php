<?php

namespace App\Services\Interfaces;

interface IProDisWardService
{
    public function getProvinces(): object;

    public function getDistrictsByMatp(String $matp): object;

    public function getWardsByMaqh(String $maqh): object;

    public function getProvinceByMatp(String $matp): object;

    public function getDistrictByMaqh(String $maqh): object;

    public function getWardByXaid(String $xaid): object;
}
