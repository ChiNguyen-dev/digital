<?php

namespace App\services;

use Illuminate\Support\Facades\DB;

class ProvinceDistrictWard
{
    private $provinces;
    private $district;
    private $wards;

    public function __construct()
    {
    }

    public function getAllProvince(): object
    {
        $data = DB::table('provinces')->get();
        $this->setProvinces($data);
        return $this->getProvinces();
    }

    public function findDistrictBymatp($matp): object
    {
        $data = DB::table('districts')->where('matp', $matp)->get();
        $this->setDistrict($data);
        return $this->getDistrict();
    }

    public function findWardBymaqh($maqh): object
    {
        $data = DB::table('wards')->where('maqh', $maqh)->get();
        $this->setWards($data);
        return $this->getWards();
    }

    public function findProvinceById($id)
    {
        $result = DB::table('provinces')->where('matp', $id)->first();
        return !empty($result) ? $result : null;
    }

    public function findDistrictById($id)
    {
        $result = DB::table('districts')->where('maqh', $id)->first();
        return !empty($result) ? $result : null;
    }

    public function findWardById($id)
    {
        $result = DB::table('wards')->where('xaid', $id)->first();
        return !empty($result) ? $result : null;
    }

    public function getAddress($province_id, $district_id, $ward_id): string
    {
        $province = $this->findProvinceById($province_id)->name;
        $ward = $this->findWardById($ward_id)->name;
        $district = $this->findDistrictById($district_id)->name;
        return $ward . ',' . $district . ',' . $province;
    }

    /**
     * @return object
     */
    public function getProvinces(): object
    {
        return $this->provinces;
    }

    /**
     * @param object $provinces
     */
    public function setProvinces(object $provinces): void
    {
        $this->provinces = $provinces;
    }

    /**
     * @return object
     */
    public function getDistrict(): object
    {
        return $this->district;
    }

    /**
     * @param object $district
     */
    public function setDistrict(object $district): void
    {
        $this->district = $district;
    }

    /**
     * @return object
     */
    public function getWards(): object
    {
        return $this->wards;
    }

    /**
     * @param object $wards
     */
    public function setWards(object $wards): void
    {
        $this->wards = $wards;
    }
}
