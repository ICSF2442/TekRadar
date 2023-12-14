function sendRequest(endpoint, data) {

    return new Promise(function (resolve, reject) {
        let request = new XMLHttpRequest();
        request.open("POST","http://localhost/TekRadar/api/v1"+endpoint, true);
        request.setRequestHeader("Content-Type", "application/json");
        //request.responseType = 'json';
        request.onload = function () {
            if (request.status >= 200 && request.status < 300) {
                if (isJson(request.response)) {
                    let response = JSON.parse(request.response);
                    if(response.isError){
                        throwError(response.error);
                        reject(response.error);
                    }
                    resolve(response.result);
                }
                else {
                    throwError("Não foi possível interpretar a resposta do servidor.");
                    console.error(request.response);
                    reject({
                       error: request.response
                    })
                }
            }
            else {
                throwError("Não foi possível processar o seu pedido.");
                reject({
                    error: request.error
                });
            }
        };
        request.onerror = function () {
            throwError("Não foi possível processar o seu pedido.");
            reject({
                error: request.error
            });
        };
        request.send(JSON.stringify(data));
    });

    function isJson(str) {
        console.log("teste")
        console.log(str)
        try {
            JSON.parse(str);
        }
        catch (e) {
            console.log(e)
            return false;
        }
        return true;
    }
}