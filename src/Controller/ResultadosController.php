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

  public function getResultados(){
    $query = $this->Resultados->find();
    $filter = $this->request->query();
    $query = $query->where($filter);
    return $this->response->withStringBody(json_encode($query->all()));
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
