function slider(){
    const btnleft = document.querySelector("#btn-left");
    const btnright = document.querySelector("#btn-right");
    const cCont = document.querySelector(".carousel");

    btnleft.addEventListener("click",()=>{
        cCont.scrollBy(-800,0);
    });

    btnright.addEventListener("click",()=>{
        cCont.scrollBy(800,0);
    });
}
