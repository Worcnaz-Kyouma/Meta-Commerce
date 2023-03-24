function sendToEmployerPage(pk_id_employer){
    if(pk_id_employer == null)
        location.href = "employer.php";
    else
        location.href = "employer.php?id=" + pk_id_employer;
}