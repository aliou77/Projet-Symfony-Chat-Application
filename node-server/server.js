const http = require('http')
// import { Server } from "socket.io";

const httpServer = http.createServer(function(req, res){
    // lorsqu'un client me contact je lui repond avec un hello world !
    res.end("hello world")
    // console.log("un client ((navigateur)) m'a contacter et s'est connecter a moi ")
});

// specifi le port ou mon server va ecouter
httpServer.listen(8090)

// -----------------------------

const io = require('socket.io');
// on ecoute les connexions qui se font au niveau de notre server
// le socket s'est connecter a notre
const server = new io.Server();
server.listen(httpServer)
/**
 * apres le demarage du server il est possible d'acceder aux librairies installer en local avec l'url genera par le server
 * http://localhost:8090/socket.io/socket.io.js  
 */

server.on("connection", (socket) => {
    // apres la connexion du client dans ce block le socket est propre a chaque client
    // console.log(`socket ${socket.id} connected`);
  console.log("nouveau user connected")
    user = {}
  // 
  socket.on('chatFormSubmited', (r_user)=>{
    
    user.socketid = socket.id
    if(user.socketid == socket.id){
      console.log("mm user")
    }else{
      console.log("user diff ")
    }
    console.log(user, "--------------------------")
    user.id = r_user.r_id
    // emet a tous les users
    socket.broadcast.emit('getMessage', { 
        id: user.id
    })
  })

  

//   socket.on("clickkk", (user) => {
//     // an event was received from the client
//     console.log(user)

//     // emision d'un event qui sera captuer par le user
//     // NB: cet evenement emit n'affectera que cette <socket> qui est connecter un user specifique
//     // socket.emit("newuser", user);
//     // socket.broadcast.emit("newuser", user); // cet evenement affectera tous les utilisateurs (sauf celui qui a emit l'event) connecter au server node
    
//     // pour informer tous les users mm le user courant
//     // server.emit("newuser", user);
//  });

  // upon disconnection
  socket.on("disconnect", (reason) => {
    console.log(`socket ${socket.id} disconnected due to ${reason}`);
  });

});

// server.listen(httpServer); 
///////////////-----------------------------------------
const socket = io.connect('http://localhost:8090', { transports : ['websocket'] })
// system webSocket
// const web = new myWebSocket()
// emeters
socket.emit('chatFormSubmited', {
    r_id: $(this).children('input#to').val()
})
// handlers
socket.on('getMessage', (r_user)=>{
    alert("from node server: "+r_user.id)
    console.log("hello")
    // apres capture de getMessage from the node server, si le r_id = form d'un input hidden
    // alors c'est a lui que le message est destiner
    // $val = $("form#form-chat").children('input#from').val()
    // console.log($this)
})


