<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Estoque;
use App\Http\Classes\Desconto;
use App\Http\Classes\CalculaFrete;

class VendaController extends Controller
{
    const VALOR_TOTAL=1240;
    const CUPOM_DESCONTO="CUPOM50";
    const CEP='77650-000';

    private $estoque;

    public function index(Request $request)
    {
        $this->estoque = new Estoque();
        $valorDesconto = $this->aplicarDesconto(self::CUPOM_DESCONTO, self::VALOR_TOTAL);
        $valor_frete=CalculaFrete::calculaValor(self::CEP);
        $produtos = $this->estoque->getEstoque();
        $compra = array(
            'produtos'=>$produtos,
            'valor_total'=>self::VALOR_TOTAL,
            'valor_frete'=>$valor_frete,
            'cupom_desconto'=>self::CUPOM_DESCONTO,
            'valor_final'=>$valorDesconto['valor']+$valor_frete
        );
        $this->updateEstoque($produtos);
        $produtos=$this->estoque->getEstoque();
        return view('index', compact('compra','produtos'));
    }

    private function updateEstoque($produtos)
    {
        foreach($produtos as $item)
        {
            $this->estoque->updateProduto($item['id']);
        }
    }

    public function aplicarDesconto($cupom, $valor):array
    {
        $desconto = new Desconto();
        $desconto->setCupom($cupom);
        $desconto->setValor($valor);
        $valorDesconto = $desconto->getDesconto();
        $valorFinal = $desconto->getValorFinal();
        return ['desconto'=>$valorDesconto, 'valor'=>$valorFinal];
    }
}
