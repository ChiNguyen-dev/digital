<?php

namespace App\services\imp;

use App\services\IProvinceDistrictWardService;
use Illuminate\Support\Facades\DB;

class ProvinceDistrictWardImp implements IProvinceDistrictWardService
{

    public function getAllProvince(): object
    {
        $data = DB::table('provinces')->get();
        return !empty($data) ? $data : (object)[];
    }

    public function findDistrictBymatp($matp): object
    {
        $data = DB::table('districts')->where('matp', $matp)->get();
        return !empty($data) ? $data : (object)[];
    }

    public function findWardBymaqh($maqh): object
    {
        $data = DB::table('wards')->where('maqh', $maqh)->get();
        return !empty($data) ? $data : (object)[];
    }

    public function getAddress($province_id, $district_id, $ward_id): string
    {
        $province = DB::table('provinces')->where('matp', $province_id)->first('name');
        $ward = DB::table('wards')->where('xaid', $ward_id)->first('name');
        $district = DB::table('districts')->where('maqh', $district_id)->first('name');
        return $ward->name . ',' . $district->name  . ',' . $province->name;
    }
}
