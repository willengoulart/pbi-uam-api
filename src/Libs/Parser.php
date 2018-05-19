<?php

namespace App\Libs;

use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Parser{

	private function parseExample(){
		$uploadPath = getcwd()."/src/Libs/"; // index.php/src/Libs (caminho ate planilha)
		$filename = "DadosTP_mask.xlsx"; // nome da planilhas
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);

		$worksheetNames = $reader->listWorksheetNames($inputFileName);

	  	foreach ($worksheetNames as $worksheetName) {			
			// carrega apenas a planilha X na memoria ao inves de carregar todas de uma vez
			$reader->setLoadSheetsOnly($worksheetName); 
			$spreadsheet = $reader->load($inputFileName);
			$worksheet = $spreadsheet->getSheetByName($worksheetName);

			$highestRow = $worksheet->getHighestRow();
			//HIGHESTCOL PRECISA DE use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
			//$highestCol = Coordinate::ColumnIndexFromString($worksheet->getHighestColumn());

			for ($row = 3; $row <= $highestRow; $row++) {
				//for ($col = 0; $col < $highestCol; $col++) {
					
					// Busca algum ID de outra tabela
					$this->Provas = TableRegistry::get('Provas');
					$find_prova = ($this->Provas->find()->where(['code'=>$worksheetName]));
					$prova_id = null;
					foreach($find_prova as $item){
						$prova_id = $item->id;
					} 

					// Checa se alguns dos IDs de outra tabela esta vazio
					if (empty($aluno_id) || empty($prova_id)) {
						continue;
					}

					// Algumas planilhas tem dados a mais / a menos
					if ($worksheetName == 'CCOM_17_1_1') {
						$parsedItem = [
							'acertos'=>(int) $worksheet->getCellByColumnAndRow(14, $row)->getValue(), 
							'erros'=>(int) (40-$worksheet->getCellByColumnAndRow(14, $row)->getValue())
						];
					} else {
						$parsedItem = [	
							'acertos'=>(int) $worksheet->getCellByColumnAndRow(13, $row)->getValue(), 
							'erros'=>(int) (40 - $worksheet->getCellByColumnAndRow(13, $row)->getValue())
						];
					}

					$parsedItem = [				    
						'categoria_id'=>200, 	
						'prova_id'=>$prova_id, 
						'aluno_id'=>$aluno_id
					];

					$parsedData[] = $parsedItem;
				//}
			}        
		}
		  
		return $parsedData;
	}

	public function parseResultados(){	
		$uploadPath = getcwd()."/src/Libs/";
		$filename = "DadosTP_mask.xlsx";
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$worksheetNames = $reader->listWorksheetNames($inputFileName);

	  	foreach ($worksheetNames as $worksheetName) {			
			$reader->setLoadSheetsOnly($worksheetName); 
			$spreadsheet = $reader->load($inputFileName);
			$worksheet = $spreadsheet->getSheetByName($worksheetName);
			$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				$ra = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$this->Alunos = TableRegistry::get('Alunos');
				$find_aluno = ($this->Alunos->find()->where(['ra'=>$ra]));
				$aluno_id = null;
				foreach($find_aluno as $item) $aluno_id = $item->id;

				$this->Provas = TableRegistry::get('Provas');
				$find_prova = ($this->Provas->find()->where(['code'=>$worksheetName]));
				$prova_id = null;
				foreach($find_prova as $item) $prova_id = $item->id; 

				if (empty($aluno_id) || empty($prova_id)) continue;
				//if (empty($aluno_id) || empty($prova_id)) { $aluno_id = 200; $prova_id = 200; }

				if ($worksheetName == 'CCOM_17_1_1') {
					$parsedItem = [
						'acertos'=>(int) $worksheet->getCellByColumnAndRow(14, $row)->getValue(), 
						'erros'=>(int) (40-$worksheet->getCellByColumnAndRow(14, $row)->getValue())
					];
				} else {
					$parsedItem = [	
						'acertos'=>(int) $worksheet->getCellByColumnAndRow(13, $row)->getValue(), 
						'erros'=>(int) (40 - $worksheet->getCellByColumnAndRow(13, $row)->getValue())
					];
				}

				$parsedItem += [				    
					'categoria_id'=>200, 	// TODO
					'prova_id'=>$prova_id, 
					'aluno_id'=>$aluno_id
				];

				$parsedData[] = $parsedItem;
			}        
		}		  
		return $parsedData;
	}

	public function parseAlunos() {
		$uploadPath = getcwd()."/src/Libs/";
		$filename = "DadosTP_mask.xlsx";
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$worksheetNames = $reader->listWorksheetNames($inputFileName);

	  	foreach ($worksheetNames as $worksheetName) {			
			$reader->setLoadSheetsOnly($worksheetName); 
			$spreadsheet = $reader->load($inputFileName);
			$worksheet = $spreadsheet->getSheetByName($worksheetName);
			$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				$nome = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$this->Usuarios = TableRegistry::get('Usuarios');
				$find_usuario = ($this->Usuarios->find()->where(['nome'=>$nome]));
				$usuario_id = null;
				foreach($find_usuario as $item) $usuario_id = $item->id; 
				
				//if (empty($usuario_id)) $usuario_id = 200;
				if (empty($usuario_id)) continue;

				$parsedItem = [									
					'usuario_id'=>$usuario_id,
					'ra'=>(int) $worksheet->getCellByColumnAndRow(1, $row)->getValue()
				];

				$parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}

	public function parseCursos() {
		$uploadPath = getcwd()."/src/Libs/";
		$filename = "DadosTP_mask.xlsx";
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$worksheetNames = $reader->listWorksheetNames($inputFileName);

	  	foreach ($worksheetNames as $worksheetName) {			
			$reader->setLoadSheetsOnly($worksheetName); 
			$spreadsheet = $reader->load($inputFileName);
			$worksheet = $spreadsheet->getSheetByName($worksheetName);
			$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				if ($worksheetName == 'CCOM_17_1_1') {	
					$parsedItem = [ 'name'=> $worksheet->getCellByColumnAndRow(4, $row)->getValue() ];
				} else {
					$parsedItem = [ 'name'=> $worksheet->getCellByColumnAndRow(3, $row)->getValue() ];
				}

				$parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}

	public function parseProvas() {
		$uploadPath = getcwd()."/src/Libs/";
		$filename = "DadosTP_mask.xlsx";
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$worksheetNames = $reader->listWorksheetNames($inputFileName);

	  	foreach ($worksheetNames as $worksheetName) {			
			$reader->setLoadSheetsOnly($worksheetName); 
			$spreadsheet = $reader->load($inputFileName);
			$worksheet = $spreadsheet->getSheetByName($worksheetName);
			$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				if ($worksheetName == 'CCOM_17_1_1') {
					$curso = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				} else {
					$curso = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				}
				$this->Cursos = TableRegistry::get('Cursos');
				$find_curso = ($this->Cursos->find()->where(['name'=>$curso]));
				$curso_id = null;
				foreach($find_curso as $item) $curso_id = $item->id; 
				
				//if (empty($curso_id)) $curso_id = 200;
				if (empty($curso_id)) continue;

				$parsedItem = [
					'curso_id'=>$curso_id,
					'code'=>$worksheetName,
					'name'=>$worksheetName
				];


				$parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}

	public function parseTurmas() {
		$uploadPath = getcwd()."/src/Libs/";
		$filename = "DadosTP_mask.xlsx";
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$worksheetNames = $reader->listWorksheetNames($inputFileName);

	  	foreach ($worksheetNames as $worksheetName) {			
			$reader->setLoadSheetsOnly($worksheetName); 
			$spreadsheet = $reader->load($inputFileName);
			$worksheet = $spreadsheet->getSheetByName($worksheetName);
			$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				if ($worksheetName == 'CCOM_17_1_1') {
					$curso = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				} else {
					$curso = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				}
				$this->Cursos = TableRegistry::get('Cursos');
				$find_curso = ($this->Cursos->find()->where(['name'=>$curso]));
				$curso_id = null;
				foreach($find_curso as $item) $curso_id = $item->id;

				//if (empty($curso_id)) $curso_id = 200;
				if (empty($curso_id)) continue;

				if ($worksheetName == 'CCOM_17_1_1') {
					$parsedItem = [
						'code'=>$worksheet->getCellByColumnAndRow(6, $row)->getValue(),
						'name'=>$worksheet->getCellByColumnAndRow(6, $row)->getValue(),
						'periodo'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue()
					];
				} else {
					$parsedItem = [
						'code'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue(),
						'name'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue(),
						'periodo'=>$worksheet->getCellByColumnAndRow(4, $row)->getValue()
					];
				}

				$parsedItem += ['curso_id'=>$curso_id];

				$parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}
}