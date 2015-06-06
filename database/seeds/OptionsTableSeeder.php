<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
	public function run()
	{
		$options = [
			[
				'id'               => 1,
				'name'             => 'admin_panel_results_per_page',
				'label'            => _('Results per page'),
				'description'      => null, // Optional
				'value'            => 15, // default value
				'assignable'       => 1, //wether or not the user can change this options
				'validation_rules' => 'required|integer|min:5|max:50',
			],
		];

		DB::table('options')->insert($options);
	}
}
