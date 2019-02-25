<?php

namespace mortalswat\dotini;

/**
 * La clase para la conexi�n al servidor D3
 */
class DotIniConfig
{
    /** @var string */
    private $iniFilename;
    /** @var string */
    private $iniPath;
    /** @var array */
    private $dotIniParams;

    /**
     * D3Connection Constructor
     * Crea una nueva conexi�n
     *
     * @param $iniPath
     * @param $iniFilename
     */
    public function __construct($iniPath, $iniFilename)
    {
        $this->loadDotIniConfig($iniPath, $iniFilename);
    }

    /**
     * @return string
     */
    public function getIniPath()
    {
        return $this->iniPath;
    }

    /**
     * @return string
     */
    public function getIniFilename()
    {
        return $this->iniFilename;
    }

    /**
     * @return string
     */
    public function getIniFullName()
    {
        return $this->iniPath.'/'.$this->iniFilename.'.ini';
    }

    /**
     * @param $iniPath
     * @param $iniFilename
     * @return $this
     * @throws ConfigExeption
     */
    public function loadDotIniConfig($iniPath, $iniFilename)
    {
        $this->iniPath = $iniPath;
        $this->iniFilename = $iniFilename;

        $this->dotIniParams = parse_ini_file($iniPath.'/'.$iniFilename.'.ini', true);

        if ($this->dotIniParams === false) {
            throw new ConfigExeption('No se ha podido cargar el fichero "'.$iniPath.'/'.$iniFilename.'"');
        }

        return $this;
    }

    /**
     * @param string $param
     * @return mixed
     * @throws ConfigExeption
     */
    public function getStrictParam($param)
    {
        if(!isset($this->dotIniParams[$param])){
            throw new ConfigExeption('Sin declarar parámetro necesario "'.$param.'"');
        }

        return $this->dotIniParams[$param];
    }

    /**
     * @param string $param
     * @param mixed|null $defaultValue
     * @return mixed|null
     */
    public function getOptionalParam($param, $defaultValue = null)
    {
        if(!isset($this->dotIniParams[$param])){
            return $defaultValue;
        }

        return $this->dotIniParams[$param];
    }
}
