$(function() {

    $("#index a:contains('Home')").parent().addClass('active');
    $("#manageEvent a:contains('Manage Event')").parent().addClass('active');
    $("#reportEvent a:contains('Report Event')").parent().addClass('active');
    
    /*if($("#manageEvent a:contains('Manage Event')").parent().hasClass('active')) {
        $(".dropdown a:contains('Manage')").parent().addClass('active');
    }*/
    
    $('ul.nav li.dropdown').hover(function() {
        $('.dropdown-menu', this).fadeIn();
    }, function() {
        $('.dropdown-menu', this).fadeOut('fast');
    });
});