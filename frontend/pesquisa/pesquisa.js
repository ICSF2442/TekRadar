$(document).ready(function () {

    // Calculo do Resultado
    document.getElementById("botaoResultado").onclick = function () {
        let aluguerCusto = parseInt(document.getElementById("aluguerCusto").value);
        let infApoio = parseInt(document.getElementById("infApoio").value);
        let salasReuniao = parseInt(document.getElementById("salasReuniao").value);
        let parqueEstc = parseInt(document.getElementById("parqueEstc").value);
        let bar = parseInt(document.getElementById("bar").value);
        let wifi = parseInt(document.getElementById("wifi").value);
        let redeTransportes = parseInt(document.getElementById("redeTransportes").value);
        let armazem = parseInt(document.getElementById("armazem").value);
        let dist = parseInt(document.getElementById("dist").value);

        // Check if the sum of values is less than or equal to 25
        let sumOfValues = aluguerCusto + infApoio + salasReuniao + parqueEstc + bar + wifi + redeTransportes + armazem + dist;

        if (sumOfValues <= 25) {
            let valoresUser = [aluguerCusto, infApoio, salasReuniao, parqueEstc, bar, wifi, redeTransportes, armazem, dist];

            sendRequest("/calculus/getResult.php", {
                valoresUser: valoresUser
            }).then((res) => {
                console.log("result", res);
                $('#resultadoModal').modal('show');
                document.getElementById("resultadoNome").innerHTML = res.name;
            });
        } else {
            // Display n error message or handle the case where the sum exceeds 25
            console.log("Sum of values exceeds 25. Please adjust your input.");a
        }
    };


    //Valores do Range
    const allRanges = document.querySelectorAll(".range-wrap");
    allRanges.forEach(wrap => {
        const range = wrap.querySelector(".range");
        const bubble = wrap.querySelector(".bubble");

        range.addEventListener("input", () => {
            setBubble(range, bubble);
        });
        setBubble(range, bubble);
    });

    function setBubble(range, bubble) {
        const val = range.value;
        const min = range.min ? range.min : 1;
        const max = range.max ? range.max : 5;
        const newVal = Number(((val - min) * 5) / (max - min));
        bubble.innerHTML = val;

        bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
    }
});