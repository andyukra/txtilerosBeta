$(async function(){

    //I N I T I A L I Z A C I O N
    let stateChanges = false;
    let yo = $('#yo').text();
    let usuario = $('#usuario').text();

    if(usuario !== yo) {
        $('#upAvatar').attr('disabled', 'true');
        $('#upPortada').attr('disabled', 'true');
    }
    

    if($('#portada').length) {
        $('header').css({
            backgroundImage: `url(${$('#portada').attr('src')})`,
            backgroundSize: 'cover'
        });
    }


    //E V E N T S
    $('#upAvatar').change(async () => {
        $('.loader').css('display', 'flex');
        let form = new FormData();
        form.append('file', $('#upAvatar')[0].files[0]);
        form.append('type', 'avatar');
        const res = await fetch('changeAvatar.php', {
            method: 'POST',
            body: form
        });
        if(res.ok) {
            const response = await res.text();
            if(response === 'OK') location.href = location.href;
        }
    });

    $('#upPortada').change(async () => {
        $('.loader').css('display', 'flex');
        let form = new FormData();
        form.append('file', $('#upPortada')[0].files[0]);
        form.append('type', 'portada');
        const res = await fetch('changeAvatar.php', {
            method: 'POST',
            body: form
        });
        if(res.ok) {
            const response = await res.text();
            if(response === 'OK') location.href = location.href;
        }
    });

});