<?php

use App\Constants\DatabaseTableConstant;
use App\Constants\ReviewerVisibilityConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReviewersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(DatabaseTableConstant::REVIEWERS, function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->dateTime('deleted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained(DatabaseTableConstant::USERS);
            $table->foreignId('updated_by')->nullable()->constrained(DatabaseTableConstant::USERS);
            $table->foreignId('deleted_by')->nullable()->constrained(DatabaseTableConstant::USERS);
            $table->foreignId('user_id')->constrained(DatabaseTableConstant::USERS);
            $table->string('name');
            $table->string('visibility')->default(ReviewerVisibilityConstant::PRIVATE);
            $table->text('description')->nullable();
            $table->text('cover_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(DatabaseTableConstant::REVIEWERS);
    }

}
