function modRec(e){

    const ul = document.getElementsByClassName("contenutoRecensioneU1");       
    for(let i=0;i<ul.length;i++){
        if(ul[i].children[1].getAttribute("id")==e.value){
            x=true;
            const textarea = document.createElement('textarea');
            textarea.setAttribute("id","textarea-mod");
            textarea.innerHTML=ul[i].children[1].innerHTML;
            var nodetodel = ul[i].children[1];
            ul[i].removeChild(nodetodel);
            ul[i].appendChild(textarea);
        }
    }
    
}

