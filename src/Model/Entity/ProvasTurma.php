<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProvasTurma Entity
 *
 * @property int $id
 * @property int $turma_id
 * @property int $prova_id
 *
 * @property \App\Model\Entity\Turma $turma
 * @property \App\Model\Entity\Prova $prova
 */
class ProvasTurma extends Entity
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
        'turma_id' => true,
        'prova_id' => true,
        'turma' => true,
        'prova' => true
    ];
}
