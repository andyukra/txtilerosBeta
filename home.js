const { log } = console;
let activeNavTab = "todos";
let pubs = [1];
let Yo = null;
let page = 0;
let scrollHeight;
let blockGetPubs = false;
let blockGetPubs2 = false;

$(function () {
  //H A N D L E R S

  function getPubs() {
    if(blockGetPubs || blockGetPubs2 || pubs.length === 0) return;
    $.get(`getPubs.php?category=${activeNavTab}&page=${page}`, (res) => {
      pubs = JSON.parse(res);
      addCardsToDOM();
      $(".loader").css("display", "none");
      page++;
    });
  }

  function createPubCards() {
    let card = pubs.map((x) => {
      return `<article id=${x.id}>
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
                <div class="cardHeaderOpts">
                  <div class="pubOpts">
                    ${yo === x.autor ? 
                      `<div class="pubOptsDel" idPub=${x.id}>
                        <ion-icon name="trash"></ion-icon>
                        <p>Eliminar</p>
                      </div>` : ''}
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
                    ${
                      x.texto
                        ? `<div class="cardBodyText"><p>${x.texto}</p></div>`
                        : ""
                    }                
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
                      <ion-icon name="thumbs-up"></ion-icon>
                      <p>${x.likes}</p>
                    </div>
                    <div class="dislikes">
                      <ion-icon name="thumbs-down"></ion-icon>
                      <p>${x.dislikes}</p>
                    </div>
                    <div class="comments">
                      <ion-icon name="chatbox-ellipses"></ion-icon>
                      <p>0</p>
                    </div>
            </div>
            <div class="commentsBX">
              <h3>No hay comentarios aún :(</h3>
                    <div class="commentsInput" idPub=${x.id}>
                        <input type="text" placeholder="Escribe un comentario..." maxlength="150" minlength="1"/>
                        <button class="sendComment">
                          <ion-icon name="paper-plane"></ion-icon>
                        </button>
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
    $(".cardBodyImg img").click((e) => {
      $(".modalImg img").attr("src", $(e.currentTarget).attr("src"));
      $(".modalImg").css("display", "flex");
    });
    $(".comments ion-icon").click(function (e) {
      $(this).parent().parent().next().toggleClass("activeComments");
    });
    //C O M E N T S
    $(".sendComment").click(function (e) {
      const text = $(this).prev().val();
      const idPub = $(this).parent().attr('idPub');
      if(text.length === 0 || !idPub) return;
      $.post('comment.php', {text, idPub}, res => {
        if(res === 'OK') location.href = location.href;
      });
      $(this).prev().val('');
    });
    $(".pubOptsBtn").click(function (e) {
      $(this).prev().show("slow");
    });
    //P U B  O P T S
    $(".pubOptsDel").click(async function (e) {
      let ask = confirm('Seguro que desea eliminar la publicacion?');
      if(!ask) return;
      const res = await fetch(`delPub.php?id=${$(this).attr("idPub")}`);
      if (res.ok) {
        const response = await res.text();
        if (response === "OK") location.href = location.href;
      }
    });
  }

  //I N I T I A L I Z E
  window.scrollTo(0, 0);
  $("#categoria").attr("value", activeNavTab);
  $(".loader").css("display", "flex");
  yo = $('#yo').text();
  //get pubs of TODOS
  getPubs();

  //L I S T E N E R S
  //G L O B A L S
  $(window).scroll(e => {
    if(Math.ceil(window.scrollY) > (document.body.scrollHeight - 800)) {
      getPubs();
      blockGetPubs2 = true;
      setTimeout(() => blockGetPubs2 = false, 1000);
    }
  });
  $(document).click((e) => {
    if ($(e.target).hasClass("pubOptsBtn")) return;
    $(".pubOpts").slideUp("slow");
  });

  //O T H E R S

  //others
  $(".tab").click((e) => {
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
