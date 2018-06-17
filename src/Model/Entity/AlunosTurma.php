<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlunosTurma Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property int $turma_id
 *
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Turma $turma
 */
class AlunosTurma extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'aluno_id' => true,
        'turma_id' => true,
        'aluno' => true,
        'turma' => true
    ];
}
