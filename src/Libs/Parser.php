<?php

namespace App\Libs;


class Parser{


	public function parse(){

	  $upload_path = "./";
	  $filename = "DadosTP_mask.xlsx";

	  $inputFileName = $upload_path . $filename;
	  $objReader = \App\Libs\PHPExcel\PHPExcel_IOFactory::createReader(
	  	PHPExcel_IOFactory::identify($inputFileName));
	  $objReader->setReadDataOnly(true);
	  $objPHPExcel = $objReader->load($inputFileName);
	  $sheetNames = $objPHPExcel->getSheetNames();

	  foreach($sheetNames as $sheetName) {
	    $objWorksheet = $objPHPExcel->setActiveSheetIndexByName($sheetName);
	    $highestRow = $objWorksheet->getHighestRow();
	    $highestColumn = $objWorksheet->getHighestColumn();
	    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

	    echo "<h1>WORKSHEET: $sheetName</h1>
	      <table id='$sheetName' class='greyGridTable'>";
	      
	    for ($row = 2; $row <= $highestRow; $row++) {
	      if ($row == 2) {
	        echo "<thead>";
	      }
	      echo "<tr>";
	      
	      for ($col = 0; $col < $highestColumnIndex; $col++) {
	        $rows[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
	      }

	      for ($col = 0; $col < $highestColumnIndex; $col++) {
	        if (! ($sheetName == 'CCOM_17_1_1' && $col == 2)) {
	          if ($row == 2) {
	            echo "<th onclick='sortTable(\"$sheetName\", $col)'>$rows[$col]</th>";
	          } else {
	            echo "<td>$rows[$col]</td>";
	          }
	        }
	      }
	      echo "</tr>";
	      if ($row == 2) {
	        echo "</thead>";
	      }
	    }
	    echo "</table>";
	  }
	}
}