<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProvasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProvasTable Test Case
 */
class ProvasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProvasTable
     */
    public $Provas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.provas',
        'app.cursos',
        'app.turmas',
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
        $config = TableRegistry::exists('Provas') ? [] : ['className' => ProvasTable::class];
        $this->Provas = TableRegistry::get('Provas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Provas);

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
