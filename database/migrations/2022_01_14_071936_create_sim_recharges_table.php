<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\SimCard\Models\SimCard;
class CreateSimRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_recharges', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('number');
            //status 1 - new, 2 -recharged
            $table->integer('status')->default(SimCard::STATUS_NEW);
            $table->string('email')->nullable()->unique();
            $table->integer('sim_card_id');
            $table->integer('days')->default(0);
            $table->foreign('sim_card_id')->references('id')->on('simcards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sim_recharges');
    }
}
