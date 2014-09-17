<?php namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Input;
use Redirect;
use Session;
use Validator;

abstract class ReportController extends Controller
{
	/**
	 * The layout that should be used for responses.
	 * @var string
	 */
	protected $layout = 'layouts.report';

	/**
	 * The class that will be applied to the off-canvas container that should be used for responses.
	 * @var string
	 */
	protected $offCanvasClass;

	/**
	 * The title of the report.
	 * @var string
	 */
	protected $title;

	/**
	 * The subtitle of the report.
	 * @var string
	 */
	protected $subtitle;

	/**
	 * The view file.
	 * @var string
	 */
	protected $view;

	/**
	 * Extra data passed to the view
	 * @var array
	 */
	protected $data = [];

	/**
	 * Form fields labels.
	 * @var array
	 */
	protected $labels = [];

	/**
	 * Form fields rules.
	 * @var array
	 */
	protected $rules = [];

	/**
	 * Form fields default values.
	 * @var array
	 */
	protected $defaultInput = [];

	/**
	 * Class constructor.
	 *
	 * Initialize class properties.
	 *
	 * @param  string $title  Title of the report
	 * @param  string $view   View file for showing the results
	 * @param  array  $fields Form fields labels and validation rules
	 * @param  array  $input  Default form input
	 * @param  string $offCanvasClass Class to apply to the off-canvas
	 * @return void
	 */
	public function __construct($title, $view, array $fields, array $input, $offCanvasClass = null)
	{
		// Enable CSRF filter
		parent::__construct();

		$this->title = $title;
		$this->view = $view;
		$this->defaultInput = $input;
		list($this->labels, $this->rules) = \App\Validation\Validator::parseRules($fields);
		$this->offCanvasClass = $offCanvasClass;
	}

	/**
	 * Get report title.
	 *
	 * @return string
	 */
	public function title()
	{
		return (string) $this->title;
	}

	/**
	 * Get report subtitle.
	 *
	 * @return string
	 */
	public function subtitle()
	{
		return (string) $this->subtitle;
	}

	/**
	 * If input is not valid flash errors.
	 *
	 * @return Response
	 */
	public function validate()
	{
		$input = Input::only(array_keys($this->rules));
		$validator = Validator::make($input, $this->rules)->setAttributeNames($this->labels);

		if($validator->passes())
			return Redirect::back()->withInput($input);

		return Redirect::back()->withInput($input)->withErrors($validator);
	}

	/**
	 * Show report results.
	 *
	 * @return Response
	 */
	public function show()
	{
		// If validation failed there is nothing to show
		if(Session::has('errors'))
			return $this->loadView();

		// If it's the first time the report is loaded then flash default input
		if( ! Input::old())
			Session::flashInput($this->defaultInput);

		// Get report results
		$results = $this->get($input = array_only(Input::old(), array_keys($this->rules)));

		if( ! $results)
			return $this->loadView();

		Assets::add('responsive-tables');
		$this->setSubtitle($input);
		$this->data['results'] = $results;
		return $this->loadView(true);
	}

	/**
	 * Set layout and view variables.
	 *
	 * @param  bool
	 * @return Response
	 */
	protected function loadView($resultsFound = false)
	{
		// Set variables for the layout
		$this->layout->title = $this->title;
		$this->layout->offCanvasClass = $this->offCanvasClass;
		$this->layout->action = Route::current()->getName().'.validate';
		$this->layout->results = $resultsFound;

		// Set variables for the view
		$this->data['labels'] = (object) $this->labels;
		$this->data['subtitle'] = $this->subtitle();

		// Load view
		$this->layout->content = View::make($this->view, $this->data);
	}
}
