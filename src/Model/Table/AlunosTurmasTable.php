<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlunosTurmas Model
 *
 * @property \App\Model\Table\AlunosTable|\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\TurmasTable|\Cake\ORM\Association\BelongsTo $Turmas
 *
 * @method \App\Model\Entity\AlunosTurma get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlunosTurma newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlunosTurma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlunosTurma|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlunosTurma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlunosTurma[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlunosTurma findOrCreate($search, callable $callback = null, $options = [])
 */
class AlunosTurmasTable extends Table
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

        $this->setTable('alunos_turmas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Turmas', [
            'foreignKey' => 'turma_id',
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
        $rules->add($rules->existsIn(['aluno_id'], 'Alunos'));
        $rules->add($rules->existsIn(['turma_id'], 'Turmas'));

        return $rules;
    }

    public function alunosDaTurma($turma_id){
        return $this->find('list')->where(['turma_id'=>$turma_id])->toArray();
    }

}
