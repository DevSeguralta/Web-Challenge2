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
				 WHERE v.veiculo LIKE '$filtro%' 
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
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
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
		<button type="button" data-bs-toggle="modal" data-bs-target="#modalCadastrar"><i class="bi bi-plus-circle-fill"></i></button>
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
								<button type='button' value='".$veiculo['id']."' class='editarBtn btn btn-sm btn-primary'><i class='bi bi-pencil'></i></button>
								<button type='button' value='".$veiculo['id']."' class='deletarBtn btn btn-sm btn-danger'><i class='bi bi-trash3'></i></button>
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
	
	<div class="modal fade" id="modalCadastrar" tabindex="-1" aria-labelledby="modalCadastrar" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="modalTitle">Novo Veículo</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <form id="cadastrar">	
		  <div class="modal-body">
			  <div id="errorMessage" class="alert alert-warning d-none"></div>
			  <div class="mb-3">
				<label for="veiculo" class="col-form-label">Veículo</label>
				<input class="inputModal" id="veiculoadd" name='veiculo' maxlength="150"></input>
			  </div>
			  <div class="mb-3">
				<label for="ano" class="col-form-label">Ano</label>
				<input type="text" class="inputModal" id="anoadd" name='ano' maxlength="4"></input>
			  </div>
			  <div class="mb-3">
				<label for="modelo" class="col-form-label">Modelo</label>
				<input type="text" class="inputModal" id="modeloadd" name='modelo' maxlength="4"></input>
			  </div>
			  <div class="mb-3 ml-3 form-check form-switch">
				<input class="form-check-input" type="checkbox" id="vendidoadd" name='vendido'>
				<label class="form-check-label" for="vendido">Vendido</label>
			  </div>
			  <div class="">
				<label for="descricao" class="col-form-label">Descrição</label>
				<textarea class="inputModal" id="descricaoadd" maxlength="65535" name='descricao'></textarea>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	</form>
	
	<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="modalTitle">Editar Veículo</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <form id="editar">	
		  <div class="modal-body">
			  <div id="errorMessage" class="alert alert-warning d-none"></div>
			  
			  <input type="hidden" name="id" id="ided" >
			  <div class="mb-3">
				<label for="veiculo" class="col-form-label">Veículo</label>
				<input class="inputModal" id="veiculoed" name='veiculo' maxlength="150"></input>
			  </div>
			  <div class="mb-3">
				<label for="ano" class="col-form-label">Ano</label>
				<input type="text" class="inputModal" id="anoed" name='ano' maxlength="4"></input>
			  </div>
			  <div class="mb-3">
				<label for="modelo" class="col-form-label">Modelo</label>
				<input type="text" class="inputModal" id="modeloed" name='modelo' maxlength="4"></input>
			  </div>
			  <div class="mb-3 ml-3 form-check form-switch">
				<input class="form-check-input" type="checkbox" id="vendidoed" name='vendido'>
				<label class="form-check-label" for="vendido">Vendido</label>
			  </div>
			  <div class="">
				<label for="descricao" class="col-form-label">Descrição</label>
				<textarea class="inputModal" id="descricaoed" maxlength="65535" name='descricao'></textarea>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.min.js" integrity="sha512-ewfXo9Gq53e1q1+WDTjaHAGZ8UvCWq0eXONhwDuIoaH8xz2r96uoAYaQCm1oQhnBfRXrvJztNXFsTloJfgbL5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
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
	
	$(document).on('submit', '#cadastrar', function (e) {
		e.preventDefault();

		var data = {
			cadastrar: true,
			veiculo: $("#veiculoadd").val(),
			ano: $("#anoadd").val(),
			modelo: $("#modeloadd").val(),
			descricao: $("#descricaoadd").val(),
			vendido: $("#vendidoadd").val(),
		}
		
		$.ajax({
			type: "post",
			url: "dao.php",
			data: data,
			success: function () {
				$('#modalCadastrar').modal('hide');
				$('#cadastrar')[0].reset();

				alertify.set('notifier','position', 'top-right');
				alertify.success('Salvo com sucesso.');

				//window.location = 'index.php';
			}
		});
			
    });
		
		
		
	$(document).on('click', '.editarBtn', function () {

		var id = $(this).val();
		
		$.ajax({
			type: "GET",
			url: "dao.php?id=" + id,
			success: function (response) {
				var res = jQuery.parseJSON(response);
				
				$('#ided').val(res.data.id);
				$('#veiculoed').val(res.data.veiculo);
				$('#anoed').val(res.data.ano);
				$('#modeloed').val(res.data.modelo);
				$('#descricaoed').val(res.data.descricao);
				$('#vendidoed').val(res.data.vendido);
					
				$('#modalEditar').modal('show');
			}
		});
	});
	
	$(document).on('submit', '#editar', function (e) {
		e.preventDefault();

		var data = {
			editar: true,
			id: $("#ided").val(),
			veiculo: $("#veiculoed").val(),
			ano: $("#anoed").val(),
			modelo: $("#modeloed").val(),
			descricao: $("#descricaoed").val(),
			vendido: $("#vendidoed").val(),
		}
		
		$.ajax({
			type: "post",
			url: "dao.php",
			data: data,
			success: function () {
				$('#modalEditar').modal('hide');
				$('#editar')[0].reset();

				alertify.set('notifier','position', 'top-right');
				alertify.success('Salvo com sucesso.');

				//window.location = 'index.php';
			}
		});
			
    });
		
	$(document).on('click', '.deletarBtn', function (e) {
		e.preventDefault();

		if(confirm('Você tem certeza que quer deletar esse registro?'))
		{
			var id = $(this).val();
			$.ajax({
				type: "POST",
				url: "dao.php",
				data: {
					'deletar': true,
					'id': id
				},
				success: function () {
					alertify.set('notifier','position', 'top-right');
					alertify.success('Excluído com sucesso.');
					
					//window.location = 'index.php';
				}
			});
		}
	});
	
	
	
	
  </script>
</body>
</html>