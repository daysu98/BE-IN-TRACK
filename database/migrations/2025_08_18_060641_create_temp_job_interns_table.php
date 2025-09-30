<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temp_job_interns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('job_intern_id')->references('id')->on('job_interns')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('created');
            $table->string('task');
            $table->text('description');
            $table->date('deadline')->nullable();
            $table->enum('status', ['Pending', 'Done'])->nullable();
            $table->string('manage_by');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_job_interns');
    }
};
