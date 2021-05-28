<?php
if (!isset($_REQUEST['id'])) {
    # code...
    header("Location: index.php");
}

//Incluir o arquivo de configuração do banco de dados
require_once 'dbConfig.php';

//Buscar detalhes do pedido no banco de dados
$result = $db->query("SELECT r.*, c.nome, c.sobrenome, c.email, c.telefone FROM pedidos as r LEFT JOIN clientes as c ON c.id = r.cliente_id  WHERE r.id = ".$_REQUEST['id']);

if ($result->num_rows > 0) {
    # code...
    $pedidoInfo = $result->fetch_assoc();
} else {
    # code...
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Status do Pedido</title>
        <meta charset="utf-8">

        <!-- Bootstrap core css -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Estilo personalizado --> 
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <h1>Status Pedido</h1>
            <div class="col-12">
                <?php if(!empty($pedidoInfo)) { ?>
                    <div class="col-md-12">
                        <div class="alert alert-success">Seu pedido foi feito com sucesso.</div>
                    </div>

                    <!-- Status do pedido e informações de envio --> 
                    <div class="row col-lg-12 ord-addr-info">
                        <div class="hdr">Informação Pedido</div>
                        <p><b>Referência ID:</b> #<?php echo $pedidoInfo['id']; ?></p>
                        <p><b>Total:</b> <?php echo '$'.$pedidoInfo['total_geral'].'R$'; ?></p>
                        <p><b>Situação:</b> <?php echo $pedidoInfo['criado']; ?> </p>
                        <p><b>Nome do comprador:</b> <?php echo $pedidoInfo['nome'].''.$pedidoInfo['sobrenome']; ?></p>
                        <p><b>Email:</b> <?php echo $pedidoInfo['email']; ?></p>
                        <p><b>Telefone:</b> <?php echo $pedidoInfo['telefone']; ?></p>
                    </div>

                    <!-- Itens do Pedido --> 
                    <div class="row col-lg-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                //Obter itens de pedidos do banco de dados
                                $result = $db->query("SELECT i.*, p.nome, p.preco FROM pedido_itens as i LEFT JOIN produtos as p ON p.id = i.produto_id WHERE i.pedido_id = ".$pedidoInfo['id']);

                                if ($result->num_rows >0 ) {
                                    # code...
                                    while ($item = $result->fetch_assoc()) {
                                        # code...
                                        $preco = $item["preco"];
                                        $quantidade = $item["quantidade"];
                                        $sub_total = ($preco*quantidade);
                                ?>
                                <tr>
                                    <td><?php echo $item["nome"]; ?></td>
                                    <td><?php echo '$' .$preco. 'R$'; ?></td>
                                    <td><?php echo $quantidade; ?></td>
                                    <td><?php echo '$'.$sub_total.'R$'; ?></td>
                                </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } }else{ ?>
                    
                    <div class="col-md-12">
                        <div class="alert alert-danger">O envio do seu pedido falhou.</div>
                    </div>
                    <?php  } ?>
            </div>
        </div>
    </body>
</html>
