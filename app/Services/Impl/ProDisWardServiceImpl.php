<?php

namespace App\Services\Impl;

use App\Services\Interfaces\IProDisWardService;
use Illuminate\Support\Facades\DB;

class ProDisWardServiceImpl implements IProDisWardService
{
    public function getProvinces(): object
    {
        $data = DB::table('provinces')->get();
        return !empty($data) ? $data : (object)[];
    }

    public function getDistrictsByMatp(String $matp): object
    {
        $data = DB::table('districts')->where('matp', $matp)->get();
        return !empty($data) ? $data : (object)[];
    }

    public function getWardsByMaqh(String $maqh): object
    {
        $data = DB::table('wards')->where('maqh', $maqh)->get();
        return !empty($data) ? $data : (object)[];
    }

    public function getProvinceByMatp(String $matp): object
    {
        $province = DB::table('provinces')->where('matp', $matp)->first();
        return ($province != null) ? $province : (object)[];
    }

    public function getDistrictByMaqh(String $maqh): object
    {
        $district = DB::table('districts')->where('maqh', $maqh)->first();
        return ($district != null) ? $district : (object)[];
    }

    public function getWardByXaid(String $xaid): object
    {
        $ward = DB::table('wards')->where('xaid', $xaid)->first();
        return ($ward != null) ? $ward : (object)[];
    }
}
