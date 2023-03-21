var actualMode = "user";

//Hidden class in client/market div logic and change mode between then 
function changeMode(mode) {
    if (actualMode != mode) {
        removeHiddenOfClass(mode);
        if (mode == "market") {
            concatenateHiddenInClass("user");
        }
        else {
            concatenateHiddenInClass("market");
        }
        actualMode = mode;
    }
}
function removeHiddenOfClass(mode) {
    var removingHiddenStringOfClass = document.getElementById(mode).getAttribute("class").replace("hidden ", "");
    document.getElementById(mode).setAttribute("class", removingHiddenStringOfClass);
}
function concatenateHiddenInClass(mode) {
    var currentClass = document.getElementById(mode).getAttribute("class");
    currentClass = "hidden " + currentClass;
    document.getElementById(mode).setAttribute("class", currentClass);
}

//PHP pages redirect logic
function sendToDynamicLoginPage(url) {
    loginUrlWithMode = initialPhpUrl + actualMode + '/' + actualMode + url;
    location.href = loginUrlWithMode;
}