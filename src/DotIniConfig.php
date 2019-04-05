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
     * DotIniConfig constructor.
     * @param string $iniPath
     * @param string $iniFilename
     * @throws ConfigExeption
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
        return $this->iniPath . '/' . $this->iniFilename . '.ini';
    }

    /**
     * @param string $iniPath
     * @param string $iniFilename
     * @return $this
     * @throws ConfigExeption
     */
    public function loadDotIniConfig($iniPath, $iniFilename)
    {
        $this->iniPath = $iniPath;
        $this->iniFilename = $iniFilename;

        try {
            $this->dotIniParams = parse_ini_file($iniPath . '/' . $iniFilename . '.ini', true);
        } catch (\Exception $exception) {
            throw new ConfigExeption('No se ha podido cargar el fichero "' . $iniPath . '/' . $iniFilename . '"');
        }

        if (empty($this->dotIniParams) && (($file = file_get_contents($this->getIniFullName())) !== '' || $file === false)) {
            throw new ConfigExeption('El fichero "' . $iniPath . '/' . $iniFilename . '" está mal formado.');
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
        $array = preg_split("/(?<!\\\)\\//", $param);
        $conf = $this->dotIniParams;
        foreach ($array as $section) {
            $section = preg_replace("/\\\/", "", $section);
            if (!isset($conf[$section])) {
                throw new ConfigExeption('Sin declarar parámetro necesario "' . $param . '"');
            }
            $conf = $conf[$section];
        }

        return $conf;
    }

    /**
     * @param string $param
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getOptionalParam($param, $defaultValue = null)
    {
        $array = preg_split("/(?<!\\\)\\//", $param);
        $conf = $this->dotIniParams;
        foreach ($array as $section) {
            $section = preg_replace("/\\\/", "", $section);
            if (!isset($conf[$section])) {
                return $defaultValue;
            }
            $conf = $conf[$section];
        }

        return $conf;
    }
}
