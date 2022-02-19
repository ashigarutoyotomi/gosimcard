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

            $table->string('sim_number');
            $table->integer('available_days')->default(0);
            $table->integer('status');
            $table->string('email')->nullable();

            $table->unsignedBigInteger('sim_card_id');

            $table->timestamps();

            $table->foreign('sim_card_id')
                ->references('id')
                ->on('sim_cards');

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
