<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Turma Entity
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $curso_id
 * @property string $periodo
 *
 * @property \App\Model\Entity\Curso $curso
 */
class Turma extends Entity
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
        'id' => true,
        'name' => true,
        'code' => true,
        'curso_id' => true,
        'periodo' => true,
        'curso' => true
    ];
}
