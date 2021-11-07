<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\EmployeeGift;

/**
 * EmployeeGift Repository
 * 
 * @author Thien Nguyen <hoanthien.nguyen96@gmail.com>
 */
class EmployeeGiftRepository
{
    protected $model;

    /**
     * Create a new EmployeeGiftRepository instance.
     *
     * @param  \App\Models\EmployeeGift
     * 
     * @return void
     */
    public function __construct(EmployeeGift $employeeGift) 
    {
        $this->model = $employeeGift;
    }

    /**
     * 
     */
    public function getEmployeeGiftList($column = '*') 
    {
        return $this->model->get($column);
    }

    /**
     * Add Employee Gift
     * 
     * @param array $data
     * 
     * @return int
     */
    public function add($data)
    {
        $employeeGift = new $this->model;

        $employeeGift->fill($data);

        return $employeeGift->save();
    }
}
