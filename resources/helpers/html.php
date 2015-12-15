<?php

/** Helper functions for generating HTML */

if( ! function_exists('markdown'))
{
	/**
	 * Convert from Markdown to HTML.
	 *
	 * @param  string
	 *
	 * @return string
	 */
	function markdown($source)
	{
		return with(new \League\CommonMark\CommonMarkConverter())->convertToHtml($source);
	}
}

if( ! function_exists('pagination_links'))
{
	/**
	 * Custom paginator presenter using Zurb Foundation style
	 *
	 * @param  \Illuminate\Contracts\Pagination\Paginator
	 *
	 * @return string
	 */
	function pagination_links(\Illuminate\Contracts\Pagination\Paginator $paginator)
	{
		return with(new \Stolz\LaravelFormBuilder\Pagination($paginator))->render();
	}
}

if( ! function_exists('link_to_sort_by'))
{
	/**
	 * Build up links for sorting resource by column (?sortby=column)
	 *
	 * @param  array
	 *
	 * @return array
	 */
	function link_to_sort_by($labels)
	{
		$route = Route::current()->getName();
		$column = Input::get('sortby');
		$direction = Input::get('sortdir');
		$links = [];

		foreach($labels as $key => $label)
		{
			$sortby = ['sortby' => $key];
			if($key === $column and $direction !== 'desc')
				$sortby['sortdir'] = 'desc';

			$links[$key] = link_to_route($route, $label, $sortby);
		}

		return $links;
	}
}

if( ! function_exists('checkboxes'))
{
	/**
	 * Create a group of checkboxes.
	 *
	 * @param  string  $name
	 * @param  array   $values
	 * @param  array   $checked
	 * @param  array   $options
	 * @return string
	 */
	function checkboxes($name, $values, $checked = array(), $options = array())
	{
		return checkables('checkbox', $name, $values, $checked, $options);
	}
}

if( ! function_exists('radios'))
{
	/**
	 * Create a group of radio buttons.
	 *
	 * @param  string  $name
	 * @param  array   $values
	 * @param  array   $checked
	 * @param  array   $options
	 * @return string
	 */
	function radios($name, $values, $checked = array(), $options = array())
	{
		return checkables('radio', $name, $values, $checked, $options);
	}
}

if( ! function_exists('checkables'))
{
	/**
	 * Create a group of checkable input fields.
	 *
	 * $options[
	 *   'legend' => 'txt', // to get a fieldset with legend
	 *   'small'  => 1,     // Number of grid columns for small screens
	 *   'medium' => 2,     // Number of grid columns for medium screens
	 *   'large'  => 3,     // Number of grid columns for large screens
	 * ]
	 *
	 * @param  string  $type
	 * @param  string  $name
	 * @param  array   $values
	 * @param  array   $checked
	 * @param  array   $options
	 * @return string
	 */
	function checkables($type, $name, $values, $checked, $options)
	{
		// Unset options that should not to be passed to $this->*
		$legend = (isset($options['legend'])) ? $options['legend'] : false;
		$small = (isset($options['small'])) ? $options['small'] : 2;
		$medium = (isset($options['medium'])) ? $options['medium'] : 3;
		$large = (isset($options['large'])) ? $options['large'] : 4;
		unset($options['legend'], $options['small'], $options['medium'], $options['large']);

		$out = ($legend) ? '<fieldset class="checkables"><legend>' . $legend . '</legend>' : null;
		if($legend and $type === 'checkbox')
			$out .= '
			<div class="checkbox_togglers">
				<a href="all">'._('all').'</a> &#8226;
				<a href="none">'._('none').'</a> &#8226;
				<a href="invert">'._('invert').'</a>
			</div>';

		$out .= "<div class=\"checkables small-up-$small medium-up-$medium large-up-$large\">";

		foreach($values as $value => $label)
		{
			$options['id'] = $id = $name . $value;
			$check = in_array($value, $checked);

			$out .= ' <div class="column"><label for="' . $id . '" style="display:inline">';
			$out .= ($type === 'radio') ? Form::radio($name, $value, $check, $options) : Form::checkbox($name.'[]', $value, $check, $options);
			$out .= '&nbsp;'.$label;
			$out .= '</label></div>';
		}

		$out .= '</div>';

		if($legend)
			$out .= '</fieldset>';

		return $out;
	}
}
