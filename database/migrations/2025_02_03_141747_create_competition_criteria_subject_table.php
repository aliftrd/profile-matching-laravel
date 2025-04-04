<?php

use App\Models\CompetitionCriteria;
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
        Schema::create('competition_criteria_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CompetitionCriteria::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Subject::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->float('target_score');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_criteria_subject');
    }
};
