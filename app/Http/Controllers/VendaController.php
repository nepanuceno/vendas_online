<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Estoque;
use App\Http\Classes\Desconto;
use App\Http\Classes\CalculaFrete;

class VendaController extends Controller
{
    const CUPOM_DESCONTO="CUPOM50";
    const CEP='77650-000';

    private $estoque;

    public function index(Request $request)
    {
        $this->estoque = new Estoque();
        $produtos = $this->carrinho($this->estoque->getEstoque());
        $valorDesconto = $this->aplicarDesconto(self::CUPOM_DESCONTO, $produtos['valor_total_carrinho']);
        $valor_frete=CalculaFrete::calculaValor(self::CEP);
        $compra = array(
            'produtos'=>$produtos['produtos'],
            'valor_total'=>$produtos['valor_total_carrinho'],
            'valor_frete'=>$valor_frete,
            'cupom_desconto'=>self::CUPOM_DESCONTO,
            'valor_final'=>$valorDesconto['valor']+$valor_frete
        );
        $this->updateEstoque($produtos['produtos']);
        $produtos=$this->estoque->getEstoque();
        return view('index', compact('compra','produtos'));
    }

    private function carrinho($estoque)
    {
        $valor_total=0;
        $valor_total_items=0;
        $produtos = array();
        foreach($estoque as $item)
        {
            $valor_total = $item['valor']*$item['quantidade'];
            $item = array_replace($item, array('valor_total'=>$valor_total));
            array_push($produtos, $item);
            $valor_total_items = $valor_total_items + $valor_total;
        }
        $carrinho = array('valor_total_carrinho'=>$valor_total_items, 'produtos'=>$produtos);
        return $carrinho;
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
