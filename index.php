<?php
//Inicializar a classe do carrinho de compras
include_once 'Carrinho.class.php';
$carrinho = new Carrinho;

//Incluir o arquivo de configuração do banco de dados
require_once 'dbConfig';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>PHP Carrinho de Compras</title>

<meta charset="utf-8">

<!-- Bootstrap core css -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Estilo personalizado -->
<link href="css/style.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <h1>Produtos</h1>

    <!-- Cesta do carrinho --> 
    <div class="carrinho-mostrar">
        <a href="mostrarCarrinho.php" title="Mostrar Carrinho"><i class="iCarrinho"></i>(<?php echo ($cart->total_items() > 0)?$cart->total_items().' Items':'Empty'; ?>)</a>
    </div>

    <!-- Lista de Produtos -->
    <div class="row col-lg-12">
       <?php
       //Obtenha produtos do banco de dados
       $result = $db->query("SELECT * FROM produtos ORDER BY id DESC LIMIT 10");

       if (result->num_rows > 0) {
           # code...
           while($row = result->fetch_assoc()){
        ?>

        <div class="card -col-lg-4">
           <div class="card-body">
               <h5 class="card-title"><?php echo $row['nome'];?></h5>
               <h6 class="card-subtitle mb-2 text-muted">Preço: <?php echo '$' .$row["preco"].' USD'; ?></h6>
               <p class="card-text"><?php echo $row["descricao"]; ?></p>
               <a href="carrinhoAcao.php?action=adicionarNoCarrinho&id=<?php echo $row["id"]; ?>" class="btn btn-primary">Adicionar no Carrinho</a>
           </div>
        </div>
        <?php }}else { ?>
            # code...
            <p>Produto(s) não encontrado...</p>
        <?php } ?>
    </div>
</div>
</body>
</html>