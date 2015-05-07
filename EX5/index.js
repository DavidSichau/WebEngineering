var express = require('express');
var app = express();
var http = require('http').Server(app);

var io = require('socket.io')(http);


app.use(express.static('public'));

http.listen(8080, function(){
    console.log('listening on *:8080');
});


io.on('connection', function (socket) {
    socket.on('show_image', function (data) {
        socket.broadcast.emit('show_image', data);
    });

    socket.on('register', function(data) {
        socket.broadcast.emit('register', {
            id: socket.id,
            name: data.name
        });
    });

    socket.on('registerRemote', function() {
        socket.broadcast.emit('registerRemote', socket.id);
    });

    socket.on('disconnect', function() {
        io.emit('discon', {
            id: socket.id
        });
    })

});