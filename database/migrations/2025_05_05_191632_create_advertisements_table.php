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
        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->string("name");
        });
        Schema::create("advertisements", function (Blueprint $table) {
            $table->id();
            $table->string("name", 40);
            $table->string("description", 500);
            $table->float("price");
            $table->date("created_at");
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create("photos", function (Blueprint $table) {
            $table->id();
            $table->foreignId("advertisement_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("url");
        });
        Schema::create("favorties", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("advertisement_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create("advertisements_categories", function (Blueprint $table) {
            $table->id();
            $table->foreignId("advertisement_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("category_id")->constrained("categories")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("categories");
        Schema::dropIfExists("advertisements");
        Schema::dropIfExists("photos");
        Schema::dropIfExists("favorties");
        Schema::dropIfExists("advertisements_categories");
    }
};
