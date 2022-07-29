<?php

$host = 'localhost';
$username = 'root';
$password = '';
$name = 'veiculosbd';

$conexao = mysqli_connect($host,$username,$password,$name);

if(!$conexao){
    die('Conexão falhou'. mysqli_connect_error());
}

?>