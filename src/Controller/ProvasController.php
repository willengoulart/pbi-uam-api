<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cursos Controller
 *
 * @property \App\Model\Table\ProvasTable $Cursos
 *
 * @method \App\Model\Entity\Curso[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProvasController extends AppController
{

    public function index()
    {
      $related = ['Turmas'=>'turma_id'];
      $relatedFields = ['Turmas'=>'id'];
      $filter_raw = $this->request->query();
      $filter = [];
      $query = $this->Provas->find()->contain(['Turmas', 'Cursos']);
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

        $provas = $this->paginate($query);

        return $this->response->withStringBody(json_encode($provas));
    }

    public function view($id = null)
    {
        $turma = $this->Provas->get($id, [
            'contain' => ['Cursos', 'Turmas']
        ]);

        return $this->response->withStringBody(json_encode($turma));
    }
}
