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
        Schema::create('sim_card_recharges', function (Blueprint $table) {
            $table->id();

            $table->string('iccid');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('available_days')->default(0);
            $table->integer('status');
            $table->float('price');
            $table->string('email')->nullable();
            $table->string('payment_intent')->nullable();
            $table->string('payment_intent_client_secret')->nullable();

            $table->unsignedBigInteger('sim_card_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->foreign('sim_card_id')
                ->references('id')
                ->on('sim_cards')
                ->onDelete('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sim_card_recharges');
    }
}
