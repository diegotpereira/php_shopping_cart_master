<?php
// Incluir o arquivo de configuração do banco de dados
require_once 'dbConfig.php';

// Inicializar carringo de compras
include_once 'Carrinho.class.php';
$carrinho = new Carrinho;

// Se o carrinho estiver vazio, redirecione para a página de produtos

if ($carrinho->total_itens() <= 0) {
    # code...
    header("Location: index.php");
}

// Obtenha os dados postados da sessão
$postData = !empty($_SESSION['postData']) ? $_SESSION['postData'] : array();
unset($_SESSION['postData']);

//Obter mensagem de status da sessão
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';
if (!empty($sessData['status']['msg'])) {
    # code...
    $statusMsg = $sessData['status']['type'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Verificar</title>
    <meta charset="utf-8">

    <!-- Bootstrap core css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo Personalizado -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Verificar</h1>
        <div class="col-12">
            <div class="verificar">
                <div class="row">
                    <?php if (!empty($statusMsg) && ($statusMsgType == 'sucesso')) { ?>
                        # code...
                        <div class="col-md-12">
                            <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                        </div>
                    <?php } ?>

                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Suas Compras</span>
                            <span class="badge badge-secondary badge-pill"><?php echo $carrinho->total_itens(); ?></span>
                        </h4>

                        <ul class="list-group md-3">
                            <?php
                            if ($carrinho->total_itens() > 0) {
                                # code...
                                // obter itens do carrinho da sessão
                                $carrinhoItens = $carrinho->contents();

                                foreach ($carrinhoItens as $item) {
                                    # code...
                            ?>

                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><?php echo $item["nome"]; ?></h6>
                                            <small class="text-muted"><?php echo 'R$' . $item['preco']; ?>
                                                (<?php echo $item["qtd"]; ?>)
                                            </small>
                                        </div>
                                    </li>
                            <?php }
                            } ?>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (R$)</span>
                                <strong><?php echo 'R$' . $carrinho->total(); ?></strong>
                            </li>
                        </ul>
                        <a href="index.php" class="btn btn-block btn-info">Novo Itens</a>
                    </div>

                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Detalhes Do Contato</h4>
                        <form method="POST" action="CarrinhoAcao.php">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?php echo !empty($postData['nome']) ? $postData['nome'] : ''; ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sobrenome">Sobrenome</label>
                                    <input type="text" class="form-control" name="sobrenome" value="<?php echo !empty($postData['sobrenome']) ? $postData['sobrenome'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" name="email" value="<?php echo !empty($postData['email']) ? $postData['email'] : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control" name="telefone" value="<?php echo !empty($postData['telefone']) ? $postData['telefone'] : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" name="endereco" value="<?php echo !empty($postData['endereco']) ? $postData['endereco'] : ''; ?>" required>
                            </div>

                            <input type="hidden" name="action" value="placeOrder" />
                            <input class="btn btn-success btn-lg btn-block" type="submit" name="checkoutSubmit" value="Ordem de Pedidos">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>