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

                // window dimensions
                var height = $(window).height();
                var width = $(window).width();
                
                // border positions
                var posTop = nav.position().top;
                var posLeft = nav.position().left;

                // center positions
                var centerX = posLeft+nav.width()/2;
                var centerY = posTop+nav.height()/2;

                /*
                console.log("height "+height);
                console.log("width "+width);
                console.log("posTop "+posTop);
                console.log("posLeft "+posLeft);
                console.log("centerX "+centerX);
                console.log("centerY "+centerY);
                */

                // to figure out in which quadrant box is located
                var diffHeight = centerY - (height - centerY);
                var diffWidth = centerX - (width - centerX);

                // distance to borders
                var spaceRight = width-centerX;
                var spaceBottom = height-centerY;

                // positions to move the box
                var rightBorder = width - nav.width();
                var bottomBorder = height - nav.height();


                // could be done nicer with array + switch but it works!
                if (diffHeight < 0 && diffWidth < 0) {
                    // 1st quadrant
                    if (centerX <= centerY) {
                        nav.animate({
                            left: "0"
                        }, 400);
                    } else {
                        nav.animate({
                            top: "0"
                        }, 400);
                    }
                } else if (diffHeight < 0 && diffWidth > 0) {
                    // 2nd quadrant
                    if (spaceRight <= centerY) {
                        nav.animate({
                            left: rightBorder
                        }, 400);
                    } else {
                        nav.animate({
                            top: "0"
                        }, 400);
                    }
                } else if (diffHeight > 0 && diffWidth > 0) {
                    // 3rd quadrant
                    if (spaceBottom <= spaceRight) {
                        nav.animate({
                            top: bottomBorder
                        }, 400);
                    } else {
                        nav.animate({
                            left: rightBorder
                        }, 400);
                    }
                } else if (diffHeight > 0 && diffWidth < 0) {
                    // 4th quadrant
                    if (centerX <= spaceBottom) {
                        nav.animate({
                            left: "0"
                        }, 400);
                    } else {
                        nav.animate({
                            top: bottomBorder
                        }, 400);
                    }
                }

                /*
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
                //nav.animate(animationObj, 5000)
                */
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


        // if box hidden, then drag hamburger icon
        nav.mousedown(function (e) {
            dragging = nav;
        });

        $('.nav-menu').mousedown(function (e) {
            dragging = $('.nav-menu');
        });

        /*
        if !nav.hasClass('hide') {
            nav.mousedown(function (e) {
                dragging = nav;
            });
        } else {
            $('.nav-menu').mousedown(function (e) {
                dragging = nav;
            });
        }
        */

        nav.mouseup(function () {
            dragging = null;
            makeAnimation();
        })


    })
}());