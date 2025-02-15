<?php

use App\Models\Student;
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
        Schema::create('student_subject_score', function (Blueprint $table) {
            $table->string('student_nisn')
                ->foreign('student_nisn')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Subject::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->float('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject_score');
    }
};
