jQuery(document).ready(function($) {
$('#formfeedback').validate({
 
onfocusout: function(element) {
  this.element(element);
},
 
rules: {
    
  ccemail: {
    required: true,
    email: true
  } 
  
},
 
messages: {
  ccemail: "Please enter a valid email address."
 
},
 
errorElement: "div",
errorPlacement: function(error, element) {
  element.before(error);
}
 
});
});
