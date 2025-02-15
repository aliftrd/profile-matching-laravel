<?php

use App\Models\Major;
use App\Models\Subject;
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
        Schema::create('major_subject', function (Blueprint $table) {
            $table->foreignIdFor(Subject::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Major::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('major_subject');
    }
};
