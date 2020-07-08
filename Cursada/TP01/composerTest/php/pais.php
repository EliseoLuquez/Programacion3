<?php


require_once'./vendor/autoload.php';
use NNV\RestCountries;

require_once'imostrar.php';
require_once'region.php';

class Pais extends Region implements IMostrar
{
    
    public $pais;
    public $topLevelDomain;
    public $alpha2Code;
    public $alpha3Code;
    public $callingCodes;
    public $capital;
    public $altSpellings;
    public $region;
    public $subregion;
    public $population;
    public $latlng;
    public $demonym;
    public $area;
    public $gini;
    public $timezones;
    public $borders;
    public $nativeName;
    public $numericCode;
    public $currencies;
    public $languages;
    public $translations;
    public $flag;
    public $regionalBlocs;
    public $cioc;

    public function __construct($tierra, $region, $pais)
    {
        parent::__construct($tierra, $region, $pais);
        $this->pais = $pais;
    }

    public function Mostrar()
    {
        echo "Pais: $this->pais<br/>";
        echo "TopLevelDomain: $this->topLevelDomain<br/>";
        echo "Alpha2Code: $this->alpha2Code<br/>";
        echo "CallingCodes: $this->callingCodes<br/>";
        echo "Capital: $this->capital<br/>";
        echo "AltSpellings:<br/>";
        foreach ($this->altSpellings as $key => $value)
        {
            echo "$value<br/>";
        }
        parent::Mostrar();
        echo "Subregion: $this->subregion<br/>";
        echo "Population: $this->population<br/>";
        echo "Latlng:<br/>";
        foreach ($this->latlng as $key => $value)
        {
            echo "$value<br/>";
        }
        echo "Demonym: $this->demonym<br/>";
        echo "Area: $this->area<br/>";
        echo "Gini: $this->gini<br/>";
        echo "Timezones: $this->timezones<br/>";
        echo "Borders:<br/>";
        foreach ($this->borders as $key => $value)
        {
            echo "$value<br/>";
        }
        echo "NativeName: $this->nativeName<br/>";
        echo "NumericCode: $this->numericCode<br/>";
        echo "Currencies:<br/>";
        foreach ($this->borders as $key => $value)
        {
            foreach ($value as $clave => $value01) 
            {
                echo "$clave: $value01<br/>";
            }   
        }
        echo "Languages:<br/>";
        foreach ($this->languages as $key => $value)
        {
            foreach ($value as $clave => $value01) 
            {
                echo "$clave: $value01<br/>";
            }   
        }
        echo "Translations:<br/>";
        foreach ($this->translations as $key => $value)
        {
            foreach ($value as $clave => $value01) 
            {
                echo "$clave: $value01<br/>";
            }   
        }
        echo "Flag: $this->flag<br/>";
        echo "RegionalBlocs:<br/>";
        foreach ($this->regionalBlocs as $key => $value)
        {
            foreach ($value as $clave => $value01) 
            {
                echo "$clave: $value01<br/>";
            }   
        }
        echo "Cioc: $this->cioc<br/>";  
    }


    private function ObtenerPaises($paises)
    {
        $paises = array();
        foreach ($paises as $key => $value)
        {
              $paisAux = new Pais("Tierra", "region", "pais");
              $paisAux->__construct($pais->tierra, $pais->region, $pais->pais);
              foreach ($value as $llave => $value01) 
              {
                  if($clave != 'pais' && $clave != 'region')
                  {
                        $paisAux->clave = $value01; 
                  }
              }
        }
        array_push($paises, $paisAux);
    } 

    public static function PaisPorNombre($pais)
    {
        $restCountries = new RestCountries;
        $paises = $restCountries->byName($pais);
        return Pais::ObtenerPaises($paises);
    }


}