
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
            const inputHidden1 = document.createElement('input');
            inputHidden1.setAttribute("type","hidden");
            inputHidden1.setAttribute("name","idGioco");
            inputHidden1.setAttribute("value",value);
            formInv.appendChild(inputHidden1);
            const inputHidden2 = document.createElement('input');
            inputHidden2.setAttribute("type","hidden");
            inputHidden2.setAttribute("name","votoNuovo");
            inputHidden2.setAttribute("value","No");
            formInv.appendChild(inputHidden2);
            const divVoto = document.createElement('div');
            divVoto.setAttribute("id","votazione");
            const pVoto = document.createElement("p");
            pVoto.innerHTML="Inserisci un voto se vuoi modificarlo";
            divVoto.appendChild(pVoto);
            for(let j=1;j<11;j++){
                labelX = document.createElement("label");
                labelX.setAttribute("id","voto");
                labelX.setAttribute("for","rate"+j);
                labelX.innerHTML=j;
                checkBoxX = document.createElement("input");
                checkBoxX.setAttribute("id","rate"+j);
                checkBoxX.setAttribute("name","rating");
                checkBoxX.setAttribute("type","radio");
                checkBoxX.setAttribute("value",j);
                checkBoxX.setAttribute("onclick","upgradeVoto(this)");
                divVoto.appendChild(checkBoxX);
                divVoto.appendChild(labelX);
            }
            ul[i].appendChild(divVoto);
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

function upgradeVoto(e){
    voto=e.value;
    const input_voto = document.getElementsByName("votoNuovo")[0];
    input_voto.removeAttribute("value");
    input_voto.setAttribute("value",voto);
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
            ul[i].removeChild(document.getElementById("votazione"));
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

