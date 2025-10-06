<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->string('group')->default('general'); // general, aitext, etc.
            $table->timestamps();
        });

        // Insérer les paramètres AI par défaut
        DB::table('settings')->insert([
            [
                'key' => 'ai_text_provider',
                'value' => 'gemini',
                'type' => 'string',
                'group' => 'aitext',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'ai_text_api_key',
                'value' => '',
                'type' => 'string',
                'group' => 'aitext',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'ai_text_model',
                'value' => 'gemini-1.5-flash',
                'type' => 'string',
                'group' => 'aitext',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'ai_text_temperature',
                'value' => '0.7',
                'type' => 'string',
                'group' => 'aitext',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'ai_text_max_tokens',
                'value' => '1024',
                'type' => 'string',
                'group' => 'aitext',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};