<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <title>Feature Carousel Demonstration Test</title>
    <link rel="stylesheet" href="css/feature-carousel.css" charset="utf-8" />

    <script src="js/jQuery.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.featureCarousel.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        var carousel = $("#carousel").featureCarousel({
          // include options like this:
          // (use quotes only for string values, and no trailing comma after last option)
          // option: value,
          // option: value
        });

        $("#but_prev").click(function () {
          carousel.prev();
        });
        $("#but_pause").click(function () {
          carousel.pause();
        });
        $("#but_start").click(function () {
          carousel.start();
        });
        $("#but_next").click(function () {
          carousel.next();
        });
      });
    </script>
  </head>
  <body>
  
    <a id="but_prev" href="#">PREV</a> | <a id="but_pause" href="#">PAUSE</a> | <a id="but_start" href="#">START</a> | <a id="but_next" href="#">NEXT</a> 
  
    <div class="carousel-container">
    
      <div id="carousel">
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample1.jpg" /></a>
          <div class="carousel-caption">
            <p>
              This area is typically used to display captions associated with the images. They are set to hide and fade in on rotation.
            </p>
          </div>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample2.jpg" /></a>
          <div class="carousel-caption">
            <p>
              The background will expand up or down to fit the caption.
            </p>
          </div>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample3.jpg" /></a>
          <div class="carousel-caption">
            <p>
              Images can be placed here as well.
            </p>
          </div>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample4.jpg" /></a>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample5.jpg" /></a>
          <div class="carousel-caption">
            <p>
              The background color of the caption area can be changed using CSS. The opacity can be changed in the options, but it will also change the opacity of the text.
            </p>
          </div>
        </div>
      </div>
    
      <div id="carousel-left"><img src="img/arrow-left.png" /></div>
      <div id="carousel-right"><img src="img/arrow-right.png" /></div>
    </div>
  
  </body>
</html>
