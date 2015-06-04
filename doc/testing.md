# List of Laravel specific testing helpers and assertions

Run all tests

	./vendor/bin/phpunit

Run all test on a single test suit

	./vendor/bin/phpunit tests/TestSuit.php

Run a single test on a single test suit

	./vendor/bin/phpunit --filter testSomething TestSuit tests/TestSuit.php

To programatically skip an incomplete test

	$this->markTestIncomplete('TODO This test has not been implemented yet');

## List of Laravel specific testing helpers and assertions

**NOTE:** Methods starting with `+` are chainable

### From ApplicationTrait

Public methods

	+expectsEvents($events)
	+withSession(array $data) ALIAS session(array $data)
	flushSession()
	+actingAs(UserContract $user, $driver = null) ALIAS be(UserContract $user, $driver = null)
	seed($class = 'DatabaseSeeder')
	artisan($command, $parameters = [])

Protected methods

	refreshApplication()
	+instance($abstract, $instance)
	+withoutEvents()
	+expectsJobs($jobs)
	startSession()
	+seeInDatabase($table, array $data)
	+notSeeInDatabase($table, array $data) ALIAS +missingFromDatabase($table, array $data)

### From CrawlerTrait

Public methods

	+visit($uri)
	+get($uri, $headers = [])
	+post($uri, $data = [], $headers = [])
	+put($uri, $data = [], $headers = [])
	+patch($uri, $data = [], $headers = [])
	+delete($uri, $data = [], $headers = [])
	+seeJsonEquals(array $data)
	+seeJson(array $data = null)
	call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	callSecure($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	action($method, $action, $wildcards = [], $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	route($method, $name, $routeParameters = [], $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	+withoutMiddleware()

Protected methods

	+makeRequest($method, $uri, $parameters = [], $cookies = [], $files = [])
	makeRequestUsingForm(Form $form)
	+followRedirects()
	+clearInputs()
	assertPageLoaded($uri, $message = null)
	+see($text, $negate = false)
	+shouldReturnJson(array $data = null) ALIAS +receiveJson($data = null)
	+seeJsonContains(array $data)
	formatToExpectedJson($key, $value)
	+seeStatusCode($status)
	+seePageIs($uri) ALIAS +onPage($uri) ALIAS +landOn($uri) ALIAS
	+click($name)
	+type($text, $element)
	+check($element)
	+select($option, $element)
	+attach($absolutePath, $element)
	+press($buttonText)
	+submitForm($buttonText, $inputs = [])
	fillForm($buttonText, $inputs = [])
	getForm($buttonText = null)
	+storeInput($element, $text)
	assertFilterProducesResults($filter)
	filterByNameOrId($name, $element = '*')
	prepareUrlForRequest($uri)

### From AssertionsTrait

Public methods

	assertHasOldInput()
	assertRedirectedTo($uri, $with = [])
	assertRedirectedToAction($name, $parameters = [], $with = [])
	assertRedirectedToRoute($name, $parameters = [], $with = [])
	assertResponseOk()
	assertResponseStatus($code)
	assertSessionHas($key, $value = null)
	assertSessionHasAll(array $bindings)
	assertSessionHasErrors($bindings = [], $format = null)
	assertViewHas($key, $value = null)
	assertViewHasAll(array $bindings)
	assertViewMissing($key)
