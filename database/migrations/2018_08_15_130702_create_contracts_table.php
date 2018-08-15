<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'contract';

        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id')->comment('流水號');
            $table->integer('owner_user_id')->comment('莊家使用者流水號');
            $table->string('ethereum_address', 50)->comment('以太錢包位址');
            $table->timestamps();
            $table->index('owner_user_id', 'owner_user_id');
        });

        DB::statement("ALTER TABLE `" . $table_name . "` comment '合約管理'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
