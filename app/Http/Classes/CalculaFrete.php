<?php

namespace App\Http\Classes;

class CalculaFrete
{
    public static function calculaValor($cep)
    {
        switch ($cep) {
            case '77006-028':
                return 20;
                break;
            case '77006-029':
                return 10;
                break;
            case '77006-030':
                return 30;
                break;
            case '77650-000':
                return 50;
                break;
            default:
                return 0;
                break;
        }
    }
}
