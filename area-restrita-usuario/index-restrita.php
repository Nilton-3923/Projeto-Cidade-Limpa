<?php
    error_reporting(0);
    session_start();
    include_once("../session/valida-sentinela.php");
    require_once("../classe/Conexao.php");
    require_once("../classe/Usuario.php");
    require_once("../classe/Denuncia.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <Link rel="stylesheet" href="css/modal.css">
        <title>Document</title>
    </head>
    <?php
        $perfil = new Usuario();
        $listaPerfil = $perfil->perfil();
        foreach($listaPerfil as $lista)
        {

    ?>
            <img class="usuario" src="../cadastro/<?php echo $lista['imgUsuario']; ?>" alt="">
    <?php 
        } 
    ?>
    <style>
    .usuario{
        width: 40px;
        height: 40px;
        float: right;
        border-radius: 50%;
    }   
    .card{
        position: relative;
        border: 1px solid black;
        margin-right: 5px;

    }
    .user{
        border-radius:50px;
        margin: 10px;
    }
    .nome{
        right: 140px;
        position: absolute;
        top: 0;
    }
    .data{
        position: absolute;
        right: 20px;
        top: 40px;
        font-size: 10px;
    }
    #map{
        height:80vh;
        width: 70vw;
        background:red; 
    }
    .img-alterar{
        width: 50px;
        height: 50px;
        position: absolute;
        top: 10px;
        left: 40px;
        border-radius: 50%;
    }
    .input-image{
        position: absolute;
        top: 25px;
        left: 115px;
    }


    </style>
    <body>
        <a href="../session/logout-usuario.php">Sair</a><br><a href="cadastro-denuncia.php">Denunciar</a><br>
        
        <div>
            <div id="map"></div>
        </div>

    <?php
    
    echo $_GET['idDenuncia'];
    echo $_GET['coordenadas'];
    ?>

        <div>
            <h2>O que é ppreciso para denunciar?</h2>
            <ul>
                <li>Endereço do local</li>
                <li>Foto da denuncia</li>
                <li>Descrição sobre a situação do local</li>
            </ul>
            <a href="#">Clique aqui para denunciar</a>
        </div>


        <h2>DENUNCIAS FEITAS POR VOCÊ</h2>
        <?php
            $pontos = new Denuncia();
            $listaPontos = $pontos->mostrarPontosMapa();


            foreach($listaPontos as $lista){
                echo $lista['coordeDenuncia'];
            }

            $usuario = new Usuario();
            $listaDeDenuncias = $usuario->denunciasFeita();
            foreach($listaDeDenuncias as $linha){
        ?>
            <div class="card" style="width: 18rem;">
            <div>
                <img class="user" src="../cadastro/<?php echo $linha['imgUsuario'] ?>" alt="" style="width:50px"><!-- Foto do Usuario -->
                <h5 class="nome"><?php echo $linha['nomeUsuario'];?></h5><!--nome do Usuario -->
                <div class="body-card">
                    <h5 class=""><?php echo $linha['tituloDenuncia'];?></h5><!--titulo da Denuncia -->
                    
                    <p class="data"><?php echo $linha['dataDenuncia'];?></p><!--data da Denuncia -->

                    <h5 class=""><?php echo $linha['cepDenuncia'];?></h5><!--cep da Denuncia -->

                    <h5 class=""><?php echo $linha['descDenuncia'];?></h5><!--descrição da Denuncia -->

                    <img class="" src="../cadastro/<?php echo $linha['imgDenuncia']; ?>" alt="" style="width:150px"><!--Imagem da Denuncia -->
                    
                </div>
            </div>            
        <?php
            }
        ?>

    </body>
    <script>
        function initMap(){
            // Opções para o mapa
            var options = {
                zoom: 12,
                center:{<?php echo $_GET['coordenadas'];?>},
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
                foreach ($listaPontos as $lista){

                    $idDenuncia = $lista['pk_idDenuncia'];

                    $titulo = $lista['tituloDenuncia'];
                    $data = $lista['dataDenuncia'];
                    $desc = $lista['descDenuncia'];
                    $categoria = $lista['campoCategoria'];
                    $img = $lista['imgDenuncia'];
                    $coordenadas= $lista['coordeDenuncia'];

                    if($categoria == 'Descarte de lixo'){     
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
                                    +'<h2 style="color:<?php echo $cor; ?>"><?php echo $titulo; ?></h2>'
                                    +'<span style="color:black"><?php echo $data;?></span>'
                                    +'<p style="color:black"><?php echo $desc;?></p>'
                                    +'<img style="height:150px; width:300px;"src="../cadastro/<?php echo $img;?>"></a>'
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


    <!-- modal de cadastrar -->
    <script>
        function iniciaModal(modalId){
            const modal = document.getElementById(modalId);
            if(modal){
                modal.classList.add('mostrar');
                modal.addEventListener('click', function(e){
                    if(e.target.id == modalId || e.target.className == 'fechar'){
                        modal.classList.remove('mostrar');
                    }
                });
            }
            }
            const perfil = document.querySelector('.usuario');
            perfil.addEventListener('click',function(){
                iniciaModal('modal-perfil');
            })
    </script>

</html>