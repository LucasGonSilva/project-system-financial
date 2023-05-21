const cadUserForm = document.getElementById("cadUserForm");
const msgAlerta = document.getElementById("msgAlerta");
const msgAlertaErrorCad = document.getElementById("msgAlertaErrorCad");

cadUserForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    msgAlertaErrorCad.innerHTML = "";
    
    document.getElementById("sendRegister").value = "Salvando...";
    document.getElementById("sendRegister").disabled = true;

    if(document.getElementById("txtNome").value == ""){
        msgAlertaErrorCad.innerHTML = "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo nome!</div>";
    } else if(document.getElementById("txtEmail").value == ""){
        msgAlertaErrorCad.innerHTML = "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo email!</div>";
    } else if(document.getElementById("txtSenha").value == ""){
            msgAlertaErrorCad.innerHTML = "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo senha!</div>";
    } else {
        const dadosUserForm = new FormData(cadUserForm);
        dadosUserForm.append("add", 1);
        
        const dados = await fetch("../../src/createUser.php", {
            method: "POST",
            body: dadosUserForm,
        });

        const resposta = await dados.json();

        if (resposta["error"]) {
            msgAlertaErrorCad.innerHTML = resposta["msg"];
          } else {
            msgAlerta.innerHTML = resposta["msg"];
            cadUserForm.reset();
          }

        console.log(resposta);
    }

    document.getElementById("sendRegister").value = "Cadastrar";
    document.getElementById("sendRegister").disabled = false;
    cadUserForm.reset();
});

function abrirPage(a) {
    let localPag = document.querySelector('.paginas');
    let pag = new XMLHttpRequest();

    pag.onreadystatechange = () => {
        if(pag.readyState == 4 && pag.status == 200) {
            localPag.innerHTML = pag.response;
        }
    }

    pag.open('GET', `../../${a}.php`);
    pag.send();
}