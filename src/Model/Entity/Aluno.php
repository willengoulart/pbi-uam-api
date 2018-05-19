<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aluno Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $ra
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Resultado[] $resultados
 */
class Aluno extends Entity
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
        'usuario_id' => true,
        'ra' => true,
        'usuario' => true,
        'resultados' => true
    ];
}
