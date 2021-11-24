<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hotel;

class HotelTest extends TestCase
{
    /**
     * A feature test to get active hotel Data based on hotel id
     *
     * @return void
     */
    public function test_get_active_hotel_by_id()
    {
        $hotel_id = Hotel::where('active', 1)->get()->random()->id;
        $response = $this->get('/api/hotel/' . $hotel_id)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'message',
                    'data' => [
                        'name',
                        'star',
                        'review'
                    ],
                ]
            );
    }


    /**
     * A feature test to get all active hotel Data 
     *
     * @return void
     */
    public function test_get_all_active_hotels()
    {
        $response = $this->get('/api/hotels')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'message',
                    'data' =>  [
                        '*' => [
                            "name",
                            "address",
                            "star",
                            "supplier",
                            "create_at",
                            "update_at",
                            "active",
                            "review" => [
                                '*' => [
                                    "title",
                                    "description",
                                    "author",
                                    "create_at",
                                    "update_at"
                                ],
                            ],
                        ],
                    ],
                ]
            );
    }

    /**
     * A feature test to get inactive hotel Data based on hotel id
     *
     * @return void
     */
    public function test_for_inactive_hotel_by_id()
    {
        $hotel_id = Hotel::where('active', 0)->get()->random()->id;
        $response = $this->get('/api/hotel/' . $hotel_id)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'message',
                ]
            );
    }
}
