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

	private $parser;

	function __construct() {
		$this->parser = new Parser();
	}

	public function parse(){
		$time_start = microtime(true);
		$this->parseCursos();
		$this->parseProvas();
		$this->parseTurmas();
		$this->parseResultados();
		$this->parseAlunos();
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo "<br>" . $time;
	}

	public function parseResultados(){
		$parsed_data = $this->parser->parseResultados();
		if ($parsed_data != null) {
			$this->Resultados = TableRegistry::get('Resultados');
			$parsed_obj = $this->Resultados->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Resultados->save($item);
			}
		}
	}

	public function parseAlunos() {
		$parsed_data = $this->parser->parseAlunos();
		if ($parsed_data != null) {
			$this->Alunos = TableRegistry::get('Alunos');
			$parsed_obj = $this->Alunos->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Alunos->save($item);
			}
		}
	}

	public function parseProvas() {
		$parsed_data = $this->parser->parseProvas();
		if ($parsed_data != null) {
			$this->Provas = TableRegistry::get('Provas');
			$parsed_obj = $this->Provas->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Provas->save($item);
			}
		}
	}

	public function parseCursos() {
		$parsed_data = $this->parser->parseCursos();
		if ($parsed_data != null) {
			$this->Cursos = TableRegistry::get('Cursos');
			$parsed_obj = $this->Cursos->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Cursos->save($item);
			}
		}
	}

	public function parseTurmas() {
		$parsed_data = $this->parser->parseTurmas();
		if ($parsed_data != null) {
			$this->Turmas = TableRegistry::get('Turmas');
			$parsed_obj = $this->Turmas->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Turmas->save($item);
			}
		}
	}

}