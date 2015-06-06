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
