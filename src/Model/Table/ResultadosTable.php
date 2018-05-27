<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Resultados Model
 *
 * @property \App\Model\Table\ProvasTable|\Cake\ORM\Association\BelongsTo $Provas
 * @property \App\Model\Table\AlunosTable|\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\CategoriasTable|\Cake\ORM\Association\BelongsTo $Categorias
 *
 * @method \App\Model\Entity\Resultado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Resultado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Resultado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Resultado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Resultado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Resultado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Resultado findOrCreate($search, callable $callback = null, $options = [])
 */
class ResultadosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('resultados');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Provas', [
            'foreignKey' => 'prova_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Categorias', [
            'foreignKey' => 'categoria_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('acertos')
            ->requirePresence('acertos', 'create')
            ->notEmpty('acertos');

        $validator
            ->integer('erros')
            ->requirePresence('erros', 'create')
            ->notEmpty('erros');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['prova_id'], 'Provas'));
        $rules->add($rules->existsIn(['aluno_id'], 'Alunos'));
        $rules->add($rules->existsIn(['categoria_id'], 'Categorias'));

        return $rules;
    }
}
