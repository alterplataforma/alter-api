<?php

namespace Database\Seeders;

use App\Models\Support\FrequentQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class FrequentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < count(FrequentQuestion::QUESTIONS); $i++) {
            FrequentQuestion::create([
                'question' => FrequentQuestion::QUESTIONS[$i],
                'answer' => FrequentQuestion::ANSWER[$i],
                'keywords' => FrequentQuestion::KEYWORDS[$i],
                'id_support_theme' => FrequentQuestion::THEME_VALUE[$i],
                'id_user_register' => User::all()->random()->id,
            ]);
        }
    }
}
