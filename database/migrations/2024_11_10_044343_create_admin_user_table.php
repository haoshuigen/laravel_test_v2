<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_user', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('username', 20)->nullable(false)->unique('uniq_username');
            $table->string('password', 50)->nullable(false)->comment('用户密码');
            $table->string('salt', 6)->nullable(false)->comment('用户密码salt');
            $table->string('role_ids', 20)->nullable(false)->comment('用户角色列表,多个角色用英文逗号分隔');
            $table->tinyInteger('disabled', false, true)->default(0)->comment('是否被禁用0:正常,1:被禁用')->nullable(false);
            $table->integer('last_login_time', false, true)->comment('上次登录时间')->default(null)->nullable();
            $table->integer('create_time', false, true)->comment('创建时间')->default(null);
            $table->comment('后台用户表');
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_user');
    }
};
