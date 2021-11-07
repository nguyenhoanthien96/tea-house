<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GiftCodeRepository;
use App\Repositories\EmployeeGiftRepository;
use Yajra\Datatables\Datatables;
use App\Models\GiftCode;

/**
 * GiftCode Controller
 * 
 * @author Thien Nguyen <hoanthien.nguyen96@gmail.com>
 */
class GiftCodeController extends Controller
{
    protected $giftCodeRepository;
    protected $employeeGiftRepository;

    public function __construct(GiftCodeRepository $giftCodeRepository,
                                EmployeeGiftRepository $employeeGiftRepository) 
    {
        $this->giftCodeRepository = $giftCodeRepository;
        $this->employeeGiftRepository = $employeeGiftRepository;
    }

    public function index() 
    {
        return view('gift');
    }

    public function getGiftCode(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->giftCodeRepository->getGiftCodeList('gift_code');

            return DataTables::of($data)->addIndexColumn($data)->make(true);
        }
    }

    public function getEmployeeGift(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->employeeGiftRepository->getEmployeeGiftList();

            return DataTables::of($data)
                        ->editColumn('created_at', function($data) {
                            return $data->created_at->format('d/m/Y H:i:s');
                        })->addIndexColumn()->make(true);
        }
    }

    public function getGift(Request $request)
    {
        if ($request->ajax()) {
            $giftCode = $request->get('gift_code', '');
            if($this->giftCodeRepository->eventExpired()) {
                return response()->json(['message' => 'Chương trình khuyến mãi đã kết thúc !!!'], 404);
            }

            if(!$this->giftCodeRepository->validateGiftCode($giftCode)) {
                return response()->json(['message' => 'Mã dự thưởng không hợp lệ !!!'], 404);
            }
            
            $employeePhone = $this->giftCodeRepository->getEmployeePhoneByGiftCode($giftCode);
            $gift = $this->giftCodeRepository->getGiftByCode($giftCode);

            return response()->json(['gift' => $gift, 'employee_phone' => $employeePhone]);
        }
    }
}
