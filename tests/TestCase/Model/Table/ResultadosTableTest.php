<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResultadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResultadosTable Test Case
 */
class ResultadosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResultadosTable
     */
    public $Resultados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resultados',
        'app.provas',
        'app.cursos',
        'app.turmas',
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
        $config = TableRegistry::exists('Resultados') ? [] : ['className' => ResultadosTable::class];
        $this->Resultados = TableRegistry::get('Resultados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Resultados);

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
