
function search(){
  const searchWrapper = document.querySelector("#ricerca");

  const inputBox = document.getElementById("searchBar");
  const suggBox = document.querySelector(".autocom-box");

  const btnSearch = document.getElementById("btSearch");
  btnSearch.setAttribute("name","immagine");

  var arrTitoli = document.getElementById("arrTitoli").textContent;
  var titoli = arrTitoli.split(",");

  let imageList;
  var focus=-1;

  inputBox.addEventListener("keydown", function(event){
    if(event.key=="ArrowDown"){
      suggBox.focus();
      if(focus+1<imageList.length){
        focus++;
        imageList[focus].setAttribute("class","active");
        if(focus-1>=0) imageList[focus-1].removeAttribute("class","active");
      }else if(focus==imageList.length-1){
        imageList[focus].removeAttribute("class","active");
        focus=0;
        imageList[focus].setAttribute("class","active");
      }
      inputBox.value=imageList[focus].textContent;
      btnSearch.setAttribute("value",inputBox.value);
    }else if(event.key=="ArrowUp"){
      if(focus-1>=0){
        imageList[focus].removeAttribute("class");
        focus--;
        imageList[focus].setAttribute("class","active");
      } 
      inputBox.value=imageList[focus].textContent;
      btnSearch.setAttribute("value",inputBox.value);
    } 
    if(event.key=="Enter"){
      event.preventDefault();
      if(focus==-1){
        btnSearch.click();
      }else{
        imageList[focus].click();
      } 
    }
  });

  inputBox.addEventListener("input",()=>{
    btnSearch.setAttribute("value",inputBox.value);
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

      imageList = suggBox.querySelectorAll("button");
      for (let i = 0; i < imageList.length; i++) {
        imageList[i].setAttribute("id", "bt");
        imageList[i].setAttribute("name", "immagine");
        imageList[i].setAttribute("value", imageList[i].textContent);
        imageList[i].setAttribute("aria-label",imageList[i].textContent);
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

  function showSuggestions(list){
    let listData;
    if(!list.length){
      listData = '<li>' + "Nessun risultato specifico" + '</li>';
    }else{
      listData = list.join('');
    }
    focus=-1;
    suggBox.setHTML(listData);
  }
}