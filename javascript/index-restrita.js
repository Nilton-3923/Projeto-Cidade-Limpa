var seta = document.getElementById('seta');
        var navbarModal = document.getElementById('navbarModal');

        seta.onclick = ()=>{
            if(navbarModal.style.top === "-170px"){
                navbarModal.style.top = "90px";
            }else{
                navbarModal.style.top = "-170px";
            }
        }

function modalAlterarConta(){
    var modalAlterarConta = document.getElementById('modalAlterarConta');

    modalAlterarConta.classList.toggle('apareceModalAlterarConta');
    
}