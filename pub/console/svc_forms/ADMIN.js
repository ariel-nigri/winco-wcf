document.addEventListener("DOMContentLoaded", (event) => {
    if (document.getElementById("usu_twofact_type").options[document.getElementById("usu_twofact_type").selectedIndex].value == "GOGLE")
    {
        document.getElementById("gauth_generate_code").style.display = "inline-block";
        document.getElementById("gauth_generate_code").value = "Redefinir Código";
    }

    document.getElementById('usu_twofact_type').onchange = function() {
        if (document.getElementById("usu_twofact_type").options[document.getElementById("usu_twofact_type").selectedIndex].value == "GOGLE") {
            document.getElementById("gauth_generate_code").style.display = "inline-block";
        }
        else {
            document.getElementById("gauth_generate_code").style.display = "none";
        }
    }
});

function gauth_close_qrcode() {
    if (confirm("Atenção! Esse qrcode só será exibido desta vez. Deseja continuar mesmo assim?")) {
        document.getElementById("gauth_qrcode_container").style.display = "none";
    }
}

function check_gauth_code() {
    
    xhr = new XHRUpdater('gauth_verify_code.php?code=' + document.getElementById('gauth_code').value);
    xhr.onUpdate = function(request) {
        response = JSON.parse(request.response);
        if (response.response == 'success')
        {
            document.getElementById("gauth_qrcode_container").style.display = "none";
            document.getElementById("gauth_generate_code").style.display = "none";
        }
        else
            document.getElementById("gauth_feedback").innerText = "Código incorreto!";
    }
    xhr.start();	
}