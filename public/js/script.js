
function currentUser(){
        var user = document.getElementById('titulo_').innerHTML.substring(9,document.getElementById('titulo_').innerHTML.length);
        return user;
}

function cargarChats(){
    console.log('tu raza gitana ' + currentUser());
}




window.onload=cargarChats;