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

	public function initialize() {
		$this->parser = new Parser();
		$this->parse();
	}

	public function parse(){
		$time_start = microtime(true);

		$this->parseCursos();
		$this->parseProvas();
		$this->parseTurmas();
		$this->parseUsuarios();
		$this->parseAlunos();
		$this->createCategorias();
		$this->parseResultados("Conhecimentos Especificos", 7);
		$this->parseResultados("Conhecimentos Gerais", 10);
		$this->parseResultados("Total", 13);
				
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo "<br>Importacao demorou " . $time . " segundos";
	}

	public function createCategorias(){
		$categorias = [['name' => "Conhecimentos Especificos"],
			['name' => "Conhecimentos Gerais"],
			['name' => "Total"]];
		$this->Categorias = TableRegistry::get('Categorias');
		
		foreach($categorias as $cat) {
			$find = $this->Categorias->find()->where(['name'=>$cat['name']]);
			
			if ($find->isEmpty()) {
				$obj = $this->Categorias->newEntity($cat);
				$this->Categorias->save($obj);
			}
		}
	}

	public function parseCursos() {
		$parsed_data = $this->parser->parseCursos();
		if (!empty($parsed_data)) {
			$this->Cursos = TableRegistry::get('Cursos');
			$parsed_obj = $this->Cursos->newEntities($parsed_data);
			$this->Cursos->saveMany($parsed_obj);
		}
	}

	public function parseProvas() {
		$parsed_data = $this->parser->parseProvas();
		if (!empty($parsed_data)) {
			$this->Provas = TableRegistry::get('Provas');
			$parsed_obj = $this->Provas->newEntities($parsed_data);
			$this->Provas->saveMany($parsed_obj);
		}
	}

	public function parseTurmas() {
		$parsed_data = $this->parser->parseTurmas();
		if (!empty($parsed_data)) {
			$this->Turmas = TableRegistry::get('Turmas');
			$parsed_obj = $this->Turmas->newEntities($parsed_data);
			$this->Turmas->saveMany($parsed_obj);
		}
	}

	public function parseUsuarios(){
		$parsed_data = $this->parser->parseUsuarios();
		if (!empty($parsed_data)) {
			$this->Usuarios = TableRegistry::get('Usuarios');
			$parsed_obj = $this->Usuarios->newEntities($parsed_data);
			// $this->Usuarios->saveMany($parsed_obj);
			foreach ($parsed_obj as $item) $this->Usuarios->save($item);
		}
	}

	public function parseAlunos() {
		$parsed_data = $this->parser->parseAlunos();
		if (!empty($parsed_data)) {
			$this->Alunos = TableRegistry::get('Alunos');
			$parsed_obj = $this->Alunos->newEntities($parsed_data);
			$this->Alunos->saveMany($parsed_obj);
		}
	}

	public function parseResultados($nomeCategoria, $colunaCategoria){
		$parsed_data = $this->parser->parseResultados($nomeCategoria, $colunaCategoria);
		if (!empty($parsed_data)) {
			$this->Resultados = TableRegistry::get('Resultados');
			$parsed_obj = $this->Resultados->newEntities($parsed_data);
			$this->Resultados->saveMany($parsed_obj);
		}
	}

}