<?php namespace App\Builders;

/*
 * Borrowed from https://github.com/stevenmaguire/zurb-foundation-laravel since it seems no longer maintained.
 *
 * (c) Steven Maguire <stevenmaguire@gmail.com> http://stevenmaguire.com
 *
 * MIT License
 *
 */

use Collective\Html\HtmlBuilder;
use Collective\Html\FormBuilder;
use Illuminate\Support\MessageBag as MessageBag;
use Illuminate\Http\Request;

class Foundation extends FormBuilder
{
	/**
	 * Local stash of errors from session
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $local_errors;

	/**
	 * Create new instance of this FormBuilder intercepter!
	 *
     * @param  \Collective\Html\HtmlBuilder               $html
     * @param  \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param  \Illuminate\Contracts\View\Factory         $view
     * @param  string                                     $token
	 * @param     Illuminate\Http\Request                 $request
	 * @param  Illuminate\Translation\Translator $translator
	 * @param  mixed                             $errors
	 *
	 * @return void
	 */
	public function __construct($html, $url, $view, $token, Request $request = null, $translator, $errors = null)
	{
		$this->local_errors = ($errors != null ? $errors : new MessageBag);
		parent::__construct($html, $url, $view, $token, $request, $translator);
	}

	/**
	 * Create a email input field.
	 *
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function email($name, $value = null, $options = [])
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::email($name, $value, $options);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Create a label.
	 *
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function label($name, $value = null, $options = [], $escape_html = true)
	{
		$this->addErrorClass($name, $options);
		return parent::label($name, $value, $options);
	}

	/**
	 * Create a password input field.
	 *
	 * @param  string  $name
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function password($name, $options = [])
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::password($name, $options);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Create a select box field.
	 *
	 * @param  string  $name
	 * @param  array   $list
	 * @param  string  $selected
	 * @param  array   $options
	 * @param  array   $selectAttributes
	 *
	 * @return string
	 */
	public function select($name, $list = [], $selected = NULL, array $selectAttributes = [], array $options = [], array $optgroupsAttributes = [])
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::select($name, $list, $selected, $selectAttributes, $options, $optgroupsAttributes);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Create a select month field.
	 *
	 * @param  string  $name
	 * @param  string  $selected
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function selectMonth($name, $selected = null, $options = [], $format = '')
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::selectMonth($name, $selected, $options);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Create a select range field.
	 *
	 * @param  string  $name
	 * @param  string  $begin
	 * @param  string  $end
	 * @param  string  $selected
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function selectRange($name, $begin, $end, $selected = null, $options = [])
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::selectRange($name, $begin, $end, $selected, $options);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Create a text input field.
	 *
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function text($name, $value = null, $options = [])
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::text($name, $value, $options);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Create a textarea input.
	 *
	 * @param  string  $name
	 * @param  string  $value
	 * @param  array   $options
	 *
	 * @return string
	 */
	public function textarea($name, $value = null, $options = [])
	{
		$this->addErrorClass($name, $options);
		$tags['input'] = parent::textarea($name, $value, $options);
		$tags['error'] = $this->getErrorTag($name);
		return $this->buildTags($tags);
	}

	/**
	 * Insert 'error' class in $options array, if error found in session
	 *
	 * @param  string  $name
	 * @param  array   $options ref
	 *
	 * @return void
	 */
	private function addErrorClass($name, &$options = [])
	{
		if (isset($options['class'])) {
			$options['class'] .= ($this->hasError($name) ? ' error' : '');
		} elseif ($this->hasError($name)) {
			$options['class'] = 'error';
		}
	}

	/**
	 * Concatenate and format the tags.
	 *
	 * @param  array  $tags
	 *
	 * @return string
	 */
	private function buildTags($tags = [])
	{
		return implode('', $tags);
	}

	/**
	 * Create Foundation 4 "error" label.
	 *
	 * @param  string  $name
	 *
	 * @return string
	 */
	private function getErrorTag($name)
	{
		return ($this->hasError($name) ? '<small class="error">' . implode(' ', $this->getError($name)) . '</small>' : '');
	}

	/**
	 * Get error text from session in parent class
	 *
	 * @param  string $name
	 *
	 * @return string
	 */
	private function getError($name = null)
	{
		return $this->local_errors->get($name);
	}

	/**
	 * Check if session in parent class has error
	 *
	 * @param  string $name
	 *
	 * @return bool
	 */
	private function hasError($name = null)
	{
		return $this->local_errors->has($name);
	}
}
