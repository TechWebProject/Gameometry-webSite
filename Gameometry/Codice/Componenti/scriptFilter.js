const btn = document.querySelectorAll(".filtri");
const videogiochi = document.querySelectorAll(".game");

const btnFiltro = document.getElementById("filtro");

var open = 0;


btnFiltro.addEventListener("click", () =>{
    if(!open){
        for(i= 0; i<btn.length; i++){

        btn.forEach(filtro => {
            filtro.classList.remove("hide");
        });
        open=1;
    }
    }else{
        btn.forEach(filtro => {
            filtro.classList.add("hide");
           });
        open=0;
    }

})

for(i= 0; i<btn.length; i++){

    btn[i].addEventListener("click", (e)=>{
        
        const filter = e.target.dataset.filter;
        
        videogiochi.forEach((gioco) =>{
            if(filter == "tutti"){
                gioco.classList.remove("noSelected");
                gioco.classList.add("filtrato");
                
            }else{
                if(gioco.classList.contains(filter)){
                    gioco.classList.add("filtrato");
                    gioco.classList.remove("noSelected");
                }else{
                    gioco.classList.remove("filtrato");
                    gioco.classList.add("noSelected");
                }
            }
        })
        e.stopPropagation();
    })

}

