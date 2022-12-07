(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    
   

    

    function mediaFunction(x) {
        if (x.matches) { // If media query matches
            document.getElementById('top_logo').src = base_url + "/img/logo_s.png";
        } else {
            document.getElementById('top_logo').src = base_url + "/img/logo_.png";
        }
    }


    var qur = window.matchMedia("(max-width: 600px)");
    mediaFunction(qur)
    $(window).resize(function () {
        var medq = window.matchMedia("(max-width: 600px)");
        mediaFunction(medq)
    });


})(jQuery);

