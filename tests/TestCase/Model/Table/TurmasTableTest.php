<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurmasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TurmasTable Test Case
 */
class TurmasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TurmasTable
     */
    public $Turmas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.turmas',
        'app.cursos',
        'app.provas',
        'app.resultados',
        'app.alunos',
        'app.usuarios',
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
        $config = TableRegistry::exists('Turmas') ? [] : ['className' => TurmasTable::class];
        $this->Turmas = TableRegistry::get('Turmas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Turmas);

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
