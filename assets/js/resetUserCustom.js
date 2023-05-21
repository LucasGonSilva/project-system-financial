const resetUserForm = document.getElementById("resetUserForm");
const msgAlerta = document.getElementById("msgAlerta");
const msgAlertaErrorReset = document.getElementById("msgAlertaErrorReset");

resetUserForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    msgAlertaErrorReset.innerHTML = "";
    
    document.getElementById("sendReset").value = "Salvando...";
    document.getElementById("sendReset").disabled = true;

    if(document.getElementById("txtEmail").value == ""){
        msgAlertaErrorReset.innerHTML = "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo email!</div>";
    } else {
        const dadosUserForm = new FormData(resetUserForm);
        dadosUserForm.append("add", 1);
        
        const dados = await fetch("../../src/resetUser.php", {
            method: "POST",
            body: dadosUserForm,
        });

        const resposta = await dados.json();

        if (resposta["error"]) {
            msgAlertaErrorReset.innerHTML = resposta["msg"];
          } else {
            msgAlerta.innerHTML = resposta["msg"];
            resetUserForm.reset();
          }

        console.log(resposta);
    }

    document.getElementById("sendReset").value = "Cadastrar";
    document.getElementById("sendReset").disabled = false;
    resetUserForm.reset();
});