<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Gift;

/**
 * @author Thien Nguyen <hoanthien.nguyen96@gmail.com>
 */
class GiftRepository
{
    protected $model;
    const BONUSIPHONERATE = 10; // percent
    const IPHONERATE = 5; // percent
    const CURRENCYRATE = 20; // percent
    const VOUCHERRATE = 40; // percent
    const PRIORSTORE = 1;

    /**
     * Create a new GiftRepository instance.
     *
     * @param  \App\Models\Gift
     * 
     * @return void
     */
    public function __construct(Gift $gift) 
    {
        $this->model = $gift;
    }

    /**
     * Get gift list for random employee gift
     * 
     * @param int $storeId
     * 
     * @return array $giftList
     */
    public function getGiftTable($storeId) 
    {
        $rate = [
            'Iphone' => self::IPHONERATE,
            'Một triệu tiền mặt' => self::CURRENCYRATE,
            'Vé xem phim' => self::VOUCHERRATE,
        ];

        if($storeId == self::PRIORSTORE) {
            $rate['Iphone'] = $rate['Iphone'] + self::BONUSIPHONERATE;
        }

        $giftList = $this->model->get()->each(function($item) use ($rate) {
            $item->rate = $rate[$item->name];
        });

        return $giftList->toArray();
    }

    /**
     * Get gift list
     * 
     * @param array $column
     * 
     * @return Collection
     */
    public function getGiftList($column = '*') 
    {
        return $this->model->get($column);
    }

    /**
     * Update Gift
     * 
     * @param int $id
     * @param array $data
     * 
     * @return int $giftList
     */
    public function update($id, $data)
    {
        $employeeGift = $this->model->find($id);

        $employeeGift->fill($data);

        return $employeeGift->save();
    }
}
