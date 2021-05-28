<?php
// Configuração do banco de dados

$dbHost = "localhost";
$dbUsuario = "root";
$dbSenha = "root";
$dbNome = "php_shopping_cart_master";

// Conexão com banco de dados;
$db = new mysqli($dbHost, $dbUsuario, $dbSenha, $dbNome);

// checar a conexão
if ($db->connect_error) {
    # code...
    die("Falha na Conexão: " . $db->connect_error);
}

?>