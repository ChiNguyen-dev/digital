<?php

namespace App\services;

interface IProvinceDistrictWardService
{
    public function getAllProvince(): object;

    public function findDistrictBymatp($matp): object;

    public function findWardBymaqh($maqh): object;

    public function getAddress($province_id, $district_id, $ward_id): string;
}
