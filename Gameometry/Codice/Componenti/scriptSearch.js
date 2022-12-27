

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
      return data.toLocaleLowerCase().search(userData.toLocaleLowerCase());
    });

    emptyArray = emptyArray.map((data)=>{
        return data= '<li>' + data + '</li>';
    });

    searchWrapper.classList.add("active");
    suggBox.classList.add("active");
    
    showSuggestions(emptyArray);

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
  searchWrapper.classList.remove("active");
}

function showSuggestions(list){
  let listData;
  if(!list.length){
    userValue = inputBox.value;
    listData = '<li>' + userValue + '</li>';
  }else{
    listData = list.join('');
    suggBox.innerHTML = listData;
  }
}
