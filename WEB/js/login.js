
$(document).ready(function(){
    alert("f");
  });
  
  
  $(function() {
    $( "#loginForm" ).submit(function( event ) {
        alert( "Handler for .submit() called." );
        event.preventDefault();
      });
    
      $("#btnConnexion").click(function() {
        $("#errorModal").show();
        alert("gze");
      });
  });  