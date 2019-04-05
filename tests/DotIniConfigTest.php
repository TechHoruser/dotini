<?php
/**
 * Created by PhpStorm.
 * User: fbarba
 * Date: 26/03/19
 * Time: 9:42
 */

namespace mortalswat\dotini;


class DotIniConfigTest extends \PHPUnit_Framework_TestCase
{
    /** @var DotIniConfig */
    private $class;
    /** @var DotIniConfig */
    private $classWithSections;

    public function setUp()
    {
        $this->class = new DotIniConfig('tests', 'testsPrueba');
        new DotIniConfig('tests', 'testsEmpty');
    }

    /**
     * @expectedException \mortalswat\dotini\ConfigExeption
     */
    public function test__constructMalFormado()
    {
        new DotIniConfig('.', 'testsMal');
    }

    /**
     * @expectedException \mortalswat\dotini\ConfigExeption
     */
    public function test__constructFicheroInexistente()
    {
        new DotIniConfig('', '');
    }

    public function testGetIniPath()
    {
        $this->assertNotNull($this->class->getIniPath());
    }

    public function testGetIniFilename()
    {
        $this->assertNotNull($this->class->getIniFilename());
    }

    public function testGetIniFullName()
    {
        $this->assertNotNull($this->class->getIniFullName());
    }

    /**
     * @expectedException \mortalswat\dotini\ConfigExeption
     */
    public function testGetStrictParamNoExiste()
    {
        $this->class->getStrictParam('primera_sección/veinte');
    }

    public function testGetStrictParamExiste()
    {
        $this->assertNotNull($this->class->getStrictParam('primera_sección/uno'));
    }

    public function testGetOptionalParam()
    {
        $this->assertNotNull($this->class->getOptionalParam('primera_sección/uno'));
        $this->assertNotNull($this->class->getOptionalParam('primera_sección/uno', NULL));
        $this->assertNull($this->class->getOptionalParam('primera_subsección\/unoas'));
        $this->assertTrue($this->class->getOptionalParam('primera_sección\/asd', TRUE));
    }
}
