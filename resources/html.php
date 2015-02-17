<?php

/** Helper functions for generating HTML */

if( ! function_exists('markdown'))
{
	/**
	 * Convert from Markdown to HTML.
	 *
	 * @param  string
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
	 * @return string
	 */
	function pagination_links(\Illuminate\Contracts\Pagination\Paginator $paginator)
	{
		return with(new \Stolz\LaravelFormBuilder\Pagination($paginator))->render();
	}
}
