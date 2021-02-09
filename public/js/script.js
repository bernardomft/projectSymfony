//funcion para poder coger siempre el usuario que se ha logueado
function currentUser(){
        var user = document.getElementById('titulo_').innerHTML.substring(9,document.getElementById('titulo_').innerHTML.length);
        return user;
}
/* PETICIONES AJAX */

//Busca en la BBDD los chats de el usuario
//Primera funcion que es llamada
function cargarChats(){
    console.log('tu raza gitana ' + currentUser());
    var ruta = Routing.generate('GetChats');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        success: function (data){
            deleteChats();
            createChats(JSON.parse(data));
            console.log(JSON.parse(data));
            console.log('respuesta recibida ' + data);
        }
    });
}

function checkRead(chat){
    var ruta = Routing.generate('CheckReadChats');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(chat),
        success: function (data){
            console.log('respuesta recibida ' + data);
        }
    });
}

/* FIN PETICIONES AJAX */
//Esta funcion carga los chats de un suario en la página
function createChats(chats) {
    chatGlobal = [];
    chatGlobal = chats;
    for (var i = 0; i < chats.length; i++) {
        var ele = document.createElement('div');
        ele.id = 'chat_' + chats[i];
        ele.style.textAlign = 'center';
        //ele.addEventListener("click", onClick)
        var p = document.createElement('p');
        p.innerHTML = chats[i];
        p.style.margin = '10px';
        ele.appendChild(p);
        document.getElementById('chat_id').appendChild(ele);
        checkRead(chats[i]);
    }
}

//Borra los chats y los grupos
function deleteChats() {
    var ele = document.getElementById('chat_id');
    while (ele.children.length > 4)
        ele.removeChild(ele.lastChild);
}




window.onload=cargarChats;