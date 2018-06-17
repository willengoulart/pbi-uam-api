<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 *
 * @method \App\Model\Entity\Categoria[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriasController extends AppController
{

  public function index()
  {
      $filter_raw = $this->request->query();
      $filter = [];
      foreach ($filter_raw as $key => $value)
        $filter[$key.' IN'] = $value;
      $query = $this->Categorias->find();
      $query->where($filter);

      $cursos = $query->all();

      return $this->response->withStringBody(json_encode($cursos));
  }

  public function view($id = null)
  {
      $turma = $this->Categorias->get($id);

      return $this->response->withStringBody(json_encode($turma));
  }
}
