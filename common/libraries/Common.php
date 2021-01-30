<?php
namespace common\libraries;\

class Common {
    public static function excelExport(array $headings=[], array $data=[],  array $others=[]) {
        $fileName = !empty($others['file']) ? $others['file'] : 'Excel';
        $excelName = !empty($others['excelName']) ? $others['excelName'] : 'Excel';
        $data = !empty($data) ? $data : ['No record found'];
        $file = \Yii::createObject([
			'class' => 'codemix\excelexport\ExcelFile',
			'sheets' => [
		
				$excelName => [   // Name of the excel sheet
					'data' => $data,
		
					// Set to `false` to suppress the title row
					'titles' => $headings,
		
					'formatters' => [
						// Dates and datetimes must be converted to Excel format
						3 => function ($value, $row, $data) {
							return \PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
						},
					],
				],
			]
		]);
		// Download File
		$file->send($fileName);
    }

}