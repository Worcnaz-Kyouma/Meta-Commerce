var initialPhpViewFilesUrl='scripts/php/view/';
var actualMode = "user";

//Hidden class in client/market div logic and change mode between then 
function changeMode(button) {
    if (actualMode != button.id) {
        actualModeBtn = document.getElementById(actualMode);
        actualModeBtn.disabled = false;
        button.disabled = true;
        /*removeHiddenOfClass(mode);
        if (mode == "market") {
            concatenateHiddenInClass("user");
        }
        else {
            concatenateHiddenInClass("market");
        }*/
    }
    actualMode = button.id;
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
function sendToDynamicLoginPage() {
    loginUrlWithMode = initialPhpViewFilesUrl + actualMode + '/' + actualMode + 'login.php';
    location.href = loginUrlWithMode;
}