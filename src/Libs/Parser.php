<?php

namespace App\Libs;

use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Parser {

	private $spreadsheet;
	private $reader;
	private $inputFileName;
	private $worksheets;

	function __construct() {
		$uploadPath = APP."Libs/";
		$filename = "DadosTP_mask.xlsx"; 
		$this->inputFileName = $uploadPath . $filename;		
	  	$inputFileType = IOFactory::identify($this->inputFileName);
	  	$this->reader = IOFactory::createReader($inputFileType);
		$this->reader->setReadDataOnly(true);	
		$worksheetNames = $this->reader->listWorksheetNames($this->inputFileName);
		$this->spreadsheet = $this->reader->load($this->inputFileName);
		foreach ($this->spreadsheet->getAllSheets() as $worksheet) {
			$this->worksheets[$worksheet->getTitle()] = $worksheet->toArray();
		}
		$this->spreadsheet->disconnectWorksheets();
		unset($this->spreadsheet);
	}

	public function parseCursos() {		
		$parsedData = [];

		foreach ($this->worksheets as $worksheetName=>$worksheet) {
			$i = 0;

			foreach ($worksheet as $row) {
				if($i < 2){ $i++; continue; }

				if ($worksheetName == 'CCOM_17_1_1') {	
					$parsedItem = [ 'name'=> $row[3] ];
				} else {
					$parsedItem = [ 'name'=> $row[2] ];
				}
				
				if (isset($parsedData[$parsedItem['name']])) continue;
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
		$this->Turmas = TableRegistry::get('Turmas');

		$turmas = $this->Turmas->find()->indexBy('code')->toArray();

		foreach ($this->worksheets as $worksheetName=>$worksheet) {
			$i = 0;

			foreach ($worksheet as $row) {
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
					'name'=>$worksheetName,
				];

				
				if ($worksheetName == 'CCOM_17_1_1') {
					if (isset($parsedData[$parsedItem['code']]))
						$parsedData[$parsedItem['code']]['turmas'][$turmas[$row[5]]->id] = $turmas[$row[5]]->id;
					else
						$parsedItem['turmas'][$turmas[$row[5]]->id] = $turmas[$row[5]]->id;
				} else {
					if (isset($parsedData[$parsedItem['code']]))
						$parsedData[$parsedItem['code']]['turmas'][$turmas[$row[4]]->id] = $turmas[$row[4]]->id;
					else
						$parsedItem['turmas'][$turmas[$row[4]]->id] = $turmas[$row[4]]->id;
				}
				
				if (!isset($parsedData[$parsedItem['code']]))
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

		foreach ($this->worksheets as $worksheetName=>$worksheet) {
			$i = 0;

			foreach ($worksheet as $row) {
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

				if (isset($parsedData[
					$parsedItem['code'] . '-' . 
					$parsedItem['curso_id'] . '-' .
					$parsedItem['periodo']
				])) continue;
				
				$parsedData[
					$parsedItem['code'] . '-' . 
					$parsedItem['curso_id'] . '-' .
					$parsedItem['periodo']
				] = $parsedItem;
			}        
		}
		
		$this->Turmas = TableRegistry::get('Turmas');
		$find = $this->Turmas->find('list', ['valueField'=>"code-curso_id-periodo"]);
		$find->select(['code-curso_id-periodo' => $find->func()->
			concat([
				'code' => 'identifier', '-', 
				'curso_id' => 'identifier', '-', 
				'periodo' => 'identifier'
			])])
			->where([
				'code-curso_id-periodo IN'=>array_keys($parsedData)
			]);
		// pr($find);
		$find = $find->toArray();
		// pr($find);

		foreach($find as $item) {
			if(isset($parsedData[$item]))
				unset($parsedData[$item]);
		}
		return $parsedData;
	}

	public function parseUsuarios() {
		$parsedData = [];
		$this->Usuarios = TableRegistry::get('Usuarios');

		foreach ($this->worksheets as $worksheetName=>$worksheet) {
			$i = 0;

			foreach ($worksheet as $row) {
				if($i < 2){ $i++; continue; }
				$ra = $row[0]; 				
				$parsedItem = [			
					'email' => $row[0] . "@anhembimorumbi.edu.br",
					'nome' => $row[1],
					'senha' => hash("sha256", $row[0])
				];

				if (isset($parsedData[$parsedItem['email']])) continue;
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
		$this->Turmas = TableRegistry::get('Turmas');

		$turmas = $this->Turmas->find()->indexBy('code')->toArray();
		$cursos = $this->Cursos->find()->indexBy('name')->toArray();

		foreach ($this->worksheets as $worksheetName=>$worksheet) {
			$i = 0;

			foreach ($worksheet as $row) {
				if($i < 2){ $i++; continue; }

				$nome = $row[1];
				$find_usuario = ($this->Usuarios->find()->where(['nome'=>$nome]));
				$usuario = $find_usuario->first();				
				if (empty($usuario)) continue;

				$parsedItem = [									
					'usuario_id'=>$usuario->id,
					'ra'=>(int) $row[0],
				];
				if ($worksheetName == 'CCOM_17_1_1'){
					$parsedItem['turmas'][] = $turmas[$row[5]]->id;
					$parsedItem['cursos'][] = $cursos[$row[3]]->id;
				}
				else{
					$parsedItem['turmas'][] = $turmas[$row[4]]->id;
					$parsedItem['cursos'][] = $cursos[$row[2]]->id;
				}
				$parsedData[$parsedItem['ra']] = $parsedItem;
			}        
		}
		
		if(!empty($parsedData)){
			$this->Alunos = TableRegistry::get('Alunos');
			$find = $this->Alunos->find('list', ['valueField'=>"ra"])->
				where(['ra IN'=>array_keys($parsedData)])->
				toArray();

			foreach($find as $id=>$item)
				if(isset($parsedData[$item]))
					$parsedData[$item]['id'] = $id;
		}
		
		return $parsedData;
	}

	public function parseResultados() {	
		$parsedData = [];
		$this->Alunos = TableRegistry::get('Alunos');
		$this->Provas = TableRegistry::get('Provas');
		$this->Categorias = TableRegistry::get('Categorias');
			
		$find_categoria = $this->Categorias->find()->where(['name'=>"Conhecimentos Especificos"]);
		$catEspec = $find_categoria->first()->id;

		$find_categoria = $this->Categorias->find()->where(['name'=>"Conhecimentos Gerais"]);
		$catGeral = $find_categoria->first()->id;

		foreach ($this->worksheets as $worksheetName=>$worksheet) {
			$i = 0;

			$find_prova = $this->Provas->find()->where(['code'=>$worksheetName]);
			$prova = $find_prova->first();				
			if (empty($prova)) continue;
			$prova = $prova->id;	

			foreach ($worksheet as $row) {
				if ($i < 2) { $i++; continue; }

				$find_aluno = $this->Alunos->find()->where(['ra'=>$row[0]]);
				$aluno = $find_aluno->first();				
				if (empty($aluno)) continue;

				$col = ($worksheetName == 'CCOM_17_1_1') ? 7 : 6;

				if ($row[$col] == 0) {
					foreach($parsedData as $item) {
						if ($item['acertos'] > 0 && $item['categoria_id'] == $catEspec) {
							$numeroQuestoes = $item['acertos'] + $item['erros'];
						}
					}
				} else {
					$numeroQuestoes = round(100
					* $row[$col]
					/ $row[$col+2]);
				}
				
				$parsedItem = [	
					'acertos' => (int) $row[$col], 
					'erros' => (int) ($numeroQuestoes - $row[$col]),
					'categoria_id' => $catEspec,		
					'prova_id' => $prova,  
					'aluno_id' => $aluno->id,
				];

				if (isset($parsedData[
					$parsedItem['aluno_id'] . '-' . 
					$parsedItem['prova_id'] . '-' . 
					$parsedItem['categoria_id']
				])) continue;
				
				$parsedData[
					$parsedItem['aluno_id'] . '-' . 
					$parsedItem['prova_id'] . '-' . 
					$parsedItem['categoria_id']
				] = $parsedItem;

				/**********************************************************************/

				$col = ($worksheetName == 'CCOM_17_1_1') ? 10 : 9;
				
				if ($row[$col] == 0) {
					foreach($parsedData as $item) {
						if ($item['acertos'] > 0 && $item['categoria_id'] == $catGeral) {
							$numeroQuestoes = $item['acertos'] + $item['erros'];
						}
					}
				} else {
					$numeroQuestoes = round(100
					* $row[$col]
					/ $row[$col+2]);
				}
				
				$parsedItem = [	
					'acertos' => (int) $row[$col], 
					'erros' => (int) ($numeroQuestoes - $row[$col]),
					'categoria_id' => $catGeral,
					'prova_id' => $prova,  		
					'aluno_id' => $aluno->id,
				];
				
				$parsedData[
					$parsedItem['aluno_id'] . '-' . 
					$parsedItem['prova_id'] . '-' . 
					$parsedItem['categoria_id']
				] = $parsedItem;
			}        
		}		
		
		$this->Resultados = TableRegistry::get('Resultados');
		if(!empty(array_keys($parsedData))){
			$find = $this->Resultados->find('list', ['valueField'=>"aluno_id-prova_id-categoria_id"]);
			$find->select(['aluno_id-prova_id-categoria_id' => $find->func()->
				concat([
					'aluno_id'=>'identifier', '-', 
					'prova_id'=>'identifier', '-', 
					'categoria_id'=>'identifier'
				])])
				->where([
					'aluno_id-prova_id-categoria_id IN'=>array_keys($parsedData)
				]);;
			// pr($find);
			$find = $find->toArray();
			// pr($find);

			foreach($find as $item)
				if(isset($parsedData[$item]))
					unset($parsedData[$item]);
		}
		
		return $parsedData;
	}
}