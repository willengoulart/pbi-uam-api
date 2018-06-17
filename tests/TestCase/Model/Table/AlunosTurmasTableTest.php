<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlunosTurmasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlunosTurmasTable Test Case
 */
class AlunosTurmasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AlunosTurmasTable
     */
    public $AlunosTurmas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.alunos_turmas',
        'app.alunos',
        'app.usuarios',
        'app.cursos',
        'app.provas',
        'app.turmas',
        'app.resultados',
        'app.categorias',
        'app.alunos_cursos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AlunosTurmas') ? [] : ['className' => AlunosTurmasTable::class];
        $this->AlunosTurmas = TableRegistry::get('AlunosTurmas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AlunosTurmas);

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
