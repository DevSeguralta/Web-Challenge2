<?php

	include 'config.php';
	
	if(isset($_POST['cadastrar']))
	{
		
		//$marca = $_POST['marcaID'];
		$marca = '1';
		$veiculo = $_POST['veiculo'];
        $ano = $_POST['ano'];
		$modelo = $_POST['modelo'];
		$descricao = $_POST['descricao'];
		$vendido = $_POST['vendido'] ? '1' : '0';
		$dataCriacao = 'sysdate()';
		$dataVenda = $vendido ? 'sysdate()' : '';
		
		$sql = "INSERT INTO veiculos(marcaID,veiculo,ano,modelo,descricao,vendido,dataCriacao) 
					 VALUES ('$marca','$veiculo','$ano','$modelo','$descricao', 1, sysdate())";
		
		$query = $conexao->query($sql);
	}
	
	
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];

		$sql = "SELECT v.*, m.nome marca
			      FROM veiculos v
			 LEFT JOIN marcas m
					ON v.marcaID = m.id
				 WHERE v.dataExclusao IS NULL
				   AND v.id = '$id'";
				   
		$query = $conexao->query($sql);
		
		
		if($query->num_rows == 1)
		{
			$veiculo = mysqli_fetch_assoc($query);

			$res = [
				'data' => $veiculo
			];
			echo json_encode($res);
			return;
		}
		else
		{
			exit('Veículo não encontrado.')
		}
	}
	
	if(isset($_POST['editar']))
	{
		
		//$marca = $_POST['marcaID'];
		$id = $_POST['id'];
		$marca = '1';
		$veiculo = $_POST['veiculo'];
        $ano = $_POST['ano'];
		$modelo = $_POST['modelo'];
		$descricao = $_POST['descricao'];
		$vendido = $_POST['vendido'] ? '1' : '0';
		$dataCriacao = 'sysdate()';
		$dataVenda = $vendido ? 'sysdate()' : '';
		
		$sql = "UPDATE veiculos SET
					   marcaID = '$marca',
					   veiculo = '$veiculo',
					   ano = '$ano',
					   modelo = '$modelo',
					   descricao = '$descricao'
					   dataAtualizacao = sysdate()
				 WHERE id = '$id'";
		
		$query = $conexao->query($sql);
	}
	
	if(isset($_POST['deletar']))
	{
		$id = $_POST['id'];

		$sql = "UPDATE veiculos SET 
					   dataExclusao = sysdate() 
				 WHERE id='$id'";
				   
		$query = $conexao->query($sql);
	}

?>