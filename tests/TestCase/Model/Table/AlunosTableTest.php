<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlunosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlunosTable Test Case
 */
class AlunosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AlunosTable
     */
    public $Alunos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.alunos',
        'app.usuarios',
        'app.resultados',
        'app.provas',
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
        $config = TableRegistry::exists('Alunos') ? [] : ['className' => AlunosTable::class];
        $this->Alunos = TableRegistry::get('Alunos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Alunos);

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
