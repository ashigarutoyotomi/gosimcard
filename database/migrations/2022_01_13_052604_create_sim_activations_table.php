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
            $table->id();
            $table->integer('available_days')->default(0);
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('status')->default(SimCard::STATUS_NEW);
            $table->unsignedBigInteger('sim_card_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('sim_card_id')
                ->references('id')
                ->on('simcards')
                ->onDelete('cascade');
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
