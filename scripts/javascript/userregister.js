function previewFile(input){
    var img = document.getElementsByClassName("image-choicer")[0].getElementsByTagName("img")[0];

    var file = input.files[0];
    var reader = new FileReader();

    reader.onloadend = () => {
        img.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } 
}