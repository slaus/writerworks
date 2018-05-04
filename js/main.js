$(document).ready(function (){
    
    //Smooth scrolling of the page when you click on the menu
    $(".smooth-scroll").on("click", function (event) {
        var menu = $(this).attr('href');
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top - 50;
        $('body,html').animate({scrollTop: top}, 1000);
    });
    
    //Autohide collapsed menu
    $(".navbar-nav .nav-link").on("click", function () {
        $(".navbar-toggler").addClass("collapsed");
        setTimeout(function () {
            $(".navbar-collapse.collapse.show").removeClass("show")
        }, 300);
    });

    $('#reviews').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    $(window).scroll(function(){
        if ($(window).scrollTop() > 10) {
            $('.navbar').addClass('scrolled');
        }
        else {
            $('.navbar').removeClass('scrolled')
        }
    });

    $("form").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        var url = $(this).attr('action');
		var form = $(this);
		form.find('legend').after('<small class="text-danger error-message"></small>');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function (data) {
				form.html(data);
            },
			error: function (data) {
				form.find('.error-message').text(data.responseText);
			},
            cache: false,
            contentType: false,
            processData: false
        });
    });

});