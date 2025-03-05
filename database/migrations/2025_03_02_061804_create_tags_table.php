<?php

use App\Models\{Job, Tag};
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
        // this is actual table that contains tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // this is the Join Table/Pivot Table/Associative Table
        // that contains both JobListing and the Tags associated with it
        Schema::create('job_tag', function (Blueprint $table) {
            $table->id();
            // pointing to "job_listing_id" instead of "job_id"
            // to avoid an orphan or a Job/Tag record that points to a non-existing Job/Tag
            // add a constraint and a trigger to delete if either gets deleted
            $table->foreignIdFor(Job::class, 'job_listing_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('job_tag');
    }
};
