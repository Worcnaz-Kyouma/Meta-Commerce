function manageLogoIcon(htmlInput_nm_employer) {
    img = document.getElementsByClassName("icon")[0];
    if(htmlInput_nm_employer.value == null){
        img.removeAttribute("src");
    }
    else{
        img.setAttribute("src", "../../../../resources/usersimg/img" + htmlInput_nm_employer.value + ".jpg");
    }
}
