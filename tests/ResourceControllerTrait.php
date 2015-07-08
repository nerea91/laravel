<?php

trait ResourceControllerTrait
{
	protected function resource($route)
	{
		$this->resource = $route;

		return $this;
	}

	protected function table($table)
	{
		$this->table = $table;

		return $this;
	}

	protected function relationships()
	{
		$this->relationships = func_get_args();

		return $this;
	}

	// Test resource creation via HTTP
	protected function create(array $data)
	{
		$user = $this->getSuperUser();
		$route = $this->resource;
		$page = route("admin.$route.create");
		$button = _('Add');
		$table = (isset($this->table)) ? $this->table : $route;
		$expected = (isset($this->relationships)) ? array_except($data, $this->relationships) : $data;

		$this
		->actingAs($user)
		->visit($page)
		->submitForm($button, $data)
		->assertSessionHasNoErrors($route)
		->seePageIs(route("admin.$route.show", [(int) DB::table($table)->max('id')]))
		->seeInDatabase($table, $expected);

		return $this;
	}

	// Test resource deletion via HTTP
	protected function destroy($id, $primaryKey = 'id')
	{
		$user = $this->getSuperUser();
		$route = $this->resource;
		$table = (isset($this->table)) ? $this->table : $route;
		$page = route("admin.$route.destroy", $id);
		$landingPage = route("admin.$route.index");
		$button = _('Confirm');
		$expected = [$primaryKey => $id];

		// Handle softDeletes
		if(Schema::hasColumn($table, 'deleted_at'))
			$expected['deleted_at'] = null;

		$this
		->seeInDatabase($table, $expected)
		->actingAs($user)
		->visit($page)
		->press($button)
		->assertSessionHasNoErrors($route)
		->seePageIs($landingPage)
		->notSeeInDatabase($table, $expected);

		return $this;
	}
}
