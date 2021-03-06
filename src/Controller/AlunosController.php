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
      $related = ['Cursos'=>'curso_id', 'Turmas'=>'turma_id'];
      $relatedFields = ['Cursos'=>'id', 'Turmas'=>'id'];
      $filter_raw = $this->request->query();
      $filter = [];
      $query = $this->Alunos->find()->contain(['Turmas', 'Cursos', 'Usuarios']);
      foreach ($filter_raw as $key => $value){
        if(!$model = array_search($key, $related))
          $filter[$key.' IN'] = $value;
          else{
            $query->matching($model, function($q) use($model, $value, $relatedFields){
              return $q->where(["$model.$relatedFields[$model] IN"=>$value]);
            });
          }
      }

      $query->where($filter);

      $cursos = $query->all();

      return $this->response->withStringBody(json_encode($cursos));
  }

  public function view($id = null)
  {
      $turma = $this->Alunos->get($id, [
          'contain' => ['Usuarios', 'Cursos', 'Turmas']
      ]);

      return $this->response->withStringBody(json_encode($turma));
  }
}
