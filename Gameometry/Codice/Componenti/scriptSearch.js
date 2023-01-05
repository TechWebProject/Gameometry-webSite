

const searchWrapper = document.querySelector("#ricerca");

const inputBox = document.getElementById("searchBar");
const suggBox = document.querySelector(".autocom-box");

var arrTitoli = document.getElementById("arrTitoli").textContent;
var titoli = arrTitoli.split(",");

inputBox.addEventListener("input",()=>{
  let userData = inputBox.value;
  let emptyArray= [];
  for(var i=0; i<titoli.length; i++){
    emptyArray.push(titoli[i]);
  }

  if(userData){

    let filteredArray = emptyArray.filter(checkIfMatch);
  
    for(let i=0;i<filteredArray.length;i++){
      let elem='<form><button><li>' + filteredArray[i] + '</li></button></form>';
      filteredArray[i]=elem;
    }
    
    searchWrapper.classList.add("active");
    suggBox.classList.add("active");
    
    showSuggestions(filteredArray);

    let formList = suggBox.querySelectorAll("form");
    for (let i = 0; i < formList.length; i++) {
      formList[i].setAttribute("action", "templateGioco.php");
      formList[i].setAttribute("method", "POST");
    }

    let imageList = suggBox.querySelectorAll("button");
    for (let i = 0; i < imageList.length; i++) {
      imageList[i].setAttribute("id", "bt");
      imageList[i].setAttribute("name", "immagine");
      imageList[i].setAttribute("value", imageList[i].textContent);
    }

    let allList = suggBox.querySelectorAll("li");
    for (let i = 0; i < allList.length; i++) {
      allList[i].setAttribute("onclick", "select(this)");
    }

  }else{
    searchWrapper.classList.remove("active");
    suggBox.classList.remove("active");
    suggBox.innerHTML = [];
  }
});

function checkIfMatch(elem){
  return elem.toLowerCase().startsWith(inputBox.value.toLowerCase());
}

function select(element){
  let selectData = element.textContent;
  inputBox.value = selectData;
  document.getElementById("caricaRicerca").submit(selectData);
  searchWrapper.classList.remove("active");
  suggBox.classList.remove("active");
  suggBox.innerHTML = [];
}

function showSuggestions(list){
  let listData;
  if(!list.length){
    listData = '<li>' + "Nessun risultato" + '</li>';
  }else{
    listData = list.join('');
  }
  suggBox.setHTML(listData);
}
