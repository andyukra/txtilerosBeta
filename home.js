const { log } = console;
let activeNavTab = "todos";
let pubs = [1];
let Yo = null;
let page = 0;
let scrollHeight;
let blockGetPubs = false;
let blockGetPubs2 = false;
let likes = localStorage.getItem('likes');
let dislikes = localStorage.getItem('dislikes');

//SETTING LIKES AND DISLIKES IN LOCALSTORAGE
if(!likes) localStorage.setItem('likes', '');
if(!dislikes) localStorage.setItem('dislikes', '');

//H E L P E R S
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


$(function () {
  //H A N D L E R S

  function getPubs() {
    if (blockGetPubs || blockGetPubs2 || pubs.length === 0) return;
    $.get(`getPubs.php?category=${activeNavTab}&page=${page}`, (res) => {
      pubs = JSON.parse(res);
      addCardsToDOM();
      $(".loader").css("display", "none");
      page++;
    });
  }

  function createComments(coms) {
    let comentarios = coms.map((x) => {
      return `
        <article idComm=${x.id}>
          <div class="cardHeader">
            <div class="cardHeaderAutor">
                ${
                  x.foto
                    ? `<img src="${x.foto}" alt="foto de perfil"/>`
                    : '<ion-icon name="person-circle"></ion-icon>'
                }
                <div class="autorInfo">
                    <h3>${x.autor}</h3>
                    <p>${x.fecha}</p>
                </div>
            </div>
          </div>
          <div class="comentario">
                <p>${x.texto}</p>
          </div>
        </article>
      `;
    });
    return comentarios;
  }

  function addComments(coms) {
    const comments = createComments(coms);
    $(".commentsBX").append(comments);
  }

  function createPubCards() {
    let card = pubs.map((x) => {
      return `<article id=${x.id}>
            <div class="cardHeader">
                <div class="cardHeaderAutor" autor="${x.autor}">
                    ${
                      x.foto
                        ? `<img src="${x.foto}" alt="foto de perfil"/>`
                        : '<ion-icon name="person-circle"></ion-icon>'
                    }
                    <div class="autorInfo">
                        <h3>${x.autor}</h3>
                        <p>${x.fecha}</p>
                    </div>
                </div>
                <div class="cardHeaderOpts">
                  <div class="pubOpts">
                    ${
                      yo === x.autor
                        ? `<div class="pubOptsDel" idPub=${x.id}>
                        <ion-icon name="trash"></ion-icon>
                        <p>Eliminar</p>
                      </div>`
                        : ""
                    }
                    <div class="pubOptsLink">
                      <ion-icon name="link"></ion-icon>
                      <p>Link</p>
                    </div>
                    <div class="pubOptsOpen">
                      <ion-icon name="share"></ion-icon>
                      <p>Abrir</p>
                    </div>
                  </div>
                  <ion-icon name="ellipsis-vertical" class="pubOptsBtn"></ion-icon>
                </div>
                </div>
                <div class="cardBody">
                    ${filterYT(x.texto)}                
                    ${
                      x.imagen
                        ? `<div class="cardBodyImg"><img src=${x.imagen}></div>`
                        : ""
                    }   
                    ${
                      x.documento
                        ? `<div class="cardBodyDoc"><a href=${
                            x.documento
                          } download>${x.documento.replace(
                            /.*\/.*\//,
                            ""
                          )}</a><ion-icon name="arrow-down-circle"></ion-icon></div>`
                        : ""
                    }             
            </div>
            <div class="cardFooter">
                    <div class="likes">
                      <ion-icon name="thumbs-up" class="likeBtn"></ion-icon>
                      <p>${x.likes}</p>
                    </div>
                    <div class="dislikes">
                      <ion-icon name="thumbs-down" class="dislikeBtn"></ion-icon>
                      <p>${x.dislikes}</p>
                    </div>
                    <div class="comments" idPub=${x.id}>
                      <ion-icon name="chatbox-ellipses" style="color: #0852ffa3;"></ion-icon>
                    </div>
            </div>
        </article>`;
    });
    return card;
  }

  function addCardsToDOM() {
    let tarjetas = createPubCards();
    if (tarjetas.length === 0) {
      $(".container").append(
        '<h2 style="margin:2rem 0;color:rgba(0,0,0,.25);text-align:center;">No hay publicaciones :)</h2>'
      );
    }
    tarjetas.forEach((x) => {
      $(".container").append(x);
    });
    //C A R D  E V E N T S
    $(".cardBodyImg img").click((e) => {
      $(".modalImg img").attr("src", $(e.currentTarget).attr("src"));
      $(".modalImg").css("display", "flex");
    });
    $(".comments ion-icon").click(function (e) {
      const idPub = $(this).parent().attr("idPub");
      let comments = [];
      $.get(`getComments.php?idPub=${idPub}`, (res) => {
        if (res === "NADA") {
          $(".commentsBX").empty();
          $(".commentsBX").append("<h2>No hay comentarios :(</h2>");
          $(".commentsInput").attr('idPub', idPub);
          $(".modalComments").slideDown(200);
          return;
        }
        comments = JSON.parse(res);
        $(".commentsBX").empty();
        addComments(comments);
        $(".commentsInput").attr('idPub', idPub);
        $(".modalComments").slideDown(200);
      });
    });
    //L I K E  A N D  D I S L I K E
    $('.likeBtn').click(function (e) { 
      const idPub = $(this).parent().parent().parent().attr('id');
      let getLikes = localStorage.getItem('likes');
      let arr = getLikes.split(',');
      if(arr.find(x => x == idPub)) return;
      $.post('likeAndDislike.php', {type: 'like', idPub}, res => {
        if(res === 'OK') {
          arr.push(idPub);
          let updatedLikes = arr.toString();
          localStorage.setItem('likes', updatedLikes);
          let updateNumDOM = parseInt($(this).next().text()) + 1;
          $(this).next().text(updateNumDOM);
          $(this).css('color', 'blue');
        }
      });
    });

    $('.dislikeBtn').click(function (e) { 
      const idPub = $(this).parent().parent().parent().attr('id');
      let getDislikes = localStorage.getItem('dislikes');
      let arr = getDislikes.split(',');
      if(arr.find(x => x == idPub)) return;
      $.post('likeAndDislike.php', {type: 'dislike', idPub}, res => {
        if(res === 'OK') {
          arr.push(idPub);
          let updatedDislikes = arr.toString();
          localStorage.setItem('dislikes', updatedDislikes);
          let updateNumDOM = parseInt($(this).next().text()) + 1;
          $(this).next().text(updateNumDOM);
          $(this).css('color', 'blue');
        }
      });
    });

    //P U B  O P T S
    $(".pubOptsBtn").click(function (e) {
      $(this).prev().show(200);
    });
    $(".pubOptsDel").click(async function (e) {
      let ask = confirm("Seguro que desea eliminar la publicacion?");
      if (!ask) return;
      const res = await fetch(`delPub.php?id=${$(this).attr("idPub")}`);
      if (res.ok) {
        const response = await res.text();
        if (response === "OK") location.href = location.href;
      }
    });

    //GO TO PERFIL PAGE
    $('.cardHeaderAutor').click(function (e) {
      const autor = $(this).attr('autor'); 
      location.href = `perfil.php?user=${autor}`;
    });
  }

  //I N I T I A L I Z E
  window.scrollTo(0, 0);
  $("#categoria").attr("value", activeNavTab);
  $(".loader").css("display", "flex");
  yo = $("#yo").text();
  //get pubs of TODOS
  getPubs();

  //L I S T E N E R S
  //G L O B A L S
  $(window).scroll((e) => {
    if (Math.ceil(window.scrollY) > (document.body.scrollHeight - 700)) {
      getPubs();
      blockGetPubs2 = true;
      setTimeout(() => (blockGetPubs2 = false), 1000);
    }
  });
  $(document).click((e) => {
    if ($(e.target).hasClass("pubOptsBtn")) return;
    $(".pubOpts").slideUp(200);
  });

  //O T H E R S
  //C O M E N T S
  $(".sendComment").click(function (e) {
    const text = $(this).prev().val();
    const idPub = $(this).parent().attr("idPub");
    log($(this).parent())
    log(text, idPub)
    if (text.length === 0 || !idPub) return;
    $.post("comment.php", { text, idPub }, (res) => {
      if (res === "OK") location.href = location.href;
    });
    $(this).prev().val("");
  });
  //others
  $(".closeComments").click(function (e) {
    $(".modalComments").slideUp(200);
  });
  $(".tab").click((e) => {
    pubs = [1];
    page = 0;
    if (activeNavTab === $(e.currentTarget).attr("tab")) return;
    $(".loader").css("display", "flex");
    $(".container").empty();
    $(".tab").each(function () {
      $(this).removeClass("activeTab");
    });
    activeNavTab = $(e.currentTarget).attr("tab");
    $(e.currentTarget).addClass("activeTab");
    $("#categoria").attr("value", activeNavTab);
    getPubs();
  });
  $("#closeModal").click(() => $(".modalPub").css("display", "none"));
  $("#closeModalImg").click(() => $(".modalImg").css("display", "none"));
  $("#addPub").click(() => $(".modalPub").css("display", "flex"));
  $("#publish").submit(() => {
    $(".modalPub").css("display", "none");
    $(".loader").css("display", "flex");
  });
});
