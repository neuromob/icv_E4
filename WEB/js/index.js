
$(document).ready(function(){

  console.log($(".select-inscription").val());

});


$(function() {
  
  $('#cb-aller-retour').click(function() {
    if($('#cb-aller-retour').is(':checked')==true){
      $('#heure-newtrajet-retour').show();
    } else {
      $('#heure-newtrajet-retour').hide();
    }
  });
  $("#select-inscription").change(function() {
    var valueOfSelect = $(this).val();
    if (valueOfSelect == "inscription-oui") {
      $("#btn-complete-profil").show();
    } else {
      $("#btn-complete-profil").hide();
    }
  });
  $(".button-content").on("click", function() {
    //hide all sections
    $(".content-section").hide();
    //show the section depending on which button was clicked
    $("#" + $(this).attr("data-section")).show();

    $(".button-content").removeClass("button-active");
    $(this).addClass("button-active");
  });

});

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





