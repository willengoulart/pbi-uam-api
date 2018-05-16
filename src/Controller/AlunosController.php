<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 *
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunosController extends AppController
{

  public function index()
  {
      $filter_raw = $this->request->query();
      $filter = [];
      foreach ($filter_raw as $key => $value)
        $filter[$key.' IN'] = $value;
      $query = $this->Alunos->find();
      $query->where($filter);

      $cursos = $this->paginate($query);

      return $this->response->withStringBody(json_encode($cursos));
  }

  public function view($id = null)
  {
      $turma = $this->Alunos->get($id, [
          'contain' => ['Usuarios', 'Resultados']
      ]);

      return $this->response->withStringBody(json_encode($turma));
  }
}
