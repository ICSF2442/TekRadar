$(document).ready(function(){


    document.getElementById("botaoResultado").onclick = function () {
        let aluguerCusto = document.getElementById("aluguerCusto").value
        let infApoio = document.getElementById("infApoio").value
        let salasReuniao = document.getElementById("salasReuniao").value
        let parqueEstc = document.getElementById("parqueEstc").value
        let bar = document.getElementById("bar").value
        let wifi = document.getElementById("wifi").value
        let redeTransportes = document.getElementById("redeTransportes").value
        let armazem = document.getElementById("armazem").value
        let dist = document.getElementById("dist").value
        let valoresUser = [];
        valoresUser.push(aluguerCusto, infApoio, salasReuniao, parqueEstc, bar, wifi, redeTransportes, armazem, dist);
        sendRequest("/calculus/getResult.php", {
            valoresUser:valoresUser

        }).then((res)=> {
            console.log("result", res);
            $('#resultadoModal').modal('show');
            document.getElementById("resultadoNome").innerHTML = res.name
        });



    }


});