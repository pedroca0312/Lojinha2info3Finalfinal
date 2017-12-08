<?php


require_once "Conexao.php";
require_once "Produto.php";

class CrudProdutos {

    private $conexao;
    public $produto;

    public function __construct() {
        $this->conexao = Conexao::getConexao();
    }

    public function salvar(Produto $produto){

        $this->conexao->exec("INSERT INTO tb_produtos (`nome`,`categoria`,`preco`,`estoque`) VALUES('$produto->nome', '$produto->categoria', $produto->preco, $produto->estoque)");

    }

    public function editar(Produto $produto){



        $this->conexao->exec("UPDATE tb_produtos SET nome='$produto->nome',preco=$produto->preco,categoria='$produto->categoria',estoque=$produto->estoque WHERE id = $produto->id");
    }

    public function comprar($id,$quantidadeDesejada){

        $produto = $this->getProduto($id);

        if ($quantidadeDesejada > $produto->estoque){
            $estoqueAtualizado = $produto->estoque;
        } else {
            $estoqueAtualizado = $produto->estoque - $quantidadeDesejada;
        }

        $this->conexao->exec("UPDATE tb_produtos SET estoque = $estoqueAtualizado WHERE id = $id");
    }

    public function getProduto(int $id){
        $consulta = $this->conexao->query("SELECT * FROM tb_produtos WHERE id = $id");
        $produto = $consulta->fetch(PDO::FETCH_ASSOC);

        return new Produto($produto['nome'], $produto['preco'], $produto['categoria'],$produto['estoque'],$produto['id']);

    }

    public function getProdutos(){
        $consulta = $this->conexao->query("SELECT * FROM tb_produtos");
        $arrayProdutos = $consulta->fetchAll(PDO::FETCH_ASSOC);


        $listaProdutos = [];
        foreach ($arrayProdutos as $produto){
            $listaProdutos[] = new Produto($produto['nome'], $produto['preco'], $produto['categoria'],$produto['estoque'],$produto['id']);
        }

        return $listaProdutos;

    }

    public function excluir($id){

        $this->conexao->exec("DELETE FROM tb_produtos WHERE id = $id");

    }
}
