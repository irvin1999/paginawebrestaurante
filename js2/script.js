$(document).ready(function() {
    var prevScrollpos = window.pageYOffset;
    
    $(window).scroll(function() {
      var currentScrollPos = window.pageYOffset;
      
      if (prevScrollpos > currentScrollPos) {
        $(".top-navbar").removeClass("hide-navbar");
      } else {
        $(".top-navbar").addClass("hide-navbar");
      }
      
      prevScrollpos = currentScrollPos;
    });
  });
  