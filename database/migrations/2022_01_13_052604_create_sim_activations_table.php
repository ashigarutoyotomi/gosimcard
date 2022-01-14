<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\SimCard\Models\SimCard;
class CreateSimActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_activations', function (Blueprint $table) {
            $table->id()->autoincrements();
            $table->timestamps();
            $table->integer('available_days')->default(0);
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('status')->default(SimCard::STATUS_NEW);
            $table->integer('sim_card_id');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sim_activations');
    }
}
