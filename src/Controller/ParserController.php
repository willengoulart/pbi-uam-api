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
		// $time_start = microtime(true);

		$this->parseCursos();
		$this->parseProvas();
		$this->parseTurmas();
		$this->parseUsuarios();
		$this->parseAlunos();
		$this->createCategorias();
		$this->parseResultados("Conhecimentos Especificos", 7);
		$this->parseResultados("Conhecimentos Gerais", 10);
		$this->parseResultados("Total", 13);
				
		// $time_end = microtime(true);
		// $time = $time_end - $time_start;
		// echo "<br>Importacao demorou " . $time . " segundos";
	}

	public function createCategorias(){
		$categorias = [['name' => "Conhecimentos Especificos"],
			['name' => "Conhecimentos Gerais"],
			['name' => "Total"]];
		$this->Categorias = TableRegistry::get('Categorias');
		
		foreach($categorias as $cat) {
			$find = $this->Categorias->find()->where([
				'name'=>$cat['name']
			]);
			
			foreach($find as $item) if ($item->name === $cat['name']) continue 2;

			$obj = $this->Categorias->newEntity($cat);
			$this->Categorias->save($obj);
		}
	}

	public function parseCursos() {
		$parsed_data = $this->parser->parseCursos();
		if (!empty($parsed_data)) {
			$this->Cursos = TableRegistry::get('Cursos');
			$parsed_obj = $this->Cursos->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Cursos->save($item);
			}
		}
	}

	public function parseProvas() {
		$parsed_data = $this->parser->parseProvas();
		if (!empty($parsed_data)) {
			$this->Provas = TableRegistry::get('Provas');
			$parsed_obj = $this->Provas->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Provas->save($item);
			}
		}
	}

	public function parseTurmas() {
		$parsed_data = $this->parser->parseTurmas();
		if (!empty($parsed_data)) {
			$this->Turmas = TableRegistry::get('Turmas');
			$parsed_obj = $this->Turmas->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Turmas->save($item);
			}
		}
	}

	public function parseUsuarios(){
		$parsed_data = $this->parser->parseUsuarios();
		if (!empty($parsed_data)) {
			$this->Usuarios = TableRegistry::get('Usuarios');
			$parsed_obj = $this->Usuarios->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Usuarios->save($item);
			}
		}
	}

	public function parseAlunos() {
		$parsed_data = $this->parser->parseAlunos();
		if (!empty($parsed_data)) {
			$this->Alunos = TableRegistry::get('Alunos');
			$parsed_obj = $this->Alunos->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Alunos->save($item);
			}
		}
	}

	public function parseResultados($nc, $cc){
		$parsed_data = $this->parser->parseResultados($nc, $cc);
		if (!empty($parsed_data)) {
			$this->Resultados = TableRegistry::get('Resultados');
			$parsed_obj = $this->Resultados->newEntities($parsed_data);
			foreach($parsed_obj as $item){
				$this->Resultados->save($item);
			}
		}
	}

}