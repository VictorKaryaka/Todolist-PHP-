$(document).ready(function () {
    $('#add-button').mouseenter(function() {
        $(this).css('background-color', '#AAFD45');
    });

    $('#add-button').mouseleave(function() {
        $(this).css('background-color', '#fff');
    });

    $('#save').mouseenter(function() {
        $(this).css('background-color', '#5AC5F9');
    });

    $('#save').mouseleave(function() {
        $(this).css('background-color', '#fff');
    });

    $('#show_completed').mouseenter(function() {
        $(this).css('background-color', '#F9DF5C');
    });

    $('#show_completed').mouseleave(function() {
        $(this).css('background-color', '#fff');
    });
});

