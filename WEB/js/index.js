var coll = document.getElementsByClassName("collapse");
var i;
        
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}

var element = document.querySelector(".leftMenu");
document.querySelector(".hamburger").onclick = function () {

  element.classList.toggle("openMenu");

  var hamburger = document.querySelector(".hamburger");
  hamburger.classList.toggle("open");

  var bodyVar = document.body;
  bodyVar.classList.toggle("marginLeft");

  var main =  document.querySelector(".main");
  main.classList.toggle("open");
  
    
}




