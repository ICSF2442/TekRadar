<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/pesquisa.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="../resources/js/Request.js"></script>
    <script src="pesquisa.js"></script>



    <meta charset="UTF-8" />
    <title>TekRadar - Home</title>
    <link rel="icon" type="image/x-icon" href="../../imagens/favicon.ico">
    <div class="header">
        <div class="div_logo_titulo">
            <a href="../../home.php"><img class="logotipo" src="../../imagens/logo.png" /></a>
            <a href="../../home.php">
                <div class="titulo">TekRadar</div>
            </a>
        </div>
        <div class="menu">
            <button class="equipa" onclick="location.href='../equipa/equipa.html'">A EQUIPA</button>
            <button class="parques" onclick="location.href='../listaParque/listaparques.html'">PARQUES</button>
            <button class="pesquisa" onclick="location.href='pesquisa.html'">PESQUISA</button>
        </div>
    </div>

</head>

<body>
<main>

    <div class="border">
        <div class="background_criterio"> <label for="aluguerCusto" class="criterio">Custo de Aluguer </label>
            <input type="range" id="aluguerCusto" name="aluguerCusto" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="infApoio" class="criterio">Apoio Informático </label>
            <input type="range" id="infApoio" name="infApoio" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="salasReuniao" class="criterio">Salas de Reuniões </label>
            <input type="range" id="salasReuniao" name="salasReuniao" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="parqueEstc" class="criterio">Estacionamento </label>
            <input type="range" id="parqueEstc" name="parqueEstc" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="bar" class="criterio">Bar(Cantina) </label>
            <input type="range" id="bar" name="bar" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="wifi" class="criterio">Rede Wifi </label>
            <input type="range" id="wifi" name="wifi" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="redeTransportes" class="criterio">Transportes </label>
            <input type="range" id="redeTransportes" name="redeTransportes" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="armazem" class="criterio">Armazém </label>
            <input type="range" id="armazem" name="armazem" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>

        <div class="background_criterio"> <label for="dist" class="criterio">Distância </label>
            <input type="range" id="dist" name="dist" min="1" max="5">
            <div class="valores-range">
                <span class="min">1</span>
                <span class="mid">3</span>
                <span class="max">5</span>
            </div>
        </div>
    </div>
    <button id="botaoResultado" type="button" class="calcular" data-toggle="modal" data-target="#resultadoModa" >CALCULAR</button></a>


    <!-- Modal -->
    <div class="modal fade" id="resultadoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">O resultado é:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="resultadoNome">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </main>
<?php
   require("../templates/FailureModal.php");
?>

</body>

</html>