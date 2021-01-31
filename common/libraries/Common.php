<?php
namespace common\libraries;	
use Yii;
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
	
	public static function randomPassword() {
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 6; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass); //turn the array into a string
	}
	public static function param($param=''){
		$queryParam = Yii::$app->request->queryParams;
		if(!empty($queryParam[$param])) {
			return $queryParam[$param];
		}
		return null;
	}

}