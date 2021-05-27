<?php

// inicialização da classe carrinho
require_once 'Carrinho.class.php';
$carrinho = new Carrinho;

// Incluir o arquivo de configuração do banco de dados
require_once 'dbConfig.php';

// Página de redirecionamento padrão
$redirectLoc = 'index.php';

// Solicitação de processo com base na ação especificada
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    # code...
    if ($_REQUEST['action'] == 'addParaCarrinho' && !empty($_REQUEST['id'])) {
        # code...
        $produtoID = $_REQUEST['id'];

        // buscar detalhes do produto
        $query = $db->query("SELECT * FROM produtos WHERE id = ".$produtoID);
        $row = $query->fetch_assoc();

        $itemData = array(
            'id'    => $row['id'],
            'nome'  => $row['nome'],
            'preco' => $row['preco'],
            'qtd'   => 1
        );

        // inserir item no carrinho
        $inserirItem = $carrinho->insert($itemData);

        // redirecionar para página do carrinho
        $redirectLoc = $inserirItem?'mostrarCarrinho.php':'index.php';
    }elseif ($_REQUEST['action'] == 'atualizarCarrinhoItem' && !empty($_REQUEST['id']) ) {
        # code...
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qtd'   => $_REQUEST['qtd']
        );
        $atualizarItem = $carrinho->update($itemData);

        // retornar Status
        echo $atualizarItem?'ok':'err';die;
    }elseif ($_REQUEST['action'] == 'removerCarrinhoItem' && !empty($_REQUEST['id'])) {
        # code...
        // remover item do carrinho
        $deletarItem = $carrinho->remove($_REQUEST['id']);

        // redirecionar para página do carrinho
        $redirectLoc = 'mostrarCarrinho.php';
    }elseif ($_REQUEST['action'] == 'encomendaPedido' && $carrinho->total_items() > 0) {
        # code...
        $redirectLoc = 'checkout.php';

        // Armazenar dados de postagem
        $_SESSION['postData'] = $_POST;

        $nome =      strip_tags($_POST['nome']);
        $sobrenome = strip_tags($_POST['sobrenome']);
        $email =     strip_tags($_POST['email']);
        $telefone =  strip_tags($_POST['telefone']);
        $endereco =  strip_tags($_POST['endereco']);

        $errorMsg = '';

        if (empty($nome)) {
            # code...
            $errorMsg .= 'Por Favor entre com seu nome.<br/>';
        }

        if (empty($sobrenome)) {
            # code...
            $errorMsg .= 'Por favor entre com seu sobrenome.<br/>';
        }

        if (empty($email)) {
            # code...
            $errorMsg .= 'Por favor entre com seu email.<br/>';
        }

        if (empty($telefone)) {
            # code...
            $errorMsg .= 'Por favor entre com seu telefone.<br/>';
        }

        if (empty($endereco)) {
            # code...
            $errorMsg .= 'Por favor entre com seu endereço.<br/>';
        }
        // Insira os dados do cliente no banco de dados
        if (empty($errorMsg)) {
            # code...
            $insertClie = $db->query("INSERT INTO clientes(nome, sobrenome, email, telefone, endereco) VALUES ('".$nome."', '".$sobrenome."', '".$email."', '".$telefone."', '".$endereco."') ");

            if ($insertClie) {
                # code...
                $clieID = $db->insert_id;

                // Inserir informações do pedido no banco de dados

                if ($insertPedido) {
                    # code...
                    $pedidoID = $db->insert_id;

                    // Recuperar itens do carrinho
                    $carrinhoItems = $carrinho->contents();

                    // Prepare SQL para inserir itens de pedido
                    $sql = '';

                    foreach ($carrinhoItens as $item) {
                        # code...
                        $sql .= "INSERT INTO pedido_itens(pedido_id, produto_id, quantidade) VALUES ('".$pedidoID."', '".$item['id']."', '".$item['qtd']."'); ";

                        //Insira os itens do pedido no banco de dados
                        $insertPedidoItens = $db->multi_query($sql);

                        if ($insertPedidoItens) {
                            # code...
                            // Remova todos os itens do carrinho
                            $Carrinho->destroy();

                            // Redirecionar para a página de status
                            $redirectLoc = 'pedidoSucesso.php?id='.$pedidoID;
                        }else {
                            # code...
                            $sessData['status']['type'] = 'error';
                            $sessData['status']['msg'] = 'Algum problema ocorreu, por favor tente novamente.';
                        }
                    }else {
                        # code...
                        $sessData['status']['type'] = 'error';
                        $sessData['status']['msg'] = 'Algum problema ocorreu, por favor tente novamente.';
                    }
                }else {
                    # code...
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'Algum problema ocorreu, por favor tente novamente.';
                }
            }else {
                # code...
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Por favor, preencha todos os campos obrigatórios.<br>'.$errorMsg;
            }
            $_SESSION['sessData'] = $sessData;
        }
    }
    //Redirecionar para a página específica
    header("Location: $redirectLoc");
    exit();
}