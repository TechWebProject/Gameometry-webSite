

const searchWrapper = document.querySelector("#ricerca");

const inputBox = document.getElementById("searchBar");
const suggBox = document.querySelector(".autocom-box");

var arrTitoli = document.getElementById("arrTitoli").textContent;
var titoli = arrTitoli.split(",");

inputBox.addEventListener("input",function(e){
  let userData = e.target.value;
  let emptyArray= [];
  for(var i=0; i<titoli.length; i++){
    emptyArray.push(titoli[i]);
  }
  if(userData){
    emptyArray = emptyArray.filter((data) =>{
      return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
    });

    emptyArray = emptyArray.map((data)=>{
        return data= '<li>' + data + '</li>';
    });

    
  }else{

  }

  showSuggestions(emptyArray);

});


function showSuggestions(list){
  let listData;
  if(!list.length){

  }else{
    listData = list.join('');
    suggBox.innerHTML = listData;
  }
}
