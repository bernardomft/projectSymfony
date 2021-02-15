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
            //console.log(JSON.parse(data));
            //console.log('respuesta recibida ' + data);
            cargarGroups();
        }
    });
}

//comprueba que el usuario no tengo mensajes sin leer
function checkRead(chat){
    var ruta = Routing.generate('CheckReadChats');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(chat),
        success: function (data){
            if (JSON.parse(data) === "false") {
                document.getElementById('chat_' + chat).style.color = 'red';
            }
        }
    });
}

//Busca en la BBDD los grupos de el usuario
function cargarGroups(){
    var ruta = Routing.generate('GetGroups');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        success: function (data){
            createGroups(JSON.parse(data));
        }
    });
}

function onClick() {
    //clearInterval(intervalConversation);
    while (document.getElementById('conver_id').firstChild)
        document.getElementById('conver_id').removeChild(document.getElementById('conver_id').firstChild);
    var destUser = this.id.substring(5, this.id.length);
    //userGlobal = user;
    updateRead(destUser);
    document.getElementById('divPerf').innerHTML = '' + destUser;
    document.getElementById(this.id).style.color = '#FFFFFF';
    var ruta = Routing.generate('GetConversation');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(destUser),
        success: function (data){
            cargarConversacion(JSON.parse(data));
        }
    });
}

function updateRead(destUser){
    var ruta = Routing.generate('UpdateRead');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(destUser),
        success: function (data){
            console.log(JSON.parse(data));
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
        ele.addEventListener("click", onClick)
        var p = document.createElement('p');
        p.innerHTML = chats[i];
        p.style.margin = '10px';
        ele.appendChild(p);
        document.getElementById('chat_id').appendChild(ele);
        checkRead(chats[i]);
    }
}

function createGroups(grupos) {
    gruposGlobal = [];
    gruposGlobal = grupos;
    for (var i = 0; i < grupos.length; i++) {
        var ele = document.createElement('div');
        ele.id = 'group_' + grupos[i];
        ele.style.textAlign = 'center';
        //ele.addEventListener("click", onClick2)
        var p = document.createElement('p');
        p.innerHTML = grupos[i];
        p.style.margin = '10px';
        ele.appendChild(p);
        document.getElementById('chat_id').appendChild(ele);
    }
}

//Borra los chats y los grupos
function deleteChats() {
    var ele = document.getElementById('chat_id');
    while (ele.children.length > 4)
        ele.removeChild(ele.lastChild);
}

//cargra la ocnversacion al hacer click
function cargarConversacion(arrayMsg) {
    for (var i = 0; i < arrayMsg.length; i++) {
        var tmp = arrayMsg[i][2].date;
        arrayMsg[i][2] = new Date(tmp);
    }
    arrayMsg.sort(function (a, b) {
        return a[2] - b[2];
    });
    while (document.getElementById('conver_id').firstChild)
        document.getElementById('conver_id').removeChild(document.getElementById('conver_id').firstChild);
    for (var i = 0; i < arrayMsg.length; i++) {
        var p = document.createElement('p');
        p.innerHTML = arrayMsg[i][0] + ' dijo:<br> ' + arrayMsg[i][1] +
            '<br>time: ' + arrayMsg[i][2] + '<br><br>';
        document.getElementById('conver_id').appendChild(p);
        document.getElementById('conver_id').style.overflow = 'scroll';
        document.getElementById('conver_id').style.overflowX = 'hidden';
        var objDiv = document.getElementById("conver_id");
        objDiv.scrollTop = objDiv.scrollHeight;
    }
}





window.onload=cargarChats;