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
        $filter_raw = $this->request->query();
        $filter = [];
        foreach ($filter_raw as $key => $value)
          $filter[$key.' IN'] = $value;
        $query = $this->Provas->find()->contain(['Cursos', 'Turmas']);
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
