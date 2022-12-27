

const searchWrapper = document.querySelector("#ricerca");

const inputBox = document.getElementById("searchBar");

var arrTitoli = document.getElementById("arrTitoli").textContent;
var titoli = arrTitoli.split(",");

inputBox.addEventListener("input",function(e){
  
  let emptyArray= [];
  for(var i=0; i<titoli.length; i++){
    emptyArray.push(titoli[i]);

  }

});