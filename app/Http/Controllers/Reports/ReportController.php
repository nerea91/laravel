<?php namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Assets;
use Input;
use Route;
use Session;
use Validator;
use View;

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
	 * @param  string $title          Title of the report
	 * @param  string $view           View file for showing the results
	 * @param  array  $fields         Form fields labels and validation rules
	 * @param  array  $input          Default form input
	 * @param  string $offCanvasClass Class to apply to the off-canvas
	 *
	 * @return void
	 */
	public function __construct($title, $view, array $fields, array $input, $offCanvasClass = null)
	{
		// Setup layout
		parent::__construct();

		$this->title = $title;
		$this->view = $view;
		list($this->labels, $this->rules) = \App\Validation\Validator::parseRules($fields);
		$this->defaultInput = $input;
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
			return redirect()->back()->withInput($input);

		return redirect()->back()->withInput($input)->withErrors($validator);
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
			return $this->format([], false);

		// If the old input does not match this report input, flash default input
		if(array_diff_key($this->defaultInput, Input::old()))
			Session::flashInput($this->defaultInput);

		// Get report results
		$results = $this->get($input = array_only(Input::old(), array_keys($this->rules)));

		// Return formated results
		return $this->format($input, $results);
	}

	/**
	 * Format report results.
	 *
	 * If the is no formatter for provided format fallbacks to web.
	 *
	 * @param  array $input
	 * @param  mixed $results
	 *
	 * @return Response
	 */
	public function format(array $input, $results)
	{
		// Fallback to web format if there are no results or no format was provided
		if( ! $results or ! isset($input['format']))
			$input['format'] = 'web';

		// Fallback to web format if formatter method does not exist
		$method = 'format' . ucfirst(strtolower($input['format']));
		if( ! method_exists($this, $method))
			$method = 'formatWeb';

		// Delegate to corresponding method
		return $this->$method($input, $results);
	}

	/**
	 * Format report results for Web.
	 *
	 * @param  array $input
	 * @param  mixed $results
	 *
	 * @return Response
	 */
	public function formatWeb(array $input, $results)
	{
		// Set variables for the layout
		$this->layout->title = $this->title;
		$this->layout->offCanvasClass = $this->offCanvasClass;
		$this->layout->action = Route::current()->getName() . '.validate';
		$this->layout->results = (bool) $results;

		// Set variables for the view
		if($results)
		{

			$this->setSubtitle($input);
			$this->data['results'] = $results;
		}
		$this->data['labels'] = (object) $this->labels;
		$this->data['subtitle'] = $this->subtitle();

		// Return layout + view
		return $this->layout(view($this->view, $this->data));
	}

	/**
	 *  Format report results for PDF
	 *
	 * @param  array
	 * @param  mixed
	 * @param  array
	 * @return Response
	 */
	public function formatPdf(array $input, $results)
	{
		$this->setSubtitle($input);

		$pdf = \App::make('snappy.pdf.wrapper');

		$aux =  ['results' => $results, 'subtitle' => $this->subtitle,  'title' => $this->title ];

		// extra data for the view
		$data = (isset($this->extra)) ? array_merge($this->extra, $aux) : $aux;

		$view = view('reports.pdfs.'.substr($this->view,strrpos($this->view, '.')+1), $data);

		// render the view to get html
		$contents = $view->render();

		// set orientation
		if(isset($this->orientation))
			$pdf->setOrientation($this->orientation);

		//set paper
		if(isset($this->paper))
			$pdf->setPaper($this->paper);

		$pdf->setOption('user-style-sheet', 'css/admin.css')->loadHTML($contents);

		$title = $this->makeExportTitle($input, $this->title);

		$title.='.pdf';

		return $pdf->download($title);
	}

	/**
	 *  Make title to export data (xls,pdf...)
	 *
	 * @param  array
	 * @param  string
	 * @return string
	 */
	public function makeExportTitle(array $input, $title)
	{
		$title =  str_replace(' ', '_' ,$title);

		// make title of file
		if(isset($input['time1']) and !empty($input['time1']))
		{
			if(strlen($input['time1']) > 5)
				$input['time1'] = substr($input['time1'], 0, 5);

			$input['time1'] = str_replace(':', 'h', $input['time1']);

			if(strlen($input['time2']) > 5)
				$input['time2'] = substr($input['time1'], 0, 5);

			$input['time2'] = str_replace(':', 'h', $input['time2']);

			$title.=sprintf(_('_since_%s_from_%s_to_%s_of_%s'), $input['time1'], $input['date1'], $input['time2'], $input['date2']);
		}
		else {
				$title.=sprintf(_('_since_%s_to_%s'),  $input['date1'], $input['date2']);
		}

		return $title;
	}
}
