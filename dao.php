<?php

require 'config.php';

if(isset($_POST['cadastrar'])) {
    $veiculo = mysqli_real_escape_string($conexao, $_POST['veiculo']);
    $ano = mysqli_real_escape_string($conexao, $_POST['ano']);
    $modelo = mysqli_real_escape_string($conexao, $_POST['modelo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    if($veiculo == NULL || $ano == NULL || $modelo == NULL || $descricao == NULL)
    {
        $res = [
            'status' => 1,
            'message' => 'Todos os campos são obrigatórios'
        ];
        echo json_encode($res);
        return;
    }

    $sql = "INSERT INTO veiculos(veiculo,ano,modelo,descricao,dataCriacao) 
				   VALUES ('$veiculo','$ano','$modelo','$descricao', sysdate())";
    $query = mysqli_query($conexao, $sql);

    if($query)
    {
        $res = [
            'status' => 2,
            'message' => 'Veículo cadastrado com sucesso.'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 3,
            'message' => 'Erro ao cadastrar.'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['editar'])) {
    $id = mysqli_real_escape_string($conexao, $_POST['id']);
    $veiculo = mysqli_real_escape_string($conexao, $_POST['veiculo']);
    $ano = mysqli_real_escape_string($conexao, $_POST['ano']);
    $modelo = mysqli_real_escape_string($conexao, $_POST['modelo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    if($veiculo == NULL || $ano == NULL || $modelo == NULL || $descricao == NULL)
    {
        $res = [
            'status' => 1,
            'message' => 'Todos os campos são obrigatórios'
        ];
        echo json_encode($res);
        return;
    }

    $sql = "UPDATE veiculos SET
					 veiculo = '$veiculo',
					 ano = '$ano',
					 modelo = '$modelo',
					 descricao = '$descricao',
					 dataAtualizacao = sysdate()
			   WHERE id = '$id'";
    $query = mysqli_query($conexao, $sql);

    if($query)
    {
        $res = [
            'status' => 2,
            'message' => 'Veículo editado com sucesso.'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 3,
            'message' => 'Erro ao editar.'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexao, $_GET['id']);

    $sql = "SELECT * FROM veiculos WHERE id='$id'";
    $query = mysqli_query($conexao, $sql);

    if(mysqli_num_rows($query) == 1)
    {
        $veiculo = mysqli_fetch_array($query);

        $res = [
            'data' => $veiculo
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'message' => 'Veículo não encontrado.'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['deletar'])) {
    $id = mysqli_real_escape_string($conexao, $_POST['id']);

    $sql = "UPDATE veiculos SET 
					 dataExclusao = sysdate() 
				 WHERE id='$id'";
    $query = mysqli_query($conexao, $sql);

    if($query)
    {
        $res = [
            'status' => 1,
            'message' => 'Veículo deletado com sucesso.'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 2,
            'message' => 'Erro ao deletar.'
        ];
        echo json_encode($res);
        return;
    }
}

?>