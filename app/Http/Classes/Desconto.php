<?php
namespace App\Http\Classes;

class Desconto
{
    private $cupom;
    private $valor;

    public function __construct()
    {
        $this->cupom = null;
        $this->valor = 0;
    }

    public function setCupom($cupom)
    {
        $this->cupom = $cupom;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getDesconto()
    {
        switch ($this->cupom) {
            case 'CUPOM10':
                return $this->valor*0.10;
                break;
            case 'CUPOM20':
                return $this->valor*0.20;
                break;
            case 'CUPOM50':
                return $this->valor*0.50;
                break;

            default:
                return 0;
                break;
        }
    }

    public function getValorFinal()
    {
        return $this->valor - $this->getDesconto();
    }

}
