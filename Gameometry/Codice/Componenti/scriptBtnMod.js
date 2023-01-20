
var value;
const userButtons = document.getElementsByClassName("userButtons");

function modRec(e){
    value=e.value;
    const ul = document.getElementsByClassName("contenutoRecensioneU1");       
    for(let i=0;i<ul.length;i++){
        if(ul[i].children[1].getAttribute("id")==e.value){
            const textarea = document.createElement('textarea');
            textarea.setAttribute("id","textarea-mod");
            textarea.innerHTML=ul[i].children[1].innerHTML;
            textarea.setAttribute("oninput","upgradeValue()");
            var nodetodel = ul[i].children[1];
            ul[i].removeChild(nodetodel);
            ul[i].appendChild(textarea);
            const btnAnn = document.createElement('button');
            const btnInv = document.createElement('button');
            const formInv = document.createElement('form');
            formInv.setAttribute("action","areaUtente.php");
            formInv.setAttribute("method","POST");
            btnAnn.innerHTML="Annulla";
            btnInv.innerHTML="Modifica commento";
            btnInv.setAttribute("id","inviomod");
            btnAnn.setAttribute("id","annullamod");
            btnInv.setAttribute("aria-label","Invio modifiche del commento");
            btnInv.setAttribute("name","contenutoAgg");
            btnInv.setAttribute("value",textarea.textContent);
            btnAnn.setAttribute("aria-label","Annulla modifiche del commento");
            btnAnn.setAttribute("onclick","annMod()");
            formInv.appendChild(btnInv);
            const inputHidden = document.createElement('input');
            inputHidden.setAttribute("type","hidden");
            inputHidden.setAttribute("name","idGioco");
            inputHidden.setAttribute("value",value);
            formInv.appendChild(inputHidden);
            ul[i].appendChild(btnAnn);
            ul[i].appendChild(formInv);
        }
    }

    for(let i=0;i<userButtons.length;i++){
        if(userButtons[i].children[0].getAttribute("value")==value){
            userButtons[i].children[0].hidden = true;
            userButtons[i].children[1].children[0].hidden = true;
        }
    }
}

function upgradeValue(){
    const btninv = document.getElementById("inviomod");
    const txt = document.getElementById("textarea-mod");
    btninv.removeAttribute("value");
    btninv.setAttribute("value",txt.value);
}

function annMod(){
    const ul = document.getElementsByClassName("contenutoRecensioneU1");       
    for(let i=0;i<ul.length;i++){
        if(ul[i].children[1].getAttribute("id")=="textarea-mod"){
            const li = document.createElement('li');
            li.setAttribute("id",value);
            li.innerHTML=ul[i].children[1].innerHTML;
            var nodetodel = ul[i].children[1];
            ul[i].removeChild(nodetodel);
            ul[i].appendChild(li);
            ul[i].removeChild(ul[i].children[2]);
            ul[i].removeChild(document.getElementById("annullamod"));
        }
    }
    for(let i=0;i<userButtons.length;i++){
        if(userButtons[i].children[0].getAttribute("value")==value){
            userButtons[i].children[0].hidden = false;
            userButtons[i].children[1].children[0].hidden = false;
        }
    }    
}

