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

	public function parse(){
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

}