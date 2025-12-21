<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SiteSetting::upsert([
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/clay27', 'group' => 'social'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/clay27', 'group' => 'social'],
            ['key' => 'xiaohongshu_url', 'value' => '', 'group' => 'social'],
        ], ['key'], ['value', 'group']);
    }
}
