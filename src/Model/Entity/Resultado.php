<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Resultado Entity
 *
 * @property int $id
 * @property int $prova_id
 * @property int $aluno_id
 * @property int $categoria_id
 * @property int $acertos
 * @property int $erros
 *
 * @property \App\Model\Entity\Prova $prova
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Categoria $categoria
 */
class Resultado extends Entity
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
        'prova_id' => true,
        'aluno_id' => true,
        'categoria_id' => true,
        'acertos' => true,
        'erros' => true,
        'prova' => true,
        'aluno' => true,
        'categoria' => true
    ];
}
