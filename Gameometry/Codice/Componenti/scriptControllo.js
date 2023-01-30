
function checkEmail(){
    const checkEmail = document.getElementById("email");
    const errorEmail = document.getElementById("errorEmailRegister");

    checkEmail.addEventListener("blur",function(e){
        errorEmail.innerText="";
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

function checkCommento(){
    const divCommento = document.getElementById('inputCommento');
    const form = divCommento.children[0]; //mi prende il form
    const textarea = document.getElementById('areaCommento');
    let checked=false;
    const ratings = document.getElementsByName('rating'); //mi prende tutti i voti
    for(let i=0;i<ratings.length&&!checked;i++){
        if(ratings[i].checked) checked=true;
    }
    if(textarea.value ==''||!checked){
        form.disable=true;
        form.setAttribute("action","#");
        if(textarea.value ==''&&checked){
            alert("Commento vuoto!");
        }
        if(textarea.value !=''&&!checked){
            alert("Non hai inserito il voto!");
        }else{
            alert("Per commentare inserisci un voto e un commento!");
        }
    }else{
        form.disabled=false;
        form.setAttribute("action","areaUtente.php");
    }
}

