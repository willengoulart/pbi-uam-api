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
	private $string;

	public function initialize() {
		$this->parser = new Parser();
	}

	public function parse(){
		$this->autoRender = false;
		$time_start = microtime(true);
		
		$this->parseCursos();
		$time_cursos = microtime(true);
		echo "<br>Cursos: " . ($time_cursos-$time_start) . " segundos";

		$this->parseTurmas();
		$time_turmas = microtime(true);
		echo "<br>Turmas: " . ($time_turmas-$time_cursos) . " segundos";

		$this->parseProvas();
		$time_provas = microtime(true);
		echo "<br>Provas: " . ($time_provas-$time_provas) . " segundos";

		$this->parseUsuarios();
		$time_usuarios = microtime(true);
		echo "<br>Usuarios: " . ($time_usuarios-$time_turmas) . " segundos";

		$this->parseAlunos();
		$time_alunos = microtime(true);
		echo "<br>Alunos: " . ($time_alunos-$time_usuarios) . " segundos";

		$this->createCategorias();
		$this->parseResultados();
		$time_resultados = microtime(true);
		echo "<br>Resultados: " . ($time_resultados-$time_alunos) . " segundos";
				
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo "<br>Importacao demorou " . $time . " segundos";

		echo json_encode($this->string);
	}

	public function createCategorias(){
		$categorias = [
			['name' => "Conhecimentos Especificos"],
			['name' => "Conhecimentos Gerais"]
		];
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
			unset($parsed_obj);
		}
		unset($parsed_data);
	}

	public function parseProvas() {
		$parsed_data = $this->parser->parseProvas();
		if (!empty($parsed_data)) {
			$this->Provas = TableRegistry::get('Provas');
			$parsed_obj = $this->Provas->newEntities($parsed_data);
			$this->Provas->saveMany($parsed_obj);
			unset($parsed_obj);
		}
		unset($parsed_data);
	}

	public function parseTurmas() {
		$parsed_data = $this->parser->parseTurmas();
		if (!empty($parsed_data)) {
			$this->Turmas = TableRegistry::get('Turmas');
			$parsed_obj = $this->Turmas->newEntities($parsed_data);
			$this->Turmas->saveMany($parsed_obj);
			unset($parsed_obj);
		}
		unset($parsed_data);
	}

	public function parseUsuarios(){
		$parsed_data = $this->parser->parseUsuarios();
		if (!empty($parsed_data)) {
			$this->Usuarios = TableRegistry::get('Usuarios');
			$parsed_obj = $this->Usuarios->newEntities($parsed_data);
			// foreach ($parsed_obj as $item) $this->Usuarios->save($item);
			if(!$this->Usuarios->saveMany($parsed_obj)){
				foreach ($parsed_obj as $key => $value) {
					if($erros = $value->errors()){
						$this->string[] = "Usuário " . $value->nome . " (Email: ".$value->email.") possui dados incompletos";
					}
				}
			}
			unset($parsed_obj);
		}
		unset($parsed_data);
	}

	public function parseAlunos() {
		$parsed_data = $this->parser->parseAlunos();
		if (!empty($parsed_data)) {
			$this->Alunos = TableRegistry::get('Alunos');
			//$parsed_obj = $this->Alunos->newEntities($parsed_data);
			foreach($parsed_data as $item){
				$parsed_obj = $this->Alunos->newEntity($item);
				$this->Alunos->save($parsed_obj);
				$this->Alunos->Turmas->link($parsed_obj, $item['turmas']);
				$this->Alunos->Cursos->link($parsed_obj, $item['cursos']);
			}
			$this->Alunos->saveMany($parsed_obj);
			unset($parsed_obj);
		}
		unset($parsed_data);
	}

	public function parseResultados() {
		$parsed_data = $this->parser->parseResultados();
		if (!empty($parsed_data)) {
			$this->Resultados = TableRegistry::get('Resultados');
			$parsed_obj = $this->Resultados->newEntities($parsed_data);
			$this->Resultados->saveMany($parsed_obj);
			unset($parsed_obj);
		}
		unset($parsed_data);
	}

}