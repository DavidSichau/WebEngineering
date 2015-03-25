/**
 * Created by dsichau on 19.03.15.
 */



(function() {
    $(document).ready(function () {

        var nav = $('#animated');
        //variable where isSticky state is stored
        var isSticky = false;
        var dragging = null;

        //listen to window resize
        $( window ).resize(function() {
            makeAnimation();
        });

        var makeAnimation = function () {

            if(!isSticky) {

                // window dimensions
                var height = $(window).height();
                var width = $(window).width();
                console.log(width);
                
                // border positions
                var posTop = nav.position().top;
                var posLeft = nav.position().left;

                // center positions
                var centerX = posLeft+nav.width()/2;
                var centerY = posTop+nav.height()/2;

                // to figure out in which quadrant box is located
                var diffHeight = centerY - (height - centerY);
                var diffWidth = centerX - (width - centerX);

                // distance to borders
                var spaceRight = width-centerX;
                var spaceBottom = height-centerY;

                // positions to move the box
                var rightBorder = width - nav.width() - 10;
                var bottomBorder = height - nav.height() - 10;
                //change behaviour when only hamburger is visible
                if(nav.hasClass('hide')) {
                    rightBorder = width - $('.nav-menu').width() -10;
                    bottomBorder = height - $('.nav-menu').height() -10;
                }


                var animationTime = 400;
                // could be done nicer with array + switch but it works!
                if (diffHeight < 0 && diffWidth < 0) {
                    // 1st quadrant
                    if (centerX <= centerY) {
                        nav.animate({
                            left: "10"
                        }, animationTime);
                    } else {
                        nav.animate({
                            top: "10"
                        }, animationTime);
                    }
                } else if (diffHeight < 0 && diffWidth > 0) {
                    // 2nd quadrant
                    if (spaceRight <= centerY) {
                        nav.animate({
                            left: rightBorder
                        }, animationTime);
                    } else {
                        nav.animate({
                            top: "10"
                        }, animationTime);
                    }
                } else if (diffHeight > 0 && diffWidth > 0) {
                    // 3rd quadrant
                    if (spaceBottom <= spaceRight) {
                        nav.animate({
                            top: bottomBorder
                        }, animationTime);
                    } else {
                        nav.animate({
                            left: rightBorder
                        }, animationTime);
                    }
                } else if (diffHeight > 0 && diffWidth < 0) {
                    // 4th quadrant
                    if (centerX <= spaceBottom) {
                        nav.animate({
                            left: "10"
                        }, animationTime);
                    } else {
                        nav.animate({
                            top: bottomBorder
                        }, animationTime);
                    }
                }
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
            console.log(dragging)
            if(!dragging){
                makeAnimation()
            }
        });

        nav.on('click', '.nav-sticky' , function () {
            console.log('clicl nav-sticky')
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
            if(!dragging) {
                makeAnimation();//restart the animation
            }
        });


        nav.mousedown(function (e) {
            dragging = nav;
        });

        $(window).mouseup(function() {
            if(dragging) {
                dragging = null;
                makeAnimation();
            }
        })





    })
}());