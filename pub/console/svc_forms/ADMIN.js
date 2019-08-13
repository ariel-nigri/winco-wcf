document.addEventListener("DOMContentLoaded", (event) => {
    console.log(document.getElementById('usu_twofact_type'));
    document.getElementById('usu_twofact_type').onchange = function() {
        if (document.getElementById("usu_twofact_type").options[document.getElementById("usu_twofact_type").selectedIndex].value == "GOGLE")
        {
            document.getElementById("gauth_generate_code").style.display = "inline-block";
        } else {
            document.getElementById("gauth_generate_code").style.display = "none";
        }
    }
});

function gauth_close_qrcode() {
    if (confirm("Atenção! Esse qrcode só será exibido desta vez. Deseja continuar mesmo assim?")) {
        document.getElementById("gauth_qrcode_container").style.display = "none";
    }
}