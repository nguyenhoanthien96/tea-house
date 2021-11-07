<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\GiftCode;
use App\Repositories\EmployeeGiftRepository;
use App\Repositories\GiftRepository;
use DB;

/**
 * GiftCode Repository
 * 
 * @author Thien Nguyen <hoanthien.nguyen96@gmail.com>
 */
class GiftCodeRepository
{
    protected $model;
    protected $giftRepository;
    protected $employeeGiftRepository;
    protected const TOTALRATE = 100;

    /**
     * Create a new GiftCodeRepository instance.
     *
     * @param  \App\Models\GiftCode
     * @param  \App\Repositories\GiftRepository
     * @param  \App\Repositories\EmployeeGiftRepository
     * 
     * @return void
     */
    public function __construct(GiftCode $giftCode, 
                                GiftRepository $giftRepository,
                                EmployeeGiftRepository $employeeGiftRepository)
    {
        $this->model = $giftCode;
        $this->giftRepository = $giftRepository;
        $this->employeeGiftRepository = $employeeGiftRepository;
    }

    /**
     * Validate gift code is valid
     * 
     * @param string $giftCode
     * 
     * @return boolean
     */
    public function validateGiftCode($giftCode) 
    {
        $result = true;

        try {
            $giftCode = $this->model->where('gift_code', $giftCode)->firstOrFail();
        }
        catch(\Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * Check if event is expired
     * 
     * @return boolean
     */
    public function eventExpired() 
    {
        $outStockGift = [];
        $gifts = $this->giftRepository->getGiftList();

        foreach($gifts as $gift) {
            if($gift->number == 0) {
                $outStockGift[] = $gift->name;
            }
        }
        
        return count($outStockGift) == 3;
    }

    /**
     * Get gift code list for datatable
     * 
     * @param array $column
     * 
     * @return Collection
     */
    public function getGiftCodeList($column = '*') 
    {
        return $this->model->get($column);
    }

    /**
     * Get Phone number of employee by gift code
     * 
     * @param string $giftCode
     * 
     * @return string $employeePhone
     */
    public function getEmployeePhoneByGiftCode($giftCode)
    {
        $giftCode = $this->model->where('gift_code', $giftCode)->first();
        $employeePhone = $giftCode->employee_phone;

        return $employeePhone;
    }

    /**
     * Get Gift By Gift Code
     * 
     * @param string $giftCode
     * 
     * @return string|boolean $gift
     */
    public function getGiftByCode($giftCode)
    {
        $giftCodeModel = $this->model->where('gift_code', $giftCode)->first();
        $tableGift = $this->giftRepository->getGiftTable($giftCodeModel->store_id);
        $gift = false;

        $gift = DB::transaction(function() use ($giftCodeModel, $tableGift){
            $ran = mt_rand(1, self::TOTALRATE * 100);
            $sum = 0;

            $deleteGiftCode = $giftCodeModel->delete();

            if($deleteGiftCode) {
                for($i = 0; $i < count($tableGift); $i++) {
                    $sum = $sum + ($tableGift[$i]['rate']*self::TOTALRATE);
                    
                    if($tableGift[$i]['number'] > 0 && $sum >= $ran) {
                        $arrEmployeeGift = [
                            'employee_phone' => $giftCodeModel->employee_phone, 
                            'gift' => $tableGift[$i]['name'],
                            'store_id' => $giftCodeModel->store_id,
                        ];

                        $this->employeeGiftRepository->add($arrEmployeeGift);
                        $this->giftRepository->update($tableGift[$i]['id'], ['number' => $tableGift[$i]['number'] - 1]);
        
                        return $tableGift[$i]['name'];
                    }
                }
            }
        });

        return $gift;
    }
}
