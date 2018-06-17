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
class CursosController extends AppController
{

    public function index()
    {
        $filter_raw = $this->request->query();
        $filter = [];
        foreach ($filter_raw as $key => $value)
          $filter[$key.' IN'] = $value;
        $query = $this->Cursos->find();
        $query->where($filter);

        $cursos = $query->all();

        return $this->response->withStringBody(json_encode($cursos));
    }

    public function view($id = null)
    {
        $curso = $this->Cursos->get($id, [
            'contain' => ['Provas', 'Turmas']
        ]);

        return $this->response->withStringBody(json_encode($curso));
    }
}
