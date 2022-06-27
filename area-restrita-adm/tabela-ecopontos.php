<?php
    session_start();
    include_once("../session/valida-sentinela-adm.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/index-adm.css">
    <link rel="stylesheet" href="../css/adm-formatacao.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/form-pesquisa-adm.css">

	<title>Tabela - Cidade Limpa</title>
    <link rel="shortcut icon" href="../imagens/reciclagem.png" type="image/x-icon">
</head>

	<body>
        <!-- SIDEBAR -->
        <section id="sidebar">
                <a href="index-adm-restrita.php" class="brand"><i class='bx bxs-map icon'></i>Cidade Limpa</a>
                    <ul class="side-menu">
                        <li class="divider" data-text="Principal">Principal</li>
                        <li><a href="index-adm-restrita.php"><i class='bx bxs-chart icon' ></i> Gráficos</a></li>
                        <li class="divider" data-text="Tabelas e Formulários">Listas e Formulários</li> 
                        <li>
                            <a href="#"><i class='bx bx-message-x icon' ></i> Denúncias <i class='bx bx-chevron-right icon-right' ></i></a>
                            <ul class="side-dropdown">
                                <li><a href="tabela-denuncia.php">Lista Denúncias</a></li>
                                <li><a href="tabela-denuncias-regiao.php">Denúncias por Região</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class='bx bx-user icon' ></i> Usuário <i class='bx bx-chevron-right icon-right' ></i></a>
                            <ul class="side-dropdown">
                                <li><a href="tabela-usuario.php">Lista Usuários</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class='bx bxs-notepad icon' ></i> Ecopontos <i class='bx bx-chevron-right icon-right' ></i></a>
                            <ul class="side-dropdown">
                                <li><a href="tabela-ecopontos.php">Lista Ecopontos</a></li>
                                <li><a href="./cadastro-ecoponto.php">Cadastrar EcoPonto</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class='bx bxs-spreadsheet icon' ></i> Categoria de denúncias <i class='bx bx-chevron-right icon-right' ></i></a>
                            <ul class="side-dropdown">
                                <li><a href="cadastro-categoria.php">Cadastrar Categoria</a></li>
                            </ul>
                        </li>
                    </ul>

		</section>
		<!-- SIDEBAR -->

		<!-- NAVBAR -->
		<section id="content">
			<!-- NAVBAR -->
			<nav>
				<i class='bx bx-menu toggle-sidebar' ></i>
				<form action="#">
				</form>
				<span class="divider"></span>
				<div class="profile">
					<img src="../imagens/sair-adm.png" alt="">
					<ul class="profile-link">
						<li><a href="../session/logout-adm.php"><i class='bx bxs-log-out-circle' ></i> Sair</a></li>
					</ul>
				</div>
			</nav>
       
        <div>
            <?php 
                require_once("../classe/Adm.php");
                $adm = new Adm();
                $contar = $adm->tabelaEcopontoContar();
                foreach($contar as $ecopontoNum){}
            ?>
            <h1>TABELA DE ECOPONTOS</h1>
            <div><br> 
            <h1 style="color: #064018;">Número de Ecopontos: <?php echo $ecopontoNum[0]; ?> </h1>
            <hr>

            <br><br>
            <!-- Form Para pesquisar Denúncias -->
            <form method="POST" id="form-pesquisa" action="" >
                    <div class="div-pesquisa-usuario">
                        <input type="text" class="form-control" style="margin-top:10px;width: 250px; height:40px;" name="pesquisa" id="pesquisa" placeholder="Digite a Denúncia">
                        <input type="submit" value="Pesquisar" class="btn btn-secondary btn-pesquisa">
                        <a href="pdfs/pdf-table-ecoponto.php" class="btn btn-secondary btn-pesquisa" target="_blank">Vizualizar Pdf</a>
                    </div>
                </form>

            </div>
            </div>
        
            
        </div>


        <table class="table table-striped table-hover">
            <tr>
                <th>id</th>
                <th>Uf</th>
                <th>Logradouro</th>
                <th>Bairro</th>
                <th>Cep</th>
                <th>Zona</th>
            </tr>
                <?php 
                    require_once("../classe/Adm.php");
                    $adm = new Adm();
                    if(!isset($_POST['pesquisa'])){
                        $tables = $adm->tabelaEcoponto();
                    }
                    else{
                        $pesquisa = $_POST['pesquisa'];
                        $tables = $adm->pesquisaEcoponto($pesquisa);
                    }
                    foreach($tables as $dados){
                ?>
                <tr>

                    <td><?php echo $dados['pk_idEcoponto']; ?></td>
                    <td><?php echo $dados['ufEcoponto']; ?></td>
                    <td><?php echo $dados['logradouroEcoponto']; ?></td>   
                    <td><?php echo $dados['bairroEcoponto']; ?></td> 
                    <td><?php echo $dados['cepEcoponto']; ?></td> 
                    <td><?php echo $dados['zonaEcoponto']; ?></td>           
                </tr>
                <?php
                }
            ?>
        </table>
        
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
		<script src="../javascript/index-adm.js"></script>
    </body>
</html>