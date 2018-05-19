<?php

namespace App\Controller;

use App\Libs\Parser;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ParserController extends AppController{

	private function parseExample(){
		//$parse = new Parser();
		//$parsed_data = $parse->parse();

		$parsed_data = [
			['prova_id'=>1, 'aluno_id'=>1, 'categoria_id'=>1, 'acertos'=>20, "erros"=>30],
			['prova_id'=>1, 'aluno_id'=>2, 'categoria_id'=>1, 'acertos'=>20, "erros"=>30]
		];

		$this->Resultados = TableRegistry::get('Resultados');

		$parsed_obj = $this->Resultados->newEntities($parsed_data);
		//pr($parsed_obj);

		$find = ($this->Resultados->find()->where(['aluno_id'=>2]));
		foreach($find as $item) pr($item);

		foreach($parsed_obj as $item){
			$this->Resultados->save($item);
			pr($item);
		}

	}

	public function parse(){
		$this->parseCursos();
		$this->parseProvas();
		$this->parseTurmas();
		$this->parseAlunos();
		$this->parseResultados();
	}

	public function parseResultados() {
		$parse = new Parser();
		$parsed_data = $parse->parseResultados();
		if ($parsed_data != null) {
			$this->Resultados = TableRegistry::get('Resultados');
			$parsed_obj = $this->Resultados->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Resultados->save($item);
			}
		}
	}

	public function parseAlunos() {
		$parse = new Parser();
		$parsed_data = $parse->parseAlunos();
		if ($parsed_data != null) {
			$this->Alunos = TableRegistry::get('Alunos');
			$parsed_obj = $this->Alunos->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Alunos->save($item);
			}
		}
	}

	public function parseProvas() {
		$parse = new Parser();
		$parsed_data = $parse->parseProvas();
		if ($parsed_data != null) {
			$this->Provas = TableRegistry::get('Provas');
			$parsed_obj = $this->Provas->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Provas->save($item);
			}
		}
	}

	public function parseCursos() {
		$parse = new Parser();
		$parsed_data = $parse->parseCursos();
		if ($parsed_data != null) {
			$this->Cursos = TableRegistry::get('Cursos');
			$parsed_obj = $this->Cursos->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Cursos->save($item);
			}
		}
	}

	public function parseTurmas() {
		$parse = new Parser();
		$parsed_data = $parse->parseTurmas();
		if ($parsed_data != null) {
			$this->Turmas = TableRegistry::get('Turmas');
			$parsed_obj = $this->Turmas->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Turmas->save($item);
			}
		}
	}

}