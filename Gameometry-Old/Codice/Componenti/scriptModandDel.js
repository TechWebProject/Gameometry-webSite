// for(let i=0;i<btnmods.length;i++){
//     btnmods[i].addEventListener("onclick",myfun());
// }

// function myfun(){
//     console.log("fabio")
// }


const btnmods = document.querySelectorAll('.userButtons');

for(let i=0;i<btnmods.length;i++){
    btnmods[i].addEventListener('click',()=>{
        console.log("fabiooo");
    });
}
