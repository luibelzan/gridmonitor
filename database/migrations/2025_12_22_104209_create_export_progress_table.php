<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::connection('pgsql-exports')->create('export_progress', function (Blueprint $table) {
        $table->id();
        $table->string('export_id')->index();
        $table->string('status');
        $table->unsignedTinyInteger('progress')->default(0);
        $table->string('file_path')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::connection('pgsql-exports')->dropIfExists('export_progress');
}

};
