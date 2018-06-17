<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProvasTurmasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProvasTurmasTable Test Case
 */
class ProvasTurmasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProvasTurmasTable
     */
    public $ProvasTurmas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.provas_turmas',
        'app.turmas',
        'app.cursos',
        'app.provas',
        'app.resultados',
        'app.alunos',
        'app.usuarios',
        'app.alunos_cursos',
        'app.alunos_turmas',
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
        $config = TableRegistry::exists('ProvasTurmas') ? [] : ['className' => ProvasTurmasTable::class];
        $this->ProvasTurmas = TableRegistry::get('ProvasTurmas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProvasTurmas);

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
