<?php namespace App\Formatters;

/**

Sample of expected formats:

$lables = array('col1' => 'Foo', 'col2' => 'Bar');

$data = array
(
    [Sheet 1] => array
    (
        [0] => array // Row 1
        (
            [col1] => 1, // Column 1
            [col2] => 2, // Column 2
        ),
        [1] => array // Row 2
        (
            [col1] => 3, // Column 1
            [col2] => 4, // Column 2
        )
    ),

    [Sheet 2] => array
    (
        [0] => array // Row 1
        (
            [col1] => 5, // Column 1
            [col2] => 6, // Column 2
        ),
        [1] => array // Row 2
        (
            [col1] => 7, // Column 1
            [col2] => 8, // Column 2
        )
    )
);
*/

class ExcelFormatter extends Formatter implements FormatterInterface
{
	/**
	 * Name of the file.
	 * @var string
	 */
	protected $filename;

	/**
	 * Filename setter.
	 *
	 * @param mixed
	 * @return self
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;

		return $this;
	}

	/**
	 * Create excel file
	 *
	 * @return Response (download response)
	 */
	public function format()
	{
		// Get data and lables
		$data = $this->getData();
		$labels = $this->getLabels();

		// Create file
		$file = app('excel')->create($this->filename);

		// Add sheets to file
		foreach($data as $sheetName => $sheetData)
		{
			// Create sheet
			$file->sheet($sheetName, function ($sheet) use ($sheetData, $labels) {

				// Add data to sheet
				$sheet->fromArray($sheetData, null, 'A1', false, false);

				// If there are headers add them
				if($labels)
				{
					// Add headers
					$sheet->prependRow($labels);

					// Apply format to headers
					$sheet->cells('A1:Z1', function ($cells) {
						$cells->setFontWeight('bold')->setAlignment('center');
					});
				}
			});
		}

		// Set first sheet as active
		$file->setActiveSheetIndex(0);

		// Download file
		$file->download('xls');
	}
}
