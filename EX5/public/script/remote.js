var currentImage = 0; // the currently selected image
var imageCount = 7; // the maximum number of images available
var socket = null;




var Screen = function(name, connected, socketid) {
    var self = this;
    self.name = ko.observable(name);
    self.connected = ko.observable(!!connected);
    self.id = socketid;
    self.connect =  function() {
        self.connected(true);
        sendImages();
    };
    self.disconnect =  function() {
        self.connected(false);
        sendImages();
    };
};

var viewModel = {
    Screens: ko.observableArray( [
    ] )
};

var sendImages = function() {
    // Send the command to the screen
    if(socket) {
        var screens  = [];
        viewModel.Screens().forEach(function (el) {
            if(el.connected()) {
                screens.push(el.name());
            }
        });
        socket.emit('show_image', {
            img: currentImage,
            screens: screens
        });
    }
};


ko.applyBindings(viewModel);

function showImage (index){
    // Update selection on remote
    currentImage = index;
    var images = document.querySelectorAll("img");
    document.querySelector("img.selected").classList.toggle("selected");
    images[index].classList.toggle("selected");

    sendImages();
}

function initialiseGallery(){
    var container = document.querySelector('#gallery');
    var i, img;
    for (i = 0; i < imageCount; i++) {
        img = document.createElement("img");
        img.src = "images/" +i +".jpg";
        document.body.appendChild(img);
        var handler = (function(index) {
            return function() {
                showImage(index);
            }
        })(i);
        img.addEventListener("click",handler);
    }

    document.querySelector("img").classList.toggle('selected');
}

document.addEventListener("DOMContentLoaded", function(event) {
    initialiseGallery();

    document.querySelector('#toggleMenu').addEventListener("click", function(event){
        var style = document.querySelector('#menu').style;
        style.display = style.display == "none" || style.display == ""  ? "block" : "none";
    });
    connectToServer();
});

function connectToServer(){
    var con = io.connect('http://localhost:8080');
    con.on('connect', function () {
        socket = con;
        socket.emit('registerRemote');

        socket.on('register', function(obj) {
            var element = null;
            viewModel.Screens().forEach(function (el) {
                if(el.name() === obj.name) {
                    element = el;
                }
            });
            //only insert if not exists
            if(!element) {
                viewModel.Screens.push(
                    new Screen(obj.name, false, obj.id)
                )
            }
        });

        socket.on('discon', function (data) {
            var element = null;
            viewModel.Screens().forEach(function (el) {
                if(el.id === data.id) {
                    element = el;
                }
            });
            if(element) {
                viewModel.Screens.remove(element);
            }
        })
    });
}