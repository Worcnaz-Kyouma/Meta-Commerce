var markets;

function manageLogoIcon(htmlInput_nm_market) {
    img = document.getElementsByClassName("icon")[0];
    if(htmlInput_nm_market.value == null){
        img.removeAttribute("src");
    }
    else{
        img.setAttribute("src", "../../../../resources/marketsimg/" + markets.filter(market => market.nm_market == htmlInput_nm_market.value)[0].nm_img);
    }

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
            markets = jsonDoc;
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
