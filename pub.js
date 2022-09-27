$(function(){

    //H A N D L E R S
    function filterYT(text) {
        let code = null;
        if(text.match(/youtube\.com\/watch\?v\=(\w){11}/gi) || text.match(/youtu.be\/(\w){11}/gi)) {
          code = text.match(/\w{11}$/ig);
          return `<div class="cardBodyText"><p>
          <iframe width="560" height="315" src="https://www.youtube.com/embed/${code}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </p></div>`;
        }
      
        if(text) {
          return `<div class="cardBodyText"><p>${text}</p></div>`;
        } else {
          return '';
        }
    }

    //I N I T I A L I Z A C I O N
    const texto = $('.cuerpo p').text();

    if(filterYT(texto)) {
        $('.cuerpo p').text('');
        $('.cuerpo').append(filterYT(texto));
    }

});