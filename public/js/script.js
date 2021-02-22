var intervalConversation;

//funcion para poder coger siempre el usuario que se ha logueado
function currentUser() {
    var user = document.getElementById('titulo_').innerHTML.substring(9, document.getElementById('titulo_').innerHTML.length);
    return user;
}

/* PETICIONES AJAX */

//Busca en la BBDD los chats de el usuario
//Primera funcion que es llamada
function cargarChats() {
    //Añade además el evenlistener de el boton
    document.getElementById('botonEnviar').addEventListener('click', enviarMensaje);
    document.getElementById('addFriends').addEventListener('click',addFriends);
    document.querySelector('#diffMessage').addEventListener('click', enviarDifusion);
    document.getElementById('divPerf').addEventListener('click',perfil);
    document.getElementById('titulo_').addEventListener('click',perfilP);
    console.log('tu raza gitana ' + currentUser());
    var ruta = Routing.generate('GetChats');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        success: function (data) {
            deleteChats();
            createChats(JSON.parse(data));
            //console.log(JSON.parse(data));
            //console.log('respuesta recibida ' + data);
            cargarGroups();
        }
    });
}

//comprueba que el usuario no tengo mensajes sin leer
function checkRead(chat) {
    var ruta = Routing.generate('CheckReadChats');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(chat),
        success: function (data) {
            if (JSON.parse(data) === "false") {
                document.getElementById('chat_' + chat).style.color = 'red';
            }
        }
    });
}

//Busca en la BBDD los grupos de el usuario
function cargarGroups() {
    var ruta = Routing.generate('GetGroups');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        success: function (data) {
            createGroups(JSON.parse(data));
        }
    });
}

//Abre la conversacion con el usuario y actualiza el estado de leido o no leido
function onClick() {
    clearInterval(intervalConversation);
    if(document.getElementById('botonEnviar').removeEventListener('click', enviarMensajeGroup, true));
        document.getElementById('botonEnviar').removeEventListener('click', enviarMensaje, true);
    document.getElementById('botonEnviar').addEventListener('click', enviarMensaje);
    while (document.getElementById('conver_id').firstChild)
        document.getElementById('conver_id').removeChild(document.getElementById('conver_id').firstChild);
    var destUser = this.id.substring(5, this.id.length);
    //userGlobal = user;
    updateRead(destUser); //linea comentada hasta solucionar el problema
    document.getElementById('divPerf').innerHTML = '' + destUser;
    document.getElementById(this.id).style.color = '#FFFFFF';
    var ruta = Routing.generate('GetConversation');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(destUser),
        success: function (data) {
            cargarConversacion(JSON.parse(data));
            intervalConversation = setInterval(updateConver, 2000, destUser);
        }
    });
}

function onClick2() {
    clearInterval(intervalConversation);
    document.getElementById('botonEnviar').removeEventListener('click', enviarMensaje);
    document.getElementById('botonEnviar').addEventListener('click', enviarMensajeGroup);
    while (document.getElementById('conver_id').firstChild)
        document.getElementById('conver_id').removeChild(document.getElementById('conver_id').firstChild);
    var group = this.id.substring(6, this.id.length);
    //updateRead(destUser); //linea comentada hasta solucionar el problema
    document.getElementById('divPerf').innerHTML = '' + group;
    document.getElementById(this.id).style.color = '#FFFFFF';
    var ruta = Routing.generate('GetConversationGroup');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(group),
        success: function (data) {
            cargarConversacion(JSON.parse(data));
            intervalConversation = setInterval(updateConverGroup,750,group);
        }
    });
}

function enviarDifusion(){
    var n = window.prompt("how many people do you want to write?");
    var arrayUsers = [];
    for (var i = 0; i < n; i++) {
        arrayUsers.push(window.prompt('Destination user name'));
    }
    var msg = window.prompt('What do you want to tell?');
    var ruta = Routing.generate('sendDiffMessage');
    var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(["***DIFUSSION MSG*** " + msg + " ***DIFUSSION MSG***",date,arrayUsers]),
        success: function (data) {
            console.log(JSON.parse(data));
            //cargarConversacion(JSON.parse(data));
            //intervalConversation = setInterval(updateConverGroup,750,group);
        }
    });
}

//actualiza la conversacion
function updateConver(destUser) {
    var ruta = Routing.generate('GetConversation');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(destUser),
        success: function (data) {
            cargarConversacion(JSON.parse(data));
        }
    });
}

function updateConverGroup(group) {
    var ruta = Routing.generate('GetConversationGroup');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(group),
        success: function (data) {
            cargarConversacion(JSON.parse(data));
        }
    });
}

//envia un mensaje
function enviarMensaje() {
    var destUser = document.getElementById('divPerf').innerHTML;
    //console.log(destUser);
    var ruta = Routing.generate('sendMessage');
    var body = document.getElementById('input_msg').value;
    var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify([destUser, body, date]),
        success: function (data) {
            document.getElementById('input_msg').value = '';
            console.log(JSON.parse(data));
        }
    });
}

function enviarMensajeGroup() {
    var group = document.getElementById('divPerf').innerHTML;
    console.log(group);
    var ruta = Routing.generate('sendMessageGroup');
    var body = document.getElementById('input_msg').value;
    var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify([group, body, date]),
        success: function (data) {
            document.getElementById('input_msg').value = '';
            console.log(JSON.parse(data));
        }
    });
}

//atualiza el estado de los mensajes. leidos o no,
function updateRead(destUser) {
    var ruta = Routing.generate('UpdateRead');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(destUser),
        success: function (data) {
            
        }
    });
}

//Add friends
function addFriends() {
    var username = prompt('Introduce the +username');
    var ruta = Routing.generate('addFriends');
    var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify([username, date]),
        success: function (data) {
            alert('Usuario creado correectamente');
        }
    });
}

//cargar perfil
function perfil()
{
    clearInterval(intervalConversation);
    while (document.getElementById('conver_id').firstChild)
        document.getElementById('conver_id').removeChild(document.getElementById('conver_id').firstChild);
    var destUser = document.getElementById('divPerf').innerHTML
    var ruta = Routing.generate('showProfile');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(destUser),
        success: function (data) {
            var arrayTmp=JSON.parse(data);
            var label = document.createElement('label');
            label.innerHTML = 'Name: ';
            var p = document.createElement('textarea');
            p.innerHTML = '' + arrayTmp[0];
            p.id = 'name';
            p.className = 'textarea';
            var label1 = document.createElement('label1');
            label1.innerHTML = 'Address: ';
            var p1 = document.createElement('textarea');
            p1.innerHTML = '' + arrayTmp[1];
            p1.id = 'address';
            p1.className = 'textarea';
            var label2 = document.createElement('label2');
            label2.innerHTML = 'Gmail: ';
            var p2 = document.createElement('textarea');
            p2.innerHTML = '' + arrayTmp[2];
            p2.id = 'mail';
            p2.className = 'textarea';
            var updateBttn = document.createElement('button');
            updateBttn.addEventListener('click', updateInfo);
            updateBttn.innerHTML = 'Update';
            var form = document.createElement('form');
            form.id = 'formImg';
            form.method = 'post';
            form.enctype = 'multipart/form-data';
            
            var foto = document.createElement('input');
            foto.setAttribute("type", "file");
            foto.name = 'myfile';
            foto.id = 'myfile';
            foto.accept = 'image/*';
            foto.style.float = 'left';
        
            var img = document.createElement('img');
            img.src = arrayTmp[3];
            img.setAttribute('url', arrayTmp[3]);
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.float = 'left';
           
            document.getElementById('conver_id').appendChild(img);
            document.getElementById('conver_id').appendChild(label);
            document.getElementById('conver_id').appendChild(p);
            document.getElementById('conver_id').appendChild(label1);
            document.getElementById('conver_id').appendChild(p1);
            document.getElementById('conver_id').appendChild(label2);
            document.getElementById('conver_id').appendChild(p2);
            //document.getElementById('conver_id').appendChild(updateBttn);
            document.getElementById('conver_id').appendChild(form);
            //form.appendChild(foto);
            
           console.log();
        }
    });
}

//cargar perfil
function perfilP()
{
    clearInterval(intervalConversation);
    while (document.getElementById('conver_id').firstChild)
        document.getElementById('conver_id').removeChild(document.getElementById('conver_id').firstChild);
    var currentuser = currentUser();
    document.getElementById('divPerf').innerHTML=currentuser;
    var ruta = Routing.generate('showProfile');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify(currentuser),
        success: function (data) {
            var arrayTmp=JSON.parse(data);
            var label = document.createElement('label');
            label.innerHTML = 'Name: ';
            var p = document.createElement('textarea');
            p.innerHTML = '' + arrayTmp[0];
            p.id = 'name';
            p.className = 'textarea';
            var label1 = document.createElement('label1');
            label1.innerHTML = 'Address: ';
            var p1 = document.createElement('textarea');
            p1.innerHTML = '' + arrayTmp[1];
            p1.id = 'address';
            p1.className = 'textarea';
            var label2 = document.createElement('label2');
            label2.innerHTML = 'Gmail: ';
            var p2 = document.createElement('textarea');
            p2.innerHTML = '' + arrayTmp[2];
            p2.id = 'mail';
            p2.className = 'textarea';
            var updateBttn = document.createElement('button');
            updateBttn.addEventListener('click', updateInfo);
            updateBttn.innerHTML = 'Update';
            var form = document.createElement('form');
            form.id = 'formImg';
            form.method = 'post';
            form.enctype = 'multipart/form-data';
            
            var foto = document.createElement('input');
            foto.setAttribute("type", "file");
            foto.name = 'myfile';
            foto.id = 'myfile';
            foto.accept = 'image/*';
            foto.style.float = 'left';
        
            var img = document.createElement('img');
            img.src = arrayTmp[3];
            img.setAttribute('url', arrayTmp[3]);
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.float = 'left';
           
            document.getElementById('conver_id').appendChild(img);
            document.getElementById('conver_id').appendChild(label);
            document.getElementById('conver_id').appendChild(p);
            document.getElementById('conver_id').appendChild(label1);
            document.getElementById('conver_id').appendChild(p1);
            document.getElementById('conver_id').appendChild(label2);
            document.getElementById('conver_id').appendChild(p2);
            document.getElementById('conver_id').appendChild(updateBttn);
            document.getElementById('conver_id').appendChild(form);
            form.appendChild(foto);
            
           console.log();
        }
    });
}

function updateInfo() {
    var name = document.getElementById('name').value;
    var address = document.getElementById('address').value;
    var mail = document.getElementById('mail').value;
    var foto = document.getElementById('myfile').value;
    document.getElementById('formImg').submit();
    var destUser = document.getElementById('divPerf').innerHTML
    var ruta = Routing.generate('updateProfile');
    $.ajax({
        type: 'POST',
        url: ruta,
        async: true,
        dataType: 'text',
        data: JSON.stringify([destUser,name,address,mail,foto]),
        success: function (data) {
            console.log(data)
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

//Esta funcion carga los grupos de un suario en la página
function createGroups(grupos) {
    for (var i = 0; i < grupos.length; i++) {
        var ele = document.createElement('div');
        ele.id = 'group_' + grupos[i];
        ele.style.textAlign = 'center';
        ele.addEventListener("click", onClick2)
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

//cargra la ocnversacion después de recibirla haciendo click
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







window.onload = cargarChats;