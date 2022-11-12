<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static function quickRandom($length = 16, $type)
    {
        $options = 'ABCD';
        $poolQuesEng = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $poolQuesHindi = 'अ आ इ ई उ ऊ ऋ ए ऐ ओ औ अं क ख ग घ ङ च छ ज झ ञ ट ठ ड ढ ण ड़ ढ़ त थ द ध न प फ ब भ म य र ल व श ष स ह क्ष त्र ज्ञ';
        // $poolQuesMal = 'മലയാളംഭാഷയിലെസ്വരാക്ഷരങ്ങൾഒഴിച്ച്ഓരോഅക്ഷരങ്ങൾക്കും';
        // $poolQuesKan = 'ಅಆಇಈಉಊಋೠಎಏಐಒಓಔಕಖಗಘಙಚಛಜಝಞಟಠಡಢಣತಥದಧನಪಫಬಭಮಯರಱಲವಶಷಸಹಳೞ';

        if($type == "eng"){
            return 'ENG-'.substr(str_shuffle(str_repeat($poolQuesEng, 5)), 0, $length);
        }else if($type == "hindi"){
            return 'HINDI-'.substr(str_shuffle(str_repeat($poolQuesEng, 5)), 0, $length);
        }else if($type == "mal"){
            return 'MAL-'.substr(str_shuffle(str_repeat($poolQuesEng, 5)), 0, $length);
        }else if($type == "kan"){
            return 'KAN-'.substr(str_shuffle(str_repeat($poolQuesEng, 5)), 0, $length);
        }else if($type == "option"){
            return substr(str_shuffle(str_repeat($options, 5)), 0, $length);
        }else{
            return substr(str_shuffle(str_repeat($poolQuesEng, 5)), 0, $length);
        }
    }

    public function run()
    {
        for($i=0;$i<200;$i++){
        DB::table('questions')->insert([
            'question_eng' => $this->quickRandom(25, 'eng'),
            'question_hindi' => $this->quickRandom(25, 'hindi'),
            'question_mal' => $this->quickRandom(25, 'mal'),
            'question_kan' => $this->quickRandom(25, 'kan'),

            'ans_eng_a' => $this->quickRandom(10, 'eng'),
            'ans_hindi_a' => $this->quickRandom(10, 'hindi'),
            'ans_mal_a' => $this->quickRandom(10, 'mal'),
            'ans_kan_a' => $this->quickRandom(10, 'kan'),

            'ans_eng_b' => $this->quickRandom(10, 'eng'),
            'ans_hindi_b' => $this->quickRandom(10, 'hindi'),
            'ans_mal_b' => $this->quickRandom(10, 'mal'),
            'ans_kan_b' => $this->quickRandom(10, 'kan'),

            'ans_eng_c' => $this->quickRandom(10, 'eng'),
            'ans_hindi_c' => $this->quickRandom(10, 'hindi'),
            'ans_mal_c' => $this->quickRandom(10, 'mal'),
            'ans_kan_c' => $this->quickRandom(10, 'kan'),

            'ans_eng_d' => $this->quickRandom(10, 'eng'),
            'ans_hindi_d' => $this->quickRandom(10, 'hindi'),
            'ans_mal_d' => $this->quickRandom(10, 'mal'),
            'ans_kan_d' => $this->quickRandom(10, 'kan'),

            'answer_option' => $this->quickRandom(1, 'option'),
            'created_at' => '2022-11-12 12:12:12',
            'updated_at' => '2022-11-12 12:12:12',
        ]);
        }
    }
}
