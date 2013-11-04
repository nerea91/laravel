<?php

class LanguagesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('languages')->delete();

		$languages = array(
			array('id' => 7,'code' => 'en','name' => 'English','english_name' => 'English','locale' => 'en_US','default' => 1,'priority' => 1, 'deleted_at' => null),
			array('id' => 8,'code' => 'sv','name' => 'Svenska','english_name' => 'Swedish','locale' => 'sv_SE','default' => 0,'priority' => 70, 'deleted_at' => '0000-00-00'),
			array('id' => 9,'code' => 'no','name' => 'Norsk','english_name' => 'Norwegian','locale' => 'no_NO','default' => 0,'priority' => 190, 'deleted_at' => '0000-00-00'),
			array('id' => 10,'code' => 'da','name' => 'Dansk','english_name' => 'Danish','locale' => 'da_DK','default' => 0,'priority' => 140, 'deleted_at' => '0000-00-00'),
			array('id' => 11,'code' => 'fi','name' => 'Suomeksi','english_name' => 'Finnish','locale' => 'fi_FI','default' => 0,'priority' => 150, 'deleted_at' => '0000-00-00'),
			array('id' => 13,'code' => 'nl','name' => 'Nederlands','english_name' => 'Dutch','locale' => 'nl_NL','default' => 0,'priority' => 90, 'deleted_at' => '0000-00-00'),
			array('id' => 14,'code' => 'de','name' => 'Deutsch','english_name' => 'German','locale' => 'de_DE','default' => 0,'priority' => 10, 'deleted_at' => '0000-00-00'),
			array('id' => 15,'code' => 'it','name' => 'Italiano','english_name' => 'Italian','locale' => 'it_IT','default' => 0,'priority' => 20, 'deleted_at' => '0000-00-00'),
			array('id' => 16,'code' => 'es','name' => 'Español','english_name' => 'Spanish','locale' => 'es_ES','default' => 0,'priority' => 5, 'deleted_at' => '0000-00-00'),
			array('id' => 17,'code' => 'fr','name' => 'Français','english_name' => 'French','locale' => 'fr_FR','default' => 0,'priority' => 30, 'deleted_at' => '0000-00-00'),
			array('id' => 18,'code' => 'pl','name' => 'Polski','english_name' => 'Polish','locale' => 'pl_PL','default' => 0,'priority' => 160, 'deleted_at' => '0000-00-00'),
			array('id' => 19,'code' => 'hu','name' => 'Magyar','english_name' => 'Hungarian','locale' => 'hu_HU','default' => 0,'priority' => 170, 'deleted_at' => '0000-00-00'),
			array('id' => 20,'code' => 'el','name' => 'Ελληνικά','english_name' => 'Greek','locale' => 'el_GR','default' => 0,'priority' => 200, 'deleted_at' => '0000-00-00'),
			array('id' => 21,'code' => 'tr','name' => 'Türkçe','english_name' => 'Turkish','locale' => 'tr_TR','default' => 0,'priority' => 210, 'deleted_at' => '0000-00-00'),
			array('id' => 22,'code' => 'ru','name' => 'русский язык','english_name' => 'Russian','locale' => 'ru_RU','default' => 0,'priority' => 60, 'deleted_at' => '0000-00-00'),
			array('id' => 24,'code' => 'he','name' => ' עברית','english_name' => 'Hebrew','locale' => 'iw_IL','default' => 0,'priority' => 160, 'deleted_at' => '0000-00-00'),
			array('id' => 25,'code' => 'ja','name' => '日本語','english_name' => 'Japanese','locale' => 'ja_JP','default' => 0,'priority' => 130, 'deleted_at' => '0000-00-00'),
			array('id' => 26,'code' => 'pt','name' => 'Português','english_name' => 'Portuguese','locale' => 'pt_PT','default' => 0,'priority' => 100, 'deleted_at' => '0000-00-00'),
			array('id' => 27,'code' => 'zh','name' => '中文','english_name' => 'Chinese','locale' => 'zh_CN','default' => 0,'priority' => 120, 'deleted_at' => '0000-00-00'),
			array('id' => 28,'code' => 'cs','name' => 'čeština','english_name' => 'Czech','locale' => 'cs_CZ','default' => 0,'priority' => 110, 'deleted_at' => '0000-00-00'),
			array('id' => 30,'code' => 'sl','name' => 'Slovenski','english_name' => 'Slovenian','locale' => 'sl_SI','default' => 0,'priority' => 230, 'deleted_at' => '0000-00-00'),
			array('id' => 31,'code' => 'hr','name' => 'Hrvatski','english_name' => 'Croatian','locale' => 'hr_HR','default' => 0,'priority' => 220, 'deleted_at' => '0000-00-00'),
			array('id' => 32,'code' => 'ko','name' => '한국어','english_name' => 'Korean','locale' => 'ko_KR','default' => 0,'priority' => 180, 'deleted_at' => '0000-00-00'),
		);

		DB::table('languages')->insert($languages);
	}

}
