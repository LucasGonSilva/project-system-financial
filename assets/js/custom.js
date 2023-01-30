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