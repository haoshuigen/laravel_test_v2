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
        Schema::create('sql_execution_log', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->string('user', 30)->nullable(false);
            $table->string('sql', 500)->nullable(false)->default('');
            $table->float('time')->nullable(false)->default(0.00);
            $table->string('error', 500)->nullable()->default('');
            $table->integer('create_time', false, true)->nullable()->default(null);
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sql_execution_log');
    }
};
