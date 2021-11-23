<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id')->unsinged();
            $table->string('name', 100);
            $table->text('address')->nullable();
            $table->float('star')->nullable();
            $table->tinyInteger('supplier')->nullable()->comment = '1 = Own,2 = HotelBeds,3 = SunHotels';
            $table->tinyInteger('active')->default(1)->comment = '1 = active,0 = Inactive';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
