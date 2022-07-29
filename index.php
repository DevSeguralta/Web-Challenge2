<?php
    include_once('config.php');
	
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
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
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
	<button type="button" data-bs-toggle="modal" data-bs-target="#modalCadastrar"><i class="bi bi-plus-circle-fill"></i></button>
</div>
<div class="m-5">
	<table id="table" class="table table-bg">
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
	<button type='button' id="limparBusca" class='limparBusca btn btn-default'>Limpar busca</button>
</div>


<div class="modal fade" id="modalCadastrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Novo Veículo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="cadastrar">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>

                <div class="mb-3">
                    <label for="">Veículo</label>
                    <input type="text" name="veiculo" class="inputModal" maxlength="150"/>
                </div>
                <div class="mb-3">
                    <label for="">Ano</label>
                    <input type="text" name="ano" class="inputModal" maxlength="4"/>
                </div>
                <div class="mb-3">
                    <label for="">Modelo</label>
                    <input type="text" name="modelo" class="inputModal" maxlength="4"/>
                </div>
                <div class="mb-3">
                    <label for="">Descrição</label>
                    <textarea type="text" name="descricao" class="inputModal" maxlength="65535"></textarea>
                </div>
            </div>
            <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Veículo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editar">
            <div class="modal-body">

                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                <input type="hidden" name="id" id="id" >

                <div class="mb-3">
                    <label for="">Veículo</label>
                    <input type="text" name="veiculo" id="veiculo" class="inputModal" maxlength="150"/>
                </div>
                <div class="mb-3">
                    <label for="">Ano</label>
                    <input type="text" name="ano" id="ano" class="inputModal" maxlength="4"/>
                </div>
                <div class="mb-3">
                    <label for="">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="inputModal" maxlength="4"/>
                </div>
                <div class="mb-3">
                    <label for="">Descrição</label>
                    <textarea type="text" name="descricao" id="descricao" class="inputModal" maxlength="65535"></textarea>
                </div>
            </div>
            <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </form>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
	
		var busca = document.getElementById('pesquisar');

		busca.addEventListener("keydown", function(event) {
			if (event.key === "Enter") 
			{
				searchData();
			}
		});

		function searchData() {
			window.location = 'index.php?search='+busca.value;
		}
	
        $(document).on('submit', '#cadastrar', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("cadastrar", true);

            $.ajax({
                type: "POST",
                url: "dao.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if(res.status == 1) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);

                    }else if(res.status == 2){

                        $('#errorMessage').addClass('d-none');
                        $('#modalCadastrar').modal('hide');
                        $('#cadastrar')[0].reset();
						
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);

                        $('#table').load(location.href + " #table");
						

                    }else if(res.status == 3) {
                        alert(res.message);
                    }
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
                    if(res.message) {
                        alert(res.message);
                    }else if(res.data){
                        $('#id').val(res.data.id);
                        $('#veiculo').val(res.data.veiculo);
                        $('#ano').val(res.data.ano);
                        $('#modelo').val(res.data.modelo);
                        $('#descricao').val(res.data.descricao);

                        $('#modalEditar').modal('show');
                    }
                }
            });

        });

        $(document).on('submit', '#editar', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("editar", true);

            $.ajax({
                type: "POST",
                url: "dao.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if(res.status == 1) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    }else if(res.status == 2){
                        $('#errorMessageUpdate').addClass('d-none');

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        
                        $('#modalEditar').modal('hide');
                        $('#editar')[0].reset();

                        $('#table').load(location.href + " #table");
                    }else if(res.status == 3) {
                        alert(res.message);
                    }
                }
            });
        });

        $(document).on('click', '.deletarBtn', function (e) {
            e.preventDefault();

            if(confirm('Você quer mesmo deletar esse veículo?'))
            {
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "dao.php",
                    data: {
                        'deletar': true,
                        'id': id
                    },
                    success: function (response) {
                        var res = jQuery.parseJSON(response);
                        if(res.status == 2) {
                            alert(res.message);
                        }else{
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(res.message);

                            $('#table').load(location.href + " #table");
                        }
                    }
                });
            }
        });
		
		$(document).on('click', '.limparBusca', function () {
			reload();
		});
		
		function reload(){
			window.location = 'index.php';
		}

    </script>

</body>
</html>
