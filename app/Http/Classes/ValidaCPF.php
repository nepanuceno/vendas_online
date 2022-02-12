<?php
namespace App\Http\Classes;

class ValidaCPF
{
    const FACTOR_DIGIT_1 = 10;
    const FACTOR_DIGIT_2 = 11;
    const MAX_DIGITS_1 = 9;
    const MAX_DIGITS_2 = 10;

    private static function onlyNumbers($cpf)
    {
        return preg_replace("/[^0-9]/", "", $cpf);
    }

    private static function isIvalidLength($cpf)
    {
        return strlen($cpf) != 11;
    }

    private static function allDigitsEquals($cpf):bool
    {
        foreach(str_split($cpf) as $item)
        {
            if(str_split($cpf)[0] !== $item) return false;
        }
        return true;
    }

    private static function toDigitArray($cpf) {

        $cpf = str_split($cpf);
        return array_map(function($item){
            return (int) $item;
        }, $cpf);
    }

    private static function calculateDigit($cpf, $factor, $max)
    {
        $cpf = self::toDigitArray($cpf);
        $total = 0;
        for($i=0; $i<=$max-1; $i++)
        {
            $total += $cpf[$i]*$factor--;
        }
        return $total%11 < 2?0:(11-$total%11);
    }

    private static function getCheckDigit($cpf) {
        return substr($cpf,9);
    }

    public static function validate($cpf)
    {
        if (!is_string($cpf)) return false;
        $cpf = self::onlyNumbers($cpf);
        if (self::isIvalidLength($cpf)) return false;
        if(self::allDigitsEquals($cpf)) return false;

        $digit1 = self::calculateDigit($cpf, self::FACTOR_DIGIT_1, self::MAX_DIGITS_1);
	    $digit2 = self::calculateDigit($cpf, self::FACTOR_DIGIT_2, self::MAX_DIGITS_2);

        $digit = self::getCheckDigit($cpf);

        return $digit == $digit1.$digit2? true:false;
    }
}
