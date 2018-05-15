<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cursos Controller
 *
 * @property \App\Model\Table\CursosTable $Cursos
 *
 * @method \App\Model\Entity\Curso[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TurmasController extends AppController
{

    public function index()
    {
        $filter_raw = $this->request->query();
        $filter = [];
        foreach ($filter_raw as $key => $value)
          $filter[$key.' IN'] = $value;
        $query = $this->Turmas->find();
        $query->where($filter);

        $cursos = $this->paginate($query);

        return $this->response->withStringBody(json_encode($cursos));
    }

    public function view($id = null)
    {
        $turma = $this->Turmas->get($id, [
            'contain' => ['Curso']
        ]);

        return $this->response->withStringBody(json_encode($turma));
    }
}
