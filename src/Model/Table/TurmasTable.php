<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Turmas Model
 *
 * @property \App\Model\Table\CursosTable|\Cake\ORM\Association\BelongsTo $Cursos
 *
 * @method \App\Model\Entity\Turma get($primaryKey, $options = [])
 * @method \App\Model\Entity\Turma newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Turma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Turma|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Turma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Turma[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Turma findOrCreate($search, callable $callback = null, $options = [])
 */
class TurmasTable extends Table
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

        $this->setTable('turmas');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cursos', [
            'foreignKey' => 'curso_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Alunos', [
            'foreignKey' => 'turma_id',
            'targetForeignKey' => 'aluno_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        $validator
            ->scalar('periodo')
            ->maxLength('periodo', 255)
            ->requirePresence('periodo', 'create')
            ->notEmpty('periodo');

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
        $rules->add($rules->existsIn(['curso_id'], 'Cursos'));

        return $rules;
    }
}
