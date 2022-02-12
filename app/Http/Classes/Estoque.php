<?php
namespace App\Http\Classes;

class estoque
{
    private $produtos=array();

    public function __construct()
    {
        array_push($this->produtos, ['id'=>1, 'descricao'=>'Bola de Futebol', 'quantidade'=>2, 'valor'=>40.0, 'estoque'=>200]);
        array_push($this->produtos,  ['id'=>2, 'descricao'=>'Mesa Lazer', 'quantidade'=>4, 'valor'=>200.0, 'estoque'=>10]);
        array_push($this->produtos, ['id'=>3, 'descricao'=>'Violão Nylon', 'quantidade'=>1, 'valor'=>1000.0, 'estoque'=>1]);
    }
    public function getEstoque():array
    {
        return $this->produtos;
    }

    public function updateProduto($id)
    {
        foreach($this->produtos as $key=>$item)
        {
            if($item['id']==$id)
            {
                $novo_estoque = $item['estoque']-$item['quantidade'];
                $this->produtos[$key] = array_replace($this->produtos[$key], array('estoque'=>$novo_estoque));
            }
        }
    }
}
