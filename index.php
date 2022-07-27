<?php
    include_once('config.php');
	
	//read
    if(!empty($_GET['search']))
    {
        $filtro = $_GET['search'];
        $sql = "SELECT v.*, m.nome marca 
			      FROM veiculos v
			 LEFT JOIN marcas m
					ON v.marcaID = m.id
				 WHERE veiculo LIKE '$filtro%' 
				   AND v.dataExclusao IS NULL
		      ORDER BY 1 DESC";
    }
    else
    {
        $sql = "SELECT v.*, m.nome marca
				  FROM veiculos v 
			 LEFT JOIN marcas m
					ON v.marcaID = m.id
				 WHERE v.dataExclusao IS NULL
			  ORDER BY 1 DESC";
    }
    $result = $conexao->query($sql);
	
	//create
	if(isset($_POST['submit']))
    {
        
        $marcaID = $_POST['marcaID'];
		$veiculo = $_POST['veiculo'];
        $ano = $_POST['ano'];
		$modelo = $_POST['modelo'];
		$descricao = $_POST['descricao'];
		$vendido = $_POST['vendido'] ? 1 : 0;
		$dataCriacao = 'sysdate()';
		$dataVenda = $vendido ? 'sysdate()' : '';

        $sql = "INSERT INTO veiculos(marcaID,veiculo,ano,modelo,descricao,vendido, dataCriacao,dataVenda) 
        VALUES ('$marcaID','$veiculo','$ano','$modelo','$descricao','$vendido', '$dataCriacao','$dataVenda')";
		
		$conexao->query($sql);
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="style.css">

    <title>Web-Challenge2</title>
  </head>
  <body>
    <nav class="navbar">
	  <div class="container-fluid">
		<p class="navbar-title">
		  <i class="bi bi-droplet"></i>
			FULLSTACK
		</p>
		<input type="search" placeholder="Busca por um veiculo" id="pesquisar">
	  </div>
	</nav>
	<br>
	<div class="title">
		<h4>VEÍCULO</h4>
		<button data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-circle-fill"></i></button>
	</div>
	<div class="m-5">
        <table class="table table-bg">
            <thead>
                <tr>
                    <th scope="col">Veículo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Ano</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Vendido</th>
					<th scope="col">Descrição</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
					if($result->num_rows > 0){
						while($veiculo = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>".$veiculo['veiculo']."</td>";
							echo "<td>".$veiculo['marca']."</td>";
							echo "<td>".$veiculo['ano']."</td>";
							echo "<td>".$veiculo['modelo']."</td>";
							echo "<td>".$veiculo['vendido']."</td>";
							echo "<td>".$veiculo['descricao']."</td>";
							echo "<td>
							<a class='btn btn-sm btn-primary' href='index.php?id=$veiculo[id]' title='Editar'>
								<i class='bi bi-pencil'></i>
								</a> 
								<a class='btn btn-sm btn-danger' href='index.php?id=$veiculo[id]' title='Deletar'>
									<i class='bi bi-trash3'></i>
								</a>
								</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr>";
                        echo "<td>Nenhum veículo encontrado.</td>";
						echo "</tr>";
					}
                    ?>
            </tbody>
        </table>
    </div>
	<form action="index.php" method="POST">	
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="modalCadastrar" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="modalCadastrar">Novo Veículo</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
					  
			  <div class="mb-3">
				<label for="veiculo-text" class="col-form-label">Veículo</label>
				<input class="inputModal" id="veiculo-text" maxlength="150"></input>
			  </div>
			  <div class="mb-3">
				<label for="ano-text" class="col-form-label">Ano</label>
				<input type="text" class="inputModal" id="ano-text" maxlength="4"></input>
			  </div>
			  <div class="mb-3">
				<label for="modelo-text" class="col-form-label">Modelo</label>
				<input type="text" class="inputModal" id="modelo-text" maxlength="4"></input>
			  </div>
			  <div class="mb-3 form-check form-switch">
				<input class="form-check-input" type="checkbox" id="vendido-checkbox">
				<label class="form-check-label" for="vendido-checkbox">Vendido</label>
			  </div>
			  <div class="">
				<label for="descricao-text" class="col-form-label">Descrição</label>
				<textarea class="inputModal" id="descricao-text" maxlength="65535"></textarea>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		  </div>
		  
		</div>
	  </div>
	</div>
	</form>
  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.min.js" integrity="sha512-ewfXo9Gq53e1q1+WDTjaHAGZ8UvCWq0eXONhwDuIoaH8xz2r96uoAYaQCm1oQhnBfRXrvJztNXFsTloJfgbL5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
	var busca = document.getElementById('pesquisar');

	busca.addEventListener("keydown", function(event) {
		if (event.key === "Enter") 
		{
			searchData();
		}
	});

	function searchData()
	{
		window.location = 'index.php?search='+busca.value;
	}
	
	const modalCadastrar = document.getElementById('modalCadastrar')
		modalCadastrar.addEventListener('show.bs.modal', event => {
		  const button = event.relatedTarget
		  //const recipient = button.getAttribute('data-bs-whatever')
		  //const modalTitle = exampleModal.querySelector('.modal-title')
		  //const modalBodyInput = exampleModal.querySelector('.modal-body input')

		  //modalTitle.textContent = `New message to ${recipient}`
		  //modalBodyInput.value = recipient
		})
  </script>
</html>