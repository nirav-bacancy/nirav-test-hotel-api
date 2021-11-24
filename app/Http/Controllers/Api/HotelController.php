<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\CommonHelper;
use Validator;
use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class HotelController extends Controller
{
    /**
     * Used for get the all Active Hotel data
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function getAllHotelData(Request $request): JsonResponse
    {
        // fetch all active hotel data with review & author data
        $hotelData = Hotel::with(['reviewget', 'reviewget.authorget'])->where('active', 1)->get();

        if (!empty($hotelData->count())) {
            foreach ($hotelData as $key => $hotel) {
                $data[$key] = [
                    'name' => $hotel->name,
                    'address' => $hotel->address,
                    'star' => (int)$hotel->star,
                    'supplier' => !empty($hotel->supplier) ? supplierArray[$hotel->supplier] : "",
                    'create_at' => Carbon::createFromFormat('Y-m-d H:i:s', $hotel->created_at)->format('d/M/Y H:i:s'),
                    'update_at' => Carbon::createFromFormat('Y-m-d H:i:s', $hotel->updated_at)->format('d/M/Y H:i:s'),
                    'active' => $hotel->active == 1 ? 'Active' : '',
                ];
                if (!empty($hotel->reviewget->count())) {
                    foreach ($hotel->reviewget as $review) {
                        $data[$key]['review'][] = [
                            'title' => $review->title,
                            'description' => $review->description,
                            'author' => $review->authorget->name,
                            'create_at' => Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('d/M/Y H:i:s'),
                            'update_at' => Carbon::createFromFormat('Y-m-d H:i:s', $review->updated_at)->format('d/M/Y H:i:s'),
                        ];
                    }
                } else {
                    $data[$key]['review'] = '';
                }
            }
            return response()->json([
                'code' => SUCCESS,
                'message' => HOTELDATAMSG,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'code' => FAILED,
                'message' => HOTELDATANOTFOUNDMSG
            ]);
        }
    }

    /**
     * Used for get the Active Hotel data based on hotel Id 
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @param  int $hotel_id 
     * @return Illuminate\Http\JsonResponse
     */
    public function getHotelDataById(Request $request, int $hotel_id): JsonResponse
    {
        // validate the hotel_id
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|numeric'
        ]);

        // if empty hotel id then return error 
        if (empty($hotel_id)) {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get('*'));
            return response()->json([
                'code' => VALIDATIONERROR,
                'message' => $customError
            ]);
        }

        // fetch active hotel data with review & author data
        $hotelData = Hotel::with(['reviewget', 'reviewget.authorget'])->where('active', 1)->find($hotel_id);

        if (!empty($hotelData)) {
            $data = [];
            $data['name'] = $hotelData->name;
            $data['star'] = (int)$hotelData->star;

            if (!empty($hotelData->reviewget->count())) {
                foreach ($hotelData->reviewget as $review) {
                    $data['review'][] = [
                        'title' => $review->title,
                        'description' => $review->description,
                        'author' => $review->authorget->name,
                        'create_at' => Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('d/M/Y H:i:s'),
                        'update_at' => Carbon::createFromFormat('Y-m-d H:i:s', $review->updated_at)->format('d/M/Y H:i:s'),
                    ];
                }
            } else {
                $data['review'] = '';
            }
            return response()->json([
                'code' => SUCCESS,
                'message' => HOTELDATAMSG,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'code' => FAILED,
                'message' => HOTELDATANOTFOUNDMSG
            ]);
        }
    }
}
