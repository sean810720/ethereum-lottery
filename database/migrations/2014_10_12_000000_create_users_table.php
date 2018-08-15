<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'users';

        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id')->comment('流水號');
            $table->string('name')->comment('姓名');
            $table->string('email')->unique()->comment('E-mail (帳號)');
            $table->string('password')->comment('密碼');
            $table->enum('is_owner', [0, 1])->default('0')->comment('是否為莊家 (0:否 | 1:是)');
            $table->enum('status', [0, 1])->default('1')->comment('開啟狀態 (0:關閉 | 1:開啟)');
            $table->text('ethereum_keycode')->nullable()->comment('以太鏈帳號通關文字');
            $table->string('ethereum_address', 50)->nullable()->comment('以太錢包位址');
            $table->rememberToken();
            $table->timestamps();

            $table->index('ethereum_address', 'ethereum_address');
        });

        DB::statement("ALTER TABLE `" . $table_name . "` comment '使用者管理'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
