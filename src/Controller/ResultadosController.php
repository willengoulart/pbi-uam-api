<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ResultadosController extends AppController{

  public function index(){
    $query = $this->Resultados->find();
    $filter = $this->request->query();
    foreach($filter as $field=>$item){
      $query = $query->where([$field." IN"=>$item]);
    }
    $data = $query->contain(['Alunos', 'Categorias', 'Provas'])->hydrate(false)->indexBy('id')->toArray();
    foreach($data as &$item){
      unset($item['aluno_id']);
      unset($item['categoria_id']);
      unset($item['prova_id']);
    }
    return $this->response->withStringBody(json_encode($data));
  }

  public function getResultadosFromUser(){
    if(!$this->request->query('aluno_id')){
      // USUARIO DA SESSAO
      $user_id = 2;
      $query = $this->Resultados->find();
      $filter = $this->request->query();
      $query = $query->where($filter);
      // Forçar o usuário logado
      $query = $query->where(['aluno_id'=>$user_id]);
      return $this->response->withStringBody(json_encode($query->all()));
    }
    return $this->response->withStatus(403);
  }

}
