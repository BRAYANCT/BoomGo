$(document).ready(function () {
    // $("#sidebar").mCustomScrollbar({
    //     theme: "minimal"
    // });

    $('#dismiss, .side-bar-overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.side-bar-overlay').removeClass('active');
    });

    $('.sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.side-bar-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});