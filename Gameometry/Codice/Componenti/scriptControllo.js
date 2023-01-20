
function checkEmail(){
    const checkEmail = document.getElementById("email");
    const errorEmail = document.getElementById("errorEmailRegister");

    checkEmail.addEventListener("blur",function(e){
        errorEmail.innerText="";
        // \w parola a caso "marco"
        // ([\.-]) marco. oppure marco-
        // ?\w controlla se c'è una parola marco.brigo
        // @ forzata 
        // \w parola => gmail
        // ([\.-]) punto o trattino
        // parola opzionale che c'è solo se c'è [. o -]
        // poi il punto per forza 
        // l'it o com
        // $ => fine stringa (forse) o che deve finire
        if(checkEmail.value.length>0&&checkEmail.value.search(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)!=0){
            errorEmail.innerText="Sintassi della mail errata";
        }
    });

    checkEmail.addEventListener("input",()=>{
        if(checkEmail.value.length<1)  errorEmail.innerText="";
    });
}

function checkUser(){
    const checkUser = document.getElementById("username");
    const errorUser = document.getElementById("errorUsernameRegister");

    checkUser.addEventListener("blur",function(e){
        errorUser.innerText="";
        const specialChars = /[`@#$%^&*()+=\[\]{};':"\\|,<>\/?~]/;
        if(checkUser.value.length>0&&checkUser.value.search(/^[a-zA-Z0-9!\-_.]{4,30}$/)!=0||specialChars.test(checkUser.value)){
            errorUser.innerText="Sintassi del nickname errata";
        }
    });

    checkUser.addEventListener("input",()=>{
        if(checkUser.value.length<1)  errorUser.innerText="";
    });
}

function checkPsw(){
    const checkPsw = document.getElementById("password");
    const errorPsw = document.getElementById("errorPasswordRegister");

    checkPsw.addEventListener("blur",function(e){
        errorPsw.innerText="";
        const specialChars = /[`@#%^&*()_+\-=\[\]{};':"\\|,.<>\/~]/;
        if((checkPsw.value.length>0)&&(checkPsw.value.search(/^[a-zA-Z0-9]*\w{4,12}$/)!=0||specialChars.test(checkPsw.value))){
            errorPsw.innerText="Password corta o caratteri speciali non ammessi";
        }
    });

    checkPsw.addEventListener("input",()=>{
        if(checkPsw.value.length<1)  errorPsw.innerText="";
    });
}

