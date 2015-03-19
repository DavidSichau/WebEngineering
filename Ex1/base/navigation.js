/**
 * Created by dsichau on 19.03.15.
 */



(function() {
    $(document).ready(function () {

        var nav = $('#animated');
        //variable where isSticky state is stored
        var isSticky = false;
        var dragging = null;


        var makeAnimation = function () {
            if(!isSticky) {

                var height = $(window).height();
                var widht = $(window).width();
                var posTop = nav.position().top;
                var posLeft = nav.position().left;

                var animationObj = {

                };
                if(height/2 < posTop) {
                    animationObj.top = 0;
                } else {
                    animationObj.bottom = 0;
                }

                if(widht/2 < posLeft) {
                    animationObj.left = 0;
                } else {
                    animationObj.right = 0;
                }



                //make nice animation to neares border
                nav.animate(animationObj, 5000)
            }
        };


        $('body').on("mousemove", function(e) {
            //we need better snapping at the moment the top corner
            //also some samall ui snitches
            if (dragging) {
                dragging.offset({
                    top: e.pageY,
                    left: e.pageX
                });
            }
        });


        nav.on('click', '.nav-menu', function () {
            nav.toggleClass('hide');
        });

        nav.on('click', '.nav-sticky' , function () {
            isSticky = !isSticky;
            if(isSticky) {
                nav.stop(true);//stop animation
                $(this).attr("src", "images/Navigation/sticky_icon_off.png");
            } else {
                makeAnimation();//start animation
                $(this).attr("src", "images/Navigation/sticky_icon_on.png");
            }
        });

        nav.hover(function () {
            nav.css({ opacity: 1 });
            nav.stop(true);//stop the animation on hover
        }, function(){
            nav.css({ opacity: 0.25 });
            makeAnimation();//restart the animation
        });


        nav.mousedown(function (e) {
            dragging = nav;
        });
        nav.mouseup(function () {
            dragging = null;
            makeAnimation();
        })


    })
























}());