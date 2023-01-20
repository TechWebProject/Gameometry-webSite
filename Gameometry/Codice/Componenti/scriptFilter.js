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
                gioco.style.display="block"; /* NO ATTRIBUTO STYLE INLINE (DENTRO IL TAG HTML) */
            }else{
                if(gioco.classList.contains(filter)){
                    gioco.style.display="block"; /* NO ATTRIBUTO STYLE INLINE (DENTRO IL TAG HTML) */
                }else{
                    gioco.style.display="none"; /* NO ATTRIBUTO STYLE INLINE (DENTRO IL TAG HTML) */
                }
            }
        })
        e.stopPropagation();
    })

}

