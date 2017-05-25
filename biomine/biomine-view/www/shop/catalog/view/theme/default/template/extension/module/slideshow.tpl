<div id="slideshow<?php echo $module; ?>" class="owl-carousel" style="opacity: 1;">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <div id="caption_1">
    	<p class="<?php echo $banner['title'];?>">Biomine protects your health forever</p>
    	
    </div>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <div id="caption_2">
    	<p class="<?php echo $banner['title'];?>">GMP Certified Products</p>
    </div>
    <?php } ?>    
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#slideshow<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 20000,         //3000 original
	singleItem: true,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: false,      //true original
	slideSpeed: 12500,      //added after
	paginationSpeed: 5000,  //added after
	rewindSpeed: 5000       //added after
});
-->
</script>
<script>
$(document).ready(function(){
       $("#caption_1").hide();
       $("#caption_1").show(1500);
});


</script>