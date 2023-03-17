function onEmailInputChange() {
    //validateExistendEmail();
}

function fillMarketsDataList(markets) {
    if (markets != null) {
        var marketsDataList = document.getElementById('markets');
        var marketsDataListInput = document.getElementById('market');

        marketsDataListInput.disabled = false;
        marketsDataList.textContent = '';

        for (const market of markets) {
            var option = document.createElement('option');
            option.value = market.nm_market;
            marketsDataList.appendChild(option);
        }
    }
}

function resetMarketsDataList(){
    var marketsDataList = document.getElementById('markets');
    var marketsDataListInput = document.getElementById('market');

    marketsDataListInput.disabled = true;
    marketsDataList.textContent = '';
}

function getEmployerMarkets() {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        const jsonDoc = JSON.parse(this.responseText);
        if(jsonDoc!=null){
            fillMarketsDataList(jsonDoc);
        }
        else{
            resetMarketsDataList();
        }
    }

    xhttp.open("POST", "../../api/getMarketsByEmployerEmail.php");

    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send(
        "email=" + document.getElementById("email").value + "&"
        + "password=" + document.getElementById("password").value
    );
}
