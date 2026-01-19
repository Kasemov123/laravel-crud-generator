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
        Schema::table('components', function (Blueprint $table) {
            $table->json('props')->nullable()->after('uploaded_file');
            $table->json('default_props')->nullable()->after('props');
        });

        Schema::create('component_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('classes');
            $table->json('preview_props')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->index('component_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('component_variants');
        
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn(['props', 'default_props']);
        });
    }
};
