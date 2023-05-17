// fichier de test des webSockets
$(document).ready(function(){

    // NB: la connexion au server node doit etre faite des le chargement de la page, (au debut du script et non dans une fonction)
    // connection du client au server nodejs
    // const socket = io.connect('http://localhost:8090', { transports : ['websocket'] })
    // console.log(socket)

    // $(document).click((e)=>{
    //     // le client emet un evenement qui sera capturer par le server node et reagir en consequence
    //     socket.emit('click', {
    //         nom: "diallo",
    //         prenom: 'mamadou aliou',
    //         action_event: 'click sur le document'
    //     })
    // });

    // capture d'un evenement emit depuis le server
    socket.on("newuser", (user)=>{
        // alert(user.prenom + user.nom + " is registred by the server !");
    })

})