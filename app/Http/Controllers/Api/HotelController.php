<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\CommonHelper;
use Validator;
use App\Models\Hotel;
use App\Models\Review;
use Carbon\Carbon;

class HotelController extends Controller
{
    /**
     * Return a paginated list of hotels.
     *
     * @return json response
     */
    public function index()
    {
    }

    /**
     * Used for get the product data with image based on GTIN no
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return json response
     */
    public function getHotelData(Request $request, $hotel_id)
    {

        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required'
        ]);

        if (empty($hotel_id)) {
            $customError=CommonHelper::customErrorResponse($validator->messages()->get('*'));
            return response()->json([
                'code' => VALIDATIONERROR,
                'message' => $customError
            ]);
        }

        $hotelData = Hotel::with(['reviewget','reviewget.authorget'])->where('active',1)->find($hotel_id);
        //dd($hotelData);
        $supplierArray = [
            1=> 'Own',
            2=> 'HotelBeds',
            3=> 'SunHotels'
        ];
        //dd($supplierArray);
        if(!empty($hotelData))
        { 
            $data = [];
            $data['name'] = $hotelData->name;
            $data['address'] = $hotelData->address;
            $data['star'] = (int)$hotelData->star;
            $data['supplier'] = !empty($hotelData->supplier)? $supplierArray[$hotelData->supplier] : "";
            $data['create_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $hotelData->created_at)->format('d/M/Y H:i:s');
            $data['update_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $hotelData->updated_at)->format('d/M/Y H:i:s');
            $data['active'] = $hotelData->active == 1 ? 'Active' : '';
            
            if(!empty($hotelData->reviewget->count())){
                //dd($hotelData->reviewget); 
                foreach($hotelData->reviewget as $review)
                {
                    $data['review'][] = [
                        'title' => $review->title,
                        'description' => $review->description,
                        'author' => $review->authorget->name,
                        'create_at'=> Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('d/M/Y H:i:s'),
                        'update_at' => Carbon::createFromFormat('Y-m-d H:i:s', $review->updated_at)->format('d/M/Y H:i:s'),                    ];
                }
            }else{
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

    /**
     * Validate and save a new hotel to the database.
     *
     * @param Request $request
     * @return json response
     */
    public function store(Request $request)
    {
    }
}
