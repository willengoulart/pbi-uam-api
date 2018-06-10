<?php

namespace App\Libs;

use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Parser {

	private $spreadsheet;

	function __construct() {
		$uploadPath = APP."Libs/";
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
			$i = 0;
			$worksheetName = $worksheet->getTitle();

			foreach ($worksheet->toArray() as $row) {
				if($i < 2){ $i++; continue; }

				if ($worksheetName == 'CCOM_17_1_1') {	
					$parsedItem = [ 'name'=> $row[3] ];
				} else {
					$parsedItem = [ 'name'=> $row[2] ];
				}
				
				$parsedData[$parsedItem['name']] = $parsedItem;
			}        
		}
		
		$this->Cursos = TableRegistry::get('Cursos');
		$find = $this->Cursos->find('list', ['valueField'=>"name"])->
			where(['name IN'=>array_keys($parsedData)])->
			toArray();

		foreach($find as $item)
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);

		return $parsedData;		
	}

	public function parseProvas() {
		$parsedData = [];
		$this->Cursos = TableRegistry::get('Cursos');

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$i = 0;
			$worksheetName = $worksheet->getTitle();

			foreach ($worksheet->toArray() as $row) {
				if($i < 2){ $i++; continue; }

				if ($worksheetName == 'CCOM_17_1_1') {
					$curso = $row[3];
				} else {
					$curso = $row[2];
				}
				$find_curso = ($this->Cursos->find()->where(['name'=>$curso]));
				$curso = $find_curso->first();				
				if (empty($curso)) continue;

				$parsedItem = [
					'curso_id'=>$curso->id,
					'code'=>$worksheetName,
					'name'=>$worksheetName
				];
				
				$parsedData[$parsedItem['code']] = $parsedItem;
			}        
		}
		
		$this->Provas = TableRegistry::get('Provas');
		$find = $this->Provas->find('list', ['valueField'=>"code"])->
			where(['code IN'=>array_keys($parsedData)])->
			toArray();

		foreach($find as $item)
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);

		return $parsedData;		
	}

	public function parseTurmas() {
		$parsedData = [];
		$this->Cursos = TableRegistry::get('Cursos');

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$i = 0;
			$worksheetName = $worksheet->getTitle();

			foreach ($worksheet->toArray() as $row) {
				if($i < 2){ $i++; continue; }

				if ($worksheetName == 'CCOM_17_1_1') {
					$curso = $row[3];
				} else {
					$curso = $row[2];
				}
				$find_curso = ($this->Cursos->find()->where(['name'=>$curso]));
				$curso = $find_curso->first();
				if (empty($curso)) continue;

				if ($worksheetName == 'CCOM_17_1_1') {
					$parsedItem = [
						'code'=>$row[5],
						'name'=>$row[5],
						'periodo'=>$row[4],
					];
				} else {
					$parsedItem = [
						'code'=>$row[4],
						'name'=>$row[4],
						'periodo'=>$row[3],
					];
				}
				$parsedItem += ['curso_id'=>$curso->id];

				$parsedData[
					$parsedItem['code'] . '-' . 
					$parsedItem['curso_id'] . '-' .
					$parsedItem['periodo']
				] = $parsedItem;
			}        
		}
		
		$this->Turmas = TableRegistry::get('Turmas');
		$find = $this->Turmas->find('list', ['valueField'=>"code-curso_id-periodo"])->
			where([
				'code-curso_id-periodo IN'=>array_keys($parsedData)
			]);
		$find->select(['code-curso_id' => $find->func()->
			concat([
				'code' => 'identifier', '-', 
				'curso_id' => 'identifier', '-', 
				'periodo' => 'identifier'
			])]);
		$find = $find->toArray();

		foreach($find as $item)
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);

		return $parsedData;
	}

	public function parseUsuarios() {
		$parsedData = [];

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$i = 0;

			foreach ($worksheet->toArray() as $row) {
				if($i < 2){ $i++; continue; }

				$parsedItem = [			
					'email' => $row[0] . "@anhembimorumbi.edu.br",
					'nome' => $row[1],
					'senha' => hash("sha256", $row[0])
				];

				$parsedData[$parsedItem['email']] = $parsedItem;
			}        
		}
		
		$this->Usuarios = TableRegistry::get('Usuarios');
		$find = $this->Usuarios->find('list', ['valueField'=>"email"])->
			where(['email IN'=>array_keys($parsedData)])->
			toArray();

		foreach($find as $item)
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);
		

		return $parsedData;		
	}

	public function parseAlunos() {
		$parsedData = [];
		$this->Usuarios = TableRegistry::get('Usuarios');

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$i = 0;

			foreach ($worksheet->toArray() as $row) {
				if($i < 2){ $i++; continue; }

				$nome = $row[1];
				$find_usuario = ($this->Usuarios->find()->where(['nome'=>$nome]));
				$usuario = $find_usuario->first();				
				if (empty($usuario)) continue;

				$parsedItem = [									
					'usuario_id'=>$usuario->id,
					'ra'=>(int) $row[0]
				];

				$parsedData[$parsedItem['ra']] = $parsedItem;
			}        
		}
		
		$this->Alunos = TableRegistry::get('Alunos');
		$find = $this->Alunos->find('list', ['valueField'=>"ra"])->
			where(['ra IN'=>array_keys($parsedData)])->
			toArray();

		foreach($find as $item)
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);
		

		return $parsedData;
	}

	public function parseResultados() {	
		$parsedData = [];
		$this->Alunos = TableRegistry::get('Alunos');
		$this->Provas = TableRegistry::get('Provas');
		$this->Categorias = TableRegistry::get('Categorias');

		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$i = 0;
			$worksheetName = $worksheet->getTitle();

			foreach ($worksheet->toArray() as $row) {
				if($i < 2){ $i++; continue; }

				$find_aluno = $this->Alunos->find()->where(['ra'=>$row[0]]);
				$aluno = $find_aluno->first();				
				if (empty($aluno)) continue;

				$find_prova = $this->Provas->find()->where(['code'=>$worksheetName]);
				$prova = $find_prova->first();				
				if (empty($prova)) continue;

				$find_categoria = $this->Categorias->find()->where(['name'=>"Conhecimentos Especificos"]);
				$categoria = $find_categoria->first();				
				if (empty($categoria)) continue;

				if ($worksheetName == 'CCOM_17_1_1') {
					$tmp = 7;
				} else {
					$tmp = 6;
				}
				
				$numeroQuestoes = round(100
				* $row[$tmp]
				/ $row[$tmp+2]);
				
				$parsedItem = [	
					'acertos'=>(int) $row[$tmp], 
					'erros'=>(int) ($numeroQuestoes - $row[$tmp]),
					'categoria_id'=>$categoria->id,		
					'aluno_id'=>$aluno->id,
					'prova_id'=>$prova->id,  
				];
				
				$parsedData[
					$parsedItem['aluno_id'] . '-' . 
					$parsedItem['prova_id'] . '-' . 
					$parsedItem['categoria_id']
				] = $parsedItem;

				/**********************************************************************/

				$find_categoria = $this->Categorias->find()->where(['name'=>"Conhecimentos Gerais"]);
				$categoria = $find_categoria->first();				
				if (empty($categoria)) continue;

				if ($worksheetName == 'CCOM_17_1_1') {
					$tmp = 10;
				} else {
					$tmp = 9;
				}
				
				$numeroQuestoes = round(100
				* $row[$tmp]
				/ $row[$tmp+2]);
				
				$parsedItem = [	
					'acertos'=>(int) $row[$tmp], 
					'erros'=>(int) ($numeroQuestoes - $row[$tmp]),
					'categoria_id'=>$categoria->id,		
					'aluno_id'=>$aluno->id,
					'prova_id'=>$prova->id,  
				];
				
				$parsedData[
					$parsedItem['aluno_id'] . '-' . 
					$parsedItem['prova_id'] . '-' . 
					$parsedItem['categoria_id']
				] = $parsedItem;
			}        
		}		
		
		$this->Resultados = TableRegistry::get('Resultados');
		$find = $this->Resultados->find('list', ['valueField'=>"aluno_id-prova_id-categoria_id"])->
			where([
				'aluno_id-prova_id-categoria_id IN'=>array_keys($parsedData)
			]);
		$find->select(['aluno_id-prova_id-categoria_id' => $find->func()->
			concat([
				'aluno_id'=>'identifier', '-', 
				'prova_id'=>'identifier', '-', 
				'categoria_id'=>'identifier'
			])]);
		// pr($find);
		$find = $find->toArray();
		// pr($find);

		foreach($find as $item)
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);

		// pr($parsedData);

		return $parsedData;
	}
}