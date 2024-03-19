<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Modules\Ynotz\AppSettings\Models\AppSetting;
use Modules\Ynotz\AppSettings\Models\AppSetting;
use Modules\Ynotz\AppSettings\Database\Factories\AppSettingFactory;




class AppSettingSeeder extends Seeder
{
    private $settings = [
        [
            'name' => 'Email As Username',
            'slug' => 'email-as-username',
            'value_type' => 'boolean',
            'value' => true,
            'auto_manage' => true
        ]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->settings as $s) {
            AppSetting::factory()->create($s);
        }
    }
}
