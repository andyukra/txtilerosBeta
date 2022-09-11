$(function(){

    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);

    //E V E N T S

    $('#closeModal').click(e => {
        $('.modal').css('display', 'none');
    });
    $('#loginOpen').click(e => {
        $('.modal').css('display', 'grid');
    });
});