<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProvasTurmas Model
 *
 * @property \App\Model\Table\TurmasTable|\Cake\ORM\Association\BelongsTo $Turmas
 * @property \App\Model\Table\ProvasTable|\Cake\ORM\Association\BelongsTo $Provas
 *
 * @method \App\Model\Entity\ProvasTurma get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProvasTurma newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProvasTurma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProvasTurma|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProvasTurma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProvasTurma[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProvasTurma findOrCreate($search, callable $callback = null, $options = [])
 */
class ProvasTurmasTable extends Table
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

        $this->setTable('provas_turmas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Turmas', [
            'foreignKey' => 'turma_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Provas', [
            'foreignKey' => 'prova_id',
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
        $rules->add($rules->existsIn(['turma_id'], 'Turmas'));
        $rules->add($rules->existsIn(['prova_id'], 'Provas'));

        return $rules;
    }
}
