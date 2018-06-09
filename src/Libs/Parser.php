<?php

namespace App\Libs;

use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Parser {

	private $spreadsheet;

	function __construct() {
		$uploadPath = getcwd()."/src/Libs/"; 
		$filename = "DadosTP_mask.xlsx"; 
		$inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($inputFileName);
	  	$reader = IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);	
		$worksheetNames = $reader->listWorksheetNames($inputFileName);
		$this->spreadsheet = $reader->load($inputFileName);
	}

	public function parseCursos() {		
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$worksheetName = $worksheet->getTitle();
		  	$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				if ($worksheetName == 'CCOM_17_1_1') {	
					$parsedItem = [ 'name'=> $worksheet->getCellByColumnAndRow(4, $row)->getValue() ];
				} else {
					$parsedItem = [ 'name'=> $worksheet->getCellByColumnAndRow(3, $row)->getValue() ];
				}
				
				foreach ($parsedData as $item) if ($parsedItem['name'] == $item['name']) continue 2;

				$this->Cursos = TableRegistry::get('Cursos');
				$find = $this->Cursos->find()->where(['name'=>$parsedItem['name']]);
				if ($find->isEmpty()) $parsedData[] = $parsedItem;
			}        
		}		
		return $parsedData;
	}

	public function parseProvas() {
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$worksheetName = $worksheet->getTitle();
		  	$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				if ($worksheetName == 'CCOM_17_1_1') {
					$curso = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				} else {
					$curso = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				}
				$this->Cursos = TableRegistry::get('Cursos');
				$find_curso = ($this->Cursos->find()->where(['name'=>$curso]));
				$curso = $find_curso->first();				
				if (empty($curso)) continue;

				$parsedItem = [
					'curso_id'=>$curso->id,
					'code'=>$worksheetName,
					'name'=>$worksheetName
				];
				
				foreach ($parsedData as $item) if ($parsedItem['code'] == $item['code']) continue 2;

				$this->Provas = TableRegistry::get('Provas');
				$find = $this->Provas->find()->where(['code'=>$parsedItem['code']]);
				if ($find->isEmpty()) $parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}

	public function parseTurmas() {
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$worksheetName = $worksheet->getTitle();
		  	$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				if ($worksheetName == 'CCOM_17_1_1') {
					$curso = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				} else {
					$curso = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				}
				$this->Cursos = TableRegistry::get('Cursos');
				$find_curso = ($this->Cursos->find()->where(['name'=>$curso]));
				$curso = $find_curso->first();
				if (empty($curso)) continue;

				if ($worksheetName == 'CCOM_17_1_1') {
					$parsedItem = [
						'code'=>$worksheet->getCellByColumnAndRow(6, $row)->getValue(),
						'name'=>$worksheet->getCellByColumnAndRow(6, $row)->getValue(),
						'periodo'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue(),
					];
				} else {
					$parsedItem = [
						'code'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue(),
						'name'=>$worksheet->getCellByColumnAndRow(5, $row)->getValue(),
						'periodo'=>$worksheet->getCellByColumnAndRow(4, $row)->getValue(),
					];
				}
				$parsedItem += ['curso_id'=>$curso->id];
				
				foreach ($parsedData as $item) {
					if ($parsedItem['code'] == $item['code']
					&& $parsedItem['periodo'] == $item['periodo']) {
						continue 2;
					}
				}

				$this->Turmas = TableRegistry::get('Turmas');
				$find = $this->Turmas->find()->where([
					'code'=>$parsedItem['code'],
					'periodo'=>$parsedItem['periodo']
				]);
				if ($find->isEmpty()) $parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}

	public function parseUsuarios() {
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
		  	$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				$ra = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

				$parsedItem = [			
					'email' => $ra . "@anhembimorumbi.edu.br",
					'nome' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
					'senha' => hash("sha256", $ra)
				];

				foreach ($parsedData as $item) {
					if ($parsedItem['email'] == $item['email']
					&& $parsedItem['nome'] == $item['nome']) {
						continue 2;
					}
				}

				$this->Usuarios = TableRegistry::get('Usuarios');
				$find = $this->Usuarios->find()->where([
					'nome'=>$parsedItem['nome'],
					'email'=>$parsedItem['email']
				]);
				if ($find->isEmpty()) $parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;		
	}

	public function parseAlunos() {
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
		  	$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				$nome = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$this->Usuarios = TableRegistry::get('Usuarios');
				$find_usuario = ($this->Usuarios->find()->where(['nome'=>$nome]));
				$usuario = $find_usuario->first();				
				if (empty($usuario)) continue;

				$parsedItem = [									
					'usuario_id'=>$usuario->id,
					'ra'=>(int) $worksheet->getCellByColumnAndRow(1, $row)->getValue()
				];

				foreach ($parsedData as $item) if ($parsedItem['ra'] == $item['ra']) continue 2;

				$this->Alunos = TableRegistry::get('Alunos');
				$find = $this->Alunos->find()->where(['ra'=>$parsedItem['ra']]);
				if ($find->isEmpty()) $parsedData[] = $parsedItem;
			}        
		}
		return $parsedData;
	}

	public function parseResultados(string $nomeCategoria, int $colunaCategoria) {	
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$worksheetName = $worksheet->getTitle();
		  	$highestRow = $worksheet->getHighestRow();

			for ($row = 3; $row <= $highestRow; $row++) {
				$ra = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$this->Alunos = TableRegistry::get('Alunos');
				$find_aluno = $this->Alunos->find()->where(['ra'=>$ra]);
				$aluno = $find_aluno->first();				
				if (empty($aluno)) continue;

				$this->Provas = TableRegistry::get('Provas');
				$find_prova = $this->Provas->find()->where(['code'=>$worksheetName]);
				$prova = $find_prova->first();				
				if (empty($prova)) continue;

				$this->Categorias = TableRegistry::get('Categorias');
				$find_categoria = $this->Categorias->find()->where(['name'=>$nomeCategoria]);
				$categoria = $find_categoria->first();				
				if (empty($categoria)) continue;

				if ($worksheetName == 'CCOM_17_1_1') {
					if ($worksheet->getCellByColumnAndRow(($colunaCategoria+3), $row)->getValue() == 0){
						$numeroQuestoes = round(100
						* $worksheet->getCellByColumnAndRow(($colunaCategoria+1), ($row+1))->getValue()
						/ $worksheet->getCellByColumnAndRow(($colunaCategoria+3), ($row+1))->getValue());
					} else {
						$numeroQuestoes = round(100
						* $worksheet->getCellByColumnAndRow(($colunaCategoria+1), $row)->getValue()
						/ $worksheet->getCellByColumnAndRow(($colunaCategoria+3), $row)->getValue());
					}
					$parsedItem = [
						'acertos'=>(int) $worksheet->getCellByColumnAndRow(($colunaCategoria+1), $row)->getValue(), 
						'erros'=>(int) ($numeroQuestoes - $worksheet->getCellByColumnAndRow(($colunaCategoria+1), $row)->getValue()),				    
					];
				} else {
					if ($worksheet->getCellByColumnAndRow(($colunaCategoria+2), $row)->getValue() == 0){
						$numeroQuestoes = round(100
						* $worksheet->getCellByColumnAndRow(($colunaCategoria), ($row+1))->getValue()
						/ $worksheet->getCellByColumnAndRow(($colunaCategoria+2), ($row+1))->getValue());
					} else {
						$numeroQuestoes = round(100
						* $worksheet->getCellByColumnAndRow(($colunaCategoria), $row)->getValue()
						/ $worksheet->getCellByColumnAndRow(($colunaCategoria+2), $row)->getValue());
					}
					$parsedItem = [	
						'acertos'=>(int) $worksheet->getCellByColumnAndRow($colunaCategoria, $row)->getValue(), 
						'erros'=>(int) ($numeroQuestoes - $worksheet->getCellByColumnAndRow($colunaCategoria, $row)->getValue()),				    
					];
				}

				$parsedItem += [			
					'aluno_id'=>$aluno->id,
					'prova_id'=>$prova->id, 
					'categoria_id'=>$categoria->id
				];

				foreach ($parsedData as $item) {
					if ($parsedItem['aluno_id'] == $item['aluno_id']
					&& $parsedItem['prova_id'] == $item['prova_id']
					&& $parsedItem['categoria_id'] == $item['categoria_id']) {
						continue 2;
					}
				}

				$this->Resultados = TableRegistry::get('Resultados');
				$find = $this->Resultados->find()->where([
					'aluno_id'=>$parsedItem['aluno_id'],
					'prova_id'=>$parsedItem['prova_id'],
					'categoria_id'=>$parsedItem['categoria_id']
				]);
				if ($find->isEmpty()) $parsedData[] = $parsedItem;
			}        
		}		  
		return $parsedData;
	}
}