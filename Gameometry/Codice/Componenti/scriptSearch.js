

const searchWrapper = document.querySelector("#ricerca");

const inputBox = document.getElementById("searchBar");
const suggBox = document.querySelector(".autocom-box");
const formRicerca = document.getElementById("caricaRicerca");

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
        
        data= '<form><button><li>' + data + '</li></button></form>';
        
        return data;
    });

    
    searchWrapper.classList.add("active");
    suggBox.classList.add("active");
    
    showSuggestions(emptyArray);

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
    userValue = inputBox.value;
    listData = '<li>' + userValue + '</li>';
    
  }else{
    listData = list.join('');
    suggBox.setHTML(listData);
    
  }
}
