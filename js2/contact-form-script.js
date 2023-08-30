$(document).ready(function() {
    $("#contactForm").submit(function(event) {
      event.preventDefault();
      var form = $(this);
      var formData = form.serialize();
  
      $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: formData,
        success: function(response) {
          if (response === "success") {
            // El correo se envió correctamente
            $("#msgSubmit").removeClass("hidden");
            $("#msgSubmit").text("Reservation submitted successfully");
            $("#contactForm")[0].reset();
          } else {
            // Error al enviar el correo
            $("#msgSubmit").removeClass("hidden");
            $("#msgSubmit").text("Error sending reservation");
          }
        }
      });
    });
  });
  