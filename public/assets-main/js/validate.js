(function($) {
    // Select the form and form message
    var form = $('#ajax-contact-form'),
        form_messages = $('#form-messages');
        
    // Action at on submit event
    $(form).on('submit', function(e) {
        e.preventDefault(); // Stop browser loading
        
        // Get form data
        var form_data = $(form).serialize();
        
        // Send Ajax Request
        var the_request = $.ajax({
            type: 'POST', // Request Type POST, GET, etc.
            url: "forms/contact.php",
            data: form_data
        });
        
        // At success
        the_request.done(function(data){
            form_messages.text("Success: "+data);
            form_messages.addClass("alert alert-success")
            $("#name").text('');
            document.getElementById("name").value="";
            document.getElementById("phone").value="";
            document.getElementById("email").value="";
            document.getElementById("message").value="";
            // Do other things at success
            setTimeout(function() { $("#form-messages").fadeOut(1500); },3000);
            
            
            
        });
        
        // At error
        the_request.done(function(){
            form_messages.text("Error: "+data);
            form_messages.addClass("alert alert-error")
            
            // Do other things at fails
        });
    });
})(jQuery);