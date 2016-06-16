<?php namespace App\Formatters;

abstract class Formatter
{
	/**
	 * Data to be formatted.
	 * @var mixed
	 */
	protected $data;

	/**
	 * Labels/headers to describe the data.
	 * @var mixed
	 */
	protected $labels;

	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct($data = null, $labels = null)
	{
		if($data)
			$this->setData($data);

		if($labels)
			$this->setLabels($labels);
	}

	/**
	 * Data getter.
	 *
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Data setter.
	 *
	 * @param mixed
	 * @return Formatter
	 */
	public function setData($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Labels getter.
	 *
	 * @return array
	 */
	public function getLabels()
	{
		return $this->labels;
	}

	/**
	 * Labels setter.
	 *
	 * @param mixed
	 * @return Formatter
	 */
	public function setLabels($labels)
	{
		$this->labels = $labels;

		return $this;
	}
}
