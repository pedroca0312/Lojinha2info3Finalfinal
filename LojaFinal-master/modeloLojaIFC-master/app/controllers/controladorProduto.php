<?php

    require_once "../models/Produto.php";
    require_once "../models/CrudProdutos.php";

if ( $_GET['acao'] == 'cadastrar'){

    $produto = new Produto($_POST['nome'], $_POST['preco'], $_POST['categoria'],$_POST['estoque']);
    $crud = new CrudProdutos();
    $crud->salvar($produto);

    header('location: ../views/admin/produtos.php');

}

if ($_GET['acao'] == 'editar'){

        $produto = new Produto($_POST['nome'], $_POST['preco'], $_POST['categoria'],$_POST['estoque'],$_POST['id']);
        $crud = new CrudProdutos();
        $crud->editar($produto);

        header('location: ../views/admin/produtos.php');
}

if ( $_GET['acao'] == 'excluir') {

    $crud = new CrudProdutos();
    $crud->excluir($_GET['id']);

    header("location: ../views/admin/produtos.php");

}
if ( $_GET['acao'] == 'comprar') {

    $crud = new CrudProdutos();
    $crud->comprar($_POST['id'],$_POST['quantidade']);

    header("location: ../views/produto.php?msg=compra com sucesso&codigo=$_POST[id]");

}