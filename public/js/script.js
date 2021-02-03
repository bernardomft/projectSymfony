
function currentUser(){
        var user = document.getElementById('titulo_').innerHTML.substring(9,document.getElementById('titulo_').innerHTML.length);
        return user;
}

function cargarChats(){
    console.log('tu raza gitana ' + currentUser());
    var ruta = Routing.generate('GetChats');
    $.ajax({
        type: 'POST',
        url: ruta,
        data: ({username: currentUser()}),
        async: true,
        dataType: 'text',
        success: function (data){
            console.log('respuesta recibida' + data);
        }
    });
    
}




window.onload=cargarChats;