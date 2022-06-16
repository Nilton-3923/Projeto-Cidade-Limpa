<?php
    error_reporting(0);
    session_start();
    include_once("../session/valida-sentinela.php");
    require_once("../classe/Conexao.php");
    require_once("../classe/Usuario.php");
    require_once("../classe/Denuncia.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/reset.css">
        <Link rel="stylesheet" href="../css/index-restrita.css">
        <link rel="stylesheet" href="../css/input-foto.css">
        <title>Document</title>
    </head>
    <?php
        $perfil = new Usuario();
        $listaPerfil = $perfil->perfil();
        foreach($listaPerfil as $lista)
        {

    ?>
    <?php 
        } 
        ?>
    <body>
        <nav>
            <div class="navbar-parte-1">
                <div class="ajuste-logonav-1">
                    <div class="ajuste-logonav-2">
                        <img class="logo" src="../imagens/logo.png">
                    </div>
                </div>
            </div>
            
            <div id="abre-modal" class="navbar-logado">
                <div class="ajuste-div-foto">
                    <img class="foto-navbar ajuste-foto"src="../cadastro/<?php echo $lista['imgUsuario']; ?>">
                </div>
                <div id="seta"class="seta">
                    <div class="linha-seta-1"></div>
                    <div class="linha-seta-2"></div>
                </div>
                
            </nav>
            <div style="top:-170px;" id="navbarModal" class="navbar-modal">
                <a href="../session/logout-usuario.php">Sair</a>
                <a onClick="modalAlterarConta()"class="btn-alterar-conta">Alterar conta</a>
                <a onClick="ApareceModalAlterarDenuncia()"class="btn-alterar-conta">Alterar denuncias</a>
            </div>
            
            
            <div class="div-principal">
            <h1 class="titulo-pagina">Criar Denuncia</h1>
            <div class="ajuste-info-e-mapa">
                <div id="map"></div>
                <div class="info-denuncia">
                    <h2>O que é preciso para denunciar?</h2>
                    <div class="div-info">
                        <ul>
                            <li>Endereço do local</li>
                            <li>Foto da denuncia</li>
                            <li>Descrição sobre a situação do local</li>
                        </ul>
                        <p onClick="modalCriarDenuncia()"class="btn-denunciar">Clique aqui para Denunciar</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="divisao-pagina"></div>

        <h2 class="segundo-titulo">DENUNCIAS FEITAS POR VOCÊ</h2>
        <div class="ajuste-denuncias">
            <div class="denuncias">
        <?php
            
            $usuario = new Usuario();
            $listaDeDenuncias = $usuario->denunciasFeita();
            foreach($listaDeDenuncias as $linha){
        ?>
                    <div>
                        <div id="container">
                            <a class="card-link" href="#">
                                <article class="blog-card">
                                        <img class="post-image" src="../cadastro/<?php echo $linha['imgDenuncia']; ?>" /><!--Imagem da Denuncia -->
                                    <div class="article-details">
                                        <h3 class="post-title"><?php echo $linha['tituloDenuncia'];?></h3><!--Titulo da denuncia-->
                                        <p class="post-description"><?php echo $linha['descDenuncia'];?></p><!--descrição da Denuncia -->
                                        <p class="post-author"><?php echo $linha['nomeUsuario'];?></p>
                                        <h4 class="post-category">cep: <?php echo $linha['cepDenuncia'];?></h4><!--cep da Denuncia -->
                                    </div>
                                </article>
                            </a>
                        </div>


                        <!-- Colocar esse form de Alteração da denuncia em um modal -->
                        
                        <div id="modalAlterarDenuncia" class="modal-alterar-denuncia">
                            <form action="../CRUD/objeto-alterar-denuncia.php" method="post" enctype="multipart/form-data">
                                <button class="cancelar" onClick="FechaModalAlterarDenuncia()">Cancelar</button>
                                <input type="hidden" name="pk_idDenuncia" value="<?php echo $linha['pk_idDenuncia'];?>">
                                <input type="text" name="tituloDenuncia" value="<?php echo $linha['tituloDenuncia']; ?>">
                                <input name="descDenuncia" value="<?php echo $linha['descDenuncia'] ?>">
                                <label style="display:flex; flex-direction:row; align-items:center; gap:20px;" for="foto"><img style="cursor:pointer;"src="../imagens/upl.png"> <p id="preview"style="font-size:0.9vw; color:black;">Enviar foto</p></label>
                                <input id="foto"style="display:none;"type="file" name="imgDenuncia">
                                <!--Deletar Denuncia--><a class="btn-del-denuncia"href="../CRUD/objeto-deletar-denuncia.php?pk_idDenuncia=<?php echo $linha['pk_idDenuncia'];?>">Deletar</a>
                                <input class="btn-basico bg-verde" type="submit" value="Salvar">
                            </form>
                        </div>          
                    </div>
        <?php
            }

            $usuario = new Usuario();
            $lista = $usuario->perfil();

            foreach($lista as $linha){
        ?>
            
                </div>
            </div>
            <div id="modalAlterarConta"class="ajuste-modal-alterar-conta">
                <div class="modal-alterar-conta">
                    <form action="../CRUD/objeto-alterar-usuario.php" method="post" enctype="multipart/form-data" class="alterar">
                            <div class="form-input">
                                <div class="preview">
                                    <img id="file-ip-1-preview">
                                    <label for="file-ip-1">Escolher Imagem</label>
                                    <input type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                                </div>
                            </div>
                        <input type="hidden" name="pk_Usuario" value="<?php echo $_SESSION['idUsuario'];?>" >
                        <input type="text" name="nomeUsuario" value="<?php echo $linha['nomeUsuario'];?>" ><!--NOME USUARIO -->
                        <input class="input-desabilitado" type="text" name="emailUsuario" disabled value="<?php echo $linha['emailUsuario'];?>" ><!--TELEFONE USUARIO -->
                        <input type="text" name="senhaUsuario" value="<?php echo $linha['senhaUsuario'];?>" ><!--SENHA USUARIO -->
                        <input type="text" name="numTelUsuario" value="<?php echo $linha['numTelUsuario'];?>" ><!--TELEFONE USUARIO -->
                        
                        <div class="btns-modal">
                            <a class="deletar-conta" href="../CRUD/objeto-deletar-usuario.php?pk_Usuario=<?php echo $_SESSION['idUsuario']; ?>">deletar conta </a><!--Deletar Usuario-->  
                        </div>
                        <p class="cancelar" onClick="modalAlterarConta()">Cancelar</p>
                        <input type="submit" value="Salvar">
                    </form>
                </div>
            </div>
            
        <?php } ?>
        <p id="mensagem"></p>
        <div id="modalCriarDenuncia" class="ajuste-criar-denuncia">
            <div class="criar-denuncia">
                <p onClick="cancelarModalCriarDenuncia()"class="btn-cancelar-modalCriarDenuncia">Cancelar</p>
                <h1 class="titulo-criar-denuncia">Denuncia</h1>
                <span id="mensagem" style="opacity:0;color:red;display:none">*Endereço invalido</span>
                
                <form action="../cadastro/objeto-cadastro-denuncia.php" method="post" enctype="multipart/form-data">
                <div class="form-pt1">

                    <!--Id do usuario-->
                    <input type="hidden" name="txtIdUsuario" value="
                    <?php 
                            session_start();
                            echo $_SESSION['idUsuario'];    
                            ?>
                    "> 
                    <div class="ajuste-para-correcao-inputs">
                        <!--Titulo denuncia-->
                        <input type="text" name="txtTituloDenuncia" aria-describedby="inputGroupPrepend" required placeholder="Titúlo">
                        <div class="correcao-inputs"></div>
                    </div>
                    
                    <!--Categoria da denuncia-->
                    <?php
                    require_once("../classe/Conexao.php");
                    require_once("../classe/Categoria.php");
                    
                    $categoria = new Categoria();
                    $listaCat = $categoria->listar();
                    
                    ?>
                    <div class="ajuste-para-correcao-inputs">
                        <input type="text" id="cep" name="txtCepDenuncia" aria-describedby="inputGroupPrepend" required placeholder="CEP";>   
                        <div class="correcao-inputs"></div>
                    </div>
                    <div class="rua-e-num">
                        <input class="rua desabilitado"type="text" aria-describedby="inputGroupPrepend" required id="rua" name="txtRuaDenuncia" placeholder="Rua" >
                        <input class="num" type="text" id="numero" aria-describedby="inputGroupPrepend" required name="txtNumeroDenuncia" placeholder="Nº">   
                    </div>
                    <div class="ajuste-para-correcao-inputs">
                        <input class="desabilitado"type="text" id="bairro" aria-describedby="inputGroupPrepend" required name="txtBairroDenuncia" placeholder="Bairro">
                        <div class="correcao-inputs"></div>
                    </div>
                    <!--Endereços-->
                    <div class="cidade-uf">
                        <input class="cidade desabilitado"type="text" aria-describedby="inputGroupPrepend" required id="cidade" name="txtCidadeDenuncia" placeholder="Cidade" >
                        <input class="uf desabilitado"type="text" aria-describedby="inputGroupPrepend" required id="uf" name="txtUfDenuncia" placeholder="UF" >
                    </div>
                    
                    <!--Descrição denuncia-->
                    <!--Aqui tem que ser uma área para escrever-->
                    <textarea class="desc" name="txtDenuncia" id="denuncia" cols="23" rows="5" placeholder="Descrição"></textarea>
                    <br>
    
                </div>
                <!--Número da casa-->
                <div class="categ-reg-ft">
                    <select name="txtCategoria">
                        <option disabled selected>Selecione a Categoria</option>
                        <?php 
                            foreach($listaCat as $linha)
                            { 
                                ?>
                                <option value="<?php echo $linha['pk_idCategoria'];?>">
                                    <?php echo ($linha['campoCategoria']);?>
                                </option>
                                <?php 
                            } 
                            ?>
                        </select>
                        <!--Região-->
                        <select name="regiao" id="regiao">
                            <option disabled selected>Regiões de São Paulo</option>
                            <option value="Zona Leste">Zona Leste</option>
                            <option value="Zona Norte">Zona Norte</option>
                            <option value="Zona Sul">Zona Sul</option>
                            <option value="Zona Oeste">Zona Oeste</option>
                        </select><br>
                        <!--Imagem denuncia-->
                            
                        <div style="width:100%;"class="form-input">
                            <div class="preview">
                                <img id="file-ip-1-preview-2">
                                <label for="file-ip-1-2">Escolher Imagem</label>
                                <input type="file" id="file-ip-1-2" accept="image/*" onchange="showPreview2(event);">
                            </div>
                        </div>

                        <input class="btn-denunciar alteracao-btn-criar-denuncia"type="submit" value="Denunciar">
                        
                    </div>
                    <script>
                        function showPreview2(event){
                            if(event.target.files.length > 0){
                            var src2 = URL.createObjectURL(event.target.files[0]);
                            var preview2 = document.getElementById("file-ip-1-preview-2");
                            preview2.src = src2;
                            preview2.style.display = "block";
                            }
                        }
                    </script>
                    
                    <!--Data denuncia-->
                    <input type="hidden" id="data" name="txtDtDenuncia" 
                    value="      
                    <?php
                        date_default_timezone_set('America/Sao_Paulo');
                        echo date('Y/m/d');
                        ?>
                    ">
                    
                </form>
            </div>
        </div>
    </body>
    <script src="../javascript/api-cep.js"></script>
    <script>
        function initMap(){
            // Opções para o mapa
            var options = {
                zoom: 12,
                center:{lat:-23.5489,lng:-46.6388},
                styles:[{
                            "featureType": "poi",
                            "stylers": [{
                                "visibility": "off"
                            }],
                            

                        }]
            }
            // New Map
            var map = new
            google.maps.Map(document.getElementById('map'),options);

            //ADCIONANDO MARCADORES POR MEIO DE ARRAY 
            //Array dos marcadores
            var markers = [
                <?php 

                $pontos = new Denuncia();
                $listaPontos = $pontos->mostrarPontosMapa();

                foreach ($listaPontos as $lista){

                    $idDenuncia = $lista['pk_idDenuncia'];

                    $titulo = $lista['tituloDenuncia'];
                    $data = $lista['dataDenuncia'];
                    $desc = $lista['descDenuncia'];
                    $categoria = $lista['campoCategoria'];
                    $img = $lista['imgDenuncia'];
                    $coordenadas= $lista['coordeDenuncia'];

                    if($categoria == 'Descarte Irregular de Lixo'){     
                        $cor = "#097005";
                    }
                    
                    else{
                        $cor ="blue";
                    }
                ?>
                        {
                            coords:{<?php echo $lista['coordeDenuncia'];?>},
                            //iconImage: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                            content:'<a style="text-decoration:none"href="index-restrita.php?idDenuncia=<?php echo $idDenuncia;?>&&coordenadas=<?php echo $coordenadas ;?>">'
                                    +'<h2 style="color:<?php echo $cor; ?>; display: inline; margin-right:20px"><?php echo $categoria; ?></h2>'
                                    +'<span style="color:black"><?php echo $data;?></span>'
                                    +'<p style="color:black; margin-top:20px; margin-bottom:20px;"><?php echo $desc;?></p>'
                                    +'<img style="height:150px; width:300px; margin-left:12px;"src="../cadastro/<?php echo $img;?>"></a>'
                         },
                <?php
                }
                ?>
            ]

            // Laço de repetição para percorrer os marcadores
            for(var i = 0; i < markers.length; i++){
                // Add marcadores 
                addMarker(markers[i]);
            }

            // Add Marker Function
            function addMarker(props){
                var marker = new google.maps.Marker({
                        position:props.coords,
                        map: map,
                        icon:props.iconImage,
                        
                });

                //Checando se o marcador está customizado
                if(props.iconImage){
                    //Adicionando um icon
                    marker.setIcon(props.iconImage);
                }

                //Checando o content
                if(props.content){
                    var infoWindow = new google.maps.InfoWindow({
                    content:props.content
                });

                marker.addListener('click', function(){
                    infoWindow.open(map,marker);
                });
                }
            }
        }

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5opbRMRKjMKTKajH2CdyKJCIsqOdwdUI&callback=initMap"
    ></script>    
    <script src="../javascript/index-restrita.js"></script>
    <script src="../javascript/input-foto.js"></script>
    
</html>