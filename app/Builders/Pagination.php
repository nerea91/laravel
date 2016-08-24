<?php namespace App\Builders;

//use Illuminate\Pagination\Paginator;

class Pagination
{
	/**
	 * Whether or not pagination will be render centered.
	 *
	 * @var boolean
	 */
	protected $centered = true;

    /**
	 * Paginator
	 *
	 * @var Illuminate\Pagination\LengthAwarePaginator
	 */
	protected $paginator;

    public function __construct(\Illuminate\Pagination\LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

	/**
	 * Shortcut alias for $this->render()
	 *
	 * @return string
	 */
	public function __tostring()
	{
		return (string) $this->render();
	}

	/**
	 * Set centered attribute
	 *
	 * @param  bool
	 * @return $this
	 */
	public function centered($centered)
	{
		$this->centered = (bool) $centered;

		return $this;
	}

	/**
	 * Convert the URL window into Zurb Foundation HTML.
	 *
	 * @return string
	 */
	public function render($view = NULL)
	{
		if( ! $this->paginator->hasPages())
			return '';

		$html = sprintf(
			' %s ',
			//$this->getPreviousButton(),
			$this->paginator->links()
			//$this->getNextButton()
		);

		return ($this->centered) ? '<div class="pagination-centered">' . $html . '</div>' : $html;
	}

	/**
	 * Get HTML wrapper for disabled text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	protected function getDisabledTextWrapper($text)
	{
		return '<li class="unavailable" aria-disabled="true"><a href="javascript:void(0)">'.$text.'</a></li>';
	}

	/**
	 * Get HTML wrapper for active text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	protected function getActivePageWrapper($text)
	{
		return '<li class="current"><a href="javascript:void(0)">'.$text.'</a></li>';
	}

	/**
	 * Get a pagination "dot" element.
	 *
	 * @return string
	 */
	protected function getDots()
	{
		return $this->getDisabledTextWrapper('&hellip;');
	}

    /**
	 * Get the previous page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	protected function getPreviousButton($text = '&laquo;')
	{
		// If the current page is less than or equal to one, it means we can't go any
		// further back in the pages, so we will render a disabled previous button
		// when that is the case. Otherwise, we will give it an active "status".
		if ($this->paginator->currentPage() <= 1)
		{
			return $this->getDisabledTextWrapper($text);
		}
		$url = $this->paginator->url(
			$this->paginator->currentPage() - 1
		);
		return $this->getPageLinkWrapper($url, $text, 'prev');
	}
	/**
	 * Get the next page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	protected function getNextButton($text = '&raquo;')
	{
		// If the current page is greater than or equal to the last page, it means we
		// can't go any further into the pages, as we're already on this last page
		// that is available, so we will make it the "next" link style disabled.
		if ( ! $this->paginator->hasMorePages())
		{
			return $this->getDisabledTextWrapper($text);
		}
		$url = $this->paginator->url($this->paginator->currentPage() + 1);
		return $this->getPageLinkWrapper($url, $text, 'next');
	}

    /**
     * Get HTML wrapper for a page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getPageLinkWrapper($url, $page, $rel = null)
    {
        if ($page == $this->paginator->currentPage())
        {
            return $this->getActivePageWrapper($page);
        }
        return $this->getAvailablePageWrapper($url, $page, $rel);
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';
        return '<li><a href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a></li>';
    }
}
