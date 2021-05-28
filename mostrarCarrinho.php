<?php
//Inicializar a classe do carrinho de compras
include_once 'Carrinho.class.php';
$carrinho = new Carrinho;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title> Mostrar Carrinho</title>
    <meta charset="utf-8">

    <!-- Bootstrap core css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo personalizado -->
    <link href="css/style.css" rel="stylesheet">

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <script>
        function alterarCarrinhoItem(obj, id) {
            $.get("CarrinhoAcao.php", {
                action: "alterarCarrinhoItem",
                id: id,
                qtd: obj.value
            }, function(data) {
                if (data == 'ok') {
                    location.reload();
                } else {
                    alert('Alteração no carrinho falhou, por tente novamente.');
                }
            });
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Carrinho de Compras</h1>
        <div class="row">
            <div class="cart">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                    <th width="45%">Produto</th>
                                    <th width="10%">Preço</th>
                                    <th width="15%">Quantidade</th>
                                    <th class="text-right" width="20%">Total</th>
                                    <th width="10%"></th>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if ($carrinho->total_itens() > 0) {
                                    # code...
                                    // Pegue os itens do carrinho da sessão
                                    $carrinhoItens = $carrinho->contents();

                                    foreach ($carrinhoItens as $item) {
                                        # code...
                                ?>

                                        <tr>
                                            <td><?php echo $item["nome"]; ?></td>
                                            <td><?php echo 'R$' . $item["preco"] . ''; ?></td>
                                            <td><input class="form-control" type="number" value="<?php echo $item["qtd"]; ?>" onchange="alterarCarrinhoItem(this, '<?php echo $item["rowid"]; ?>')" /></td>
                                            <td class="text-right"><?php echo 'R$'.$item["subtotal"].''; ?></td>
                                            <td class="text-right"><button class="btn btn-sm btn-danger" onclick="return confirm ('Tem Certeza?')?window.location.href='carrinhoAcao.php?action=removeCarrinhoItem&id=<?php echo $item["rowid"]; ?>':false;" <i class="itrash"></i> </button> </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    
                                    <tr>
                                        <td colspan="5">
                                            <p>Seu carrinho está vazio...</p>
                                        </td>
                                    <?php } ?>
                                    <?php if ($carrinho->total_itens() > 0) { ?>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total Carrinho</strong></td>
                                        <td class="text-right"><strong><?php echo '$' . $carrinho->total() . ' USD'; ?></strong></td>

                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col mb-2">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <a href="index.php" class="btn btn-block btn-light">Continuar Compras</a>
                        </div>

                        <div class="col-sm-12 col-md-6 text-right">
                            <?php if ($carrinho->total_itens() > 0) { ?>
                                
                                <a href="verificar.php" class="btn btn-lg btn-block btn-primary">Confirmar</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>