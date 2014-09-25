<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
	public function run()
	{
		$languages = [
			['id' => 7,  'code' => 'en', 'name' => 'English',	 	'english_name' => 'English', 	'locale' => 'en_US',	'priority' => 1, 	'is_default' => 1],
			['id' => 8,  'code' => 'sv', 'name' => 'Svenska', 		'english_name' => 'Swedish', 	'locale' => 'sv_SE', 	'priority' => 70, 	'is_default' => 0],
			['id' => 9,  'code' => 'no', 'name' => 'Norsk', 		'english_name' => 'Norwegian', 	'locale' => 'no_NO', 	'priority' => 190, 	'is_default' => 0],
			['id' => 10, 'code' => 'da', 'name' => 'Dansk', 		'english_name' => 'Danish', 	'locale' => 'da_DK', 	'priority' => 140, 	'is_default' => 0],
			['id' => 11, 'code' => 'fi', 'name' => 'Suomeksi',	 	'english_name' => 'Finnish', 	'locale' => 'fi_FI', 	'priority' => 150, 	'is_default' => 0],
			['id' => 13, 'code' => 'nl', 'name' => 'Nederlands', 	'english_name' => 'Dutch', 		'locale' => 'nl_NL', 	'priority' => 90, 	'is_default' => 0],
			['id' => 14, 'code' => 'de', 'name' => 'Deutsch', 		'english_name' => 'German', 	'locale' => 'de_DE', 	'priority' => 10, 	'is_default' => 0],
			['id' => 15, 'code' => 'it', 'name' => 'Italiano', 		'english_name' => 'Italian', 	'locale' => 'it_IT', 	'priority' => 20, 	'is_default' => 0],
			['id' => 16, 'code' => 'es', 'name' => 'Español', 		'english_name' => 'Spanish', 	'locale' => 'es_ES', 	'priority' => 5, 	'is_default' => 0],
			['id' => 17, 'code' => 'fr', 'name' => 'Français', 		'english_name' => 'French', 	'locale' => 'fr_FR', 	'priority' => 30, 	'is_default' => 0],
			['id' => 18, 'code' => 'pl', 'name' => 'Polski', 		'english_name' => 'Polish', 	'locale' => 'pl_PL', 	'priority' => 160, 	'is_default' => 0],
			['id' => 19, 'code' => 'hu', 'name' => 'Magyar', 		'english_name' => 'Hungarian', 	'locale' => 'hu_HU', 	'priority' => 170, 	'is_default' => 0],
			['id' => 20, 'code' => 'el', 'name' => 'Ελληνικά', 		'english_name' => 'Greek', 		'locale' => 'el_GR', 	'priority' => 200, 	'is_default' => 0],
			['id' => 21, 'code' => 'tr', 'name' => 'Türkçe', 		'english_name' => 'Turkish', 	'locale' => 'tr_TR', 	'priority' => 210, 	'is_default' => 0],
			['id' => 22, 'code' => 'ru', 'name' => 'русский язык',	'english_name' => 'Russian', 	'locale' => 'ru_RU', 	'priority' => 60, 	'is_default' => 0],
			['id' => 24, 'code' => 'he', 'name' => ' עברית', 		'english_name' => 'Hebrew', 	'locale' => 'iw_IL', 	'priority' => 160, 	'is_default' => 0],
			['id' => 25, 'code' => 'ja', 'name' => '日本語', 		'english_name' => 'Japanese', 	'locale' => 'ja_JP', 	'priority' => 130, 	'is_default' => 0],
			['id' => 26, 'code' => 'pt', 'name' => 'Português', 	'english_name' => 'Portuguese', 'locale' => 'pt_PT', 	'priority' => 100, 	'is_default' => 0],
			['id' => 27, 'code' => 'zh', 'name' => '中文', 			'english_name' => 'Chinese', 	'locale' => 'zh_CN', 	'priority' => 120, 	'is_default' => 0],
			['id' => 28, 'code' => 'cs', 'name' => 'čeština', 		'english_name' => 'Czech', 		'locale' => 'cs_CZ', 	'priority' => 110, 	'is_default' => 0],
			['id' => 30, 'code' => 'sl', 'name' => 'Slovenski', 	'english_name' => 'Slovenian', 	'locale' => 'sl_SI', 	'priority' => 230, 	'is_default' => 0],
			['id' => 31, 'code' => 'hr', 'name' => 'Hrvatski', 		'english_name' => 'Croatian', 	'locale' => 'hr_HR', 	'priority' => 220, 	'is_default' => 0],
			['id' => 32, 'code' => 'ko', 'name' => '한국어', 		'english_name' => 'Korean', 	'locale' => 'ko_KR', 	'priority' => 180, 	'is_default' => 0],
		];

		// Insert
		DB::table('languages')->insert($languages);
	}
}
