<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlunosCursosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlunosCursosTable Test Case
 */
class AlunosCursosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AlunosCursosTable
     */
    public $AlunosCursos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.alunos_cursos',
        'app.alunos',
        'app.usuarios',
        'app.cursos',
        'app.provas',
        'app.turmas',
        'app.alunos_turmas',
        'app.resultados',
        'app.categorias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AlunosCursos') ? [] : ['className' => AlunosCursosTable::class];
        $this->AlunosCursos = TableRegistry::get('AlunosCursos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AlunosCursos);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
