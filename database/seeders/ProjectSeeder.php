<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'name' => 'GlobalGPT',
            'api_key' => config('services.openai.key'),
            'temperature' => 0.7,
            'max_token' => 1000,
            'description' => 'AI Chat Assistant',
            'model' => 'gpt-3.5-turbo',
            'is_active' => true,
        ]);

        Project::create([
            'name' => 'AI Assistant',
            'api_key' => config('services.openai.key'),
            'temperature' => 0.5,
            'max_token' => 800,
            'description' => 'Smart Helper Bot',
            'model' => 'gpt-3.5-turbo',
            'is_active' => true,
        ]);

        Project::create([
            'name' => 'Content Generator',
            'api_key' => config('services.openai.key'),
            'temperature' => 0.9,
            'max_token' => 1500,
            'description' => 'AI Content Writer',
            'model' => 'gpt-3.5-turbo',
            'is_active' => false,
        ]);
    }
}
