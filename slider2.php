<div class="fondoloko">
	<div class="slider4">
	  <div class="slide"><img src="imagenes/slide2/marca1.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca2.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca3.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca4.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca5.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca1.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca2.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca3.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca4.png"></div>
	  <div class="slide"><img src="imagenes/slide2/marca5.png"></div>
	</div>
</div>
<!-- jQuery library (served from Google) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="include/carousel/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="include/carousel/jquery.bxslider.css" rel="stylesheet" />
<script>
$(document).ready(function(){
  $('.bxslider').bxSlider();
});
</script>
<script>
$(document).ready(function(){
  $('.slider4').bxSlider({
    slideWidth: 350,
    minSlides: 2,
    maxSlides: 4,
    moveSlides: 1,
    slideMargin: 10
  });
});
</script>