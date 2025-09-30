<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_interns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('created');
            $table->string('task');
            $table->text('description');
            $table->date('deadline')->nullable();
            $table->enum('status', ['Pending', 'Done'])->nullable();
            $table->string('manage_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_interns');
    }
};
