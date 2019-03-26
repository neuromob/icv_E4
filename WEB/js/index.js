
$(document).ready(function(){
  
});


$(function() {
	$('.range').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set + " km");
	});
  $('#cb-aller-retour').click(function() {
    if($('#cb-aller-retour').is(':checked')==true){
      $('#heure-newtrajet-retour').show();
      $('#heure-semaine-retour').show();
    } else {
      $('#heure-newtrajet-retour').hide();
      $('#heure-semaine-retour').hide();
    }
  });
  $("#select-inscription").change(function() {
    var valueOfSelect = $(this).val();
    if (valueOfSelect == "inscription-oui") {
      $("#btn-complete-profil").show();
      $(".grid-profile-passager").show();
    } else {
      $("#btn-complete-profil").hide();
      $(".grid-profile-passager").hide();
    }
  });
  $("#type-inscription").change(function() {
    var valueOfSelect = $(this).val();
    console.log(valueOfSelect);
    if (valueOfSelect == "propose") {
      $("#type-inscription-recherche").hide();
      $("#type-inscription-propose").show();
    } else {
      $("#type-inscription-recherche").show();
      $("#type-inscription-propose").hide();
    }
  });
  $(".button-content").on("click", function() {
    //hide all sections
    $(".content-section").hide();
    //show the section depending on which button was clicked
    $("#" + $(this).attr("data-section")).show();
    if($("#" + $(this).attr("data-section")).attr('id') == 'trip-publied'){
      $("#title-trip").text("Trajets publiés");
    } else if ($("#" + $(this).attr("data-section")).attr('id') == 'trip-reserved') {
      $("#title-trip").text("Trajets reservés");
    } else {
      $("#title-trip").text("Trajets archivés");
    }

    $(".button-content").removeClass("button-active");
    $(this).addClass("button-active");

    $(".checkbox-type-date").prop('checked', false);
    $(this).children().prop('checked', true);
    
  });
  $('#predefini_checkbox').change(function() {
    if ($('#predefini_checkbox').is(':checked')){
      $("#lieuDepart_predefini").prop('disabled', false);
      $("#adresse-marker").val('');
      $("#adresse-marker").prop('disabled', true);
    } else {
      $("#lieuDepart_predefini").prop('disabled', true);
      $("#lieuDepart_predefini").val('default');
      $("#adresse-marker").prop('disabled', false);
      
    }
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






