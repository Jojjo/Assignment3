<script type="text/javascript" src="http://apps.pixlr.com/lib/pixlr.js"></script>

<?php 
echo $this->Html->script('pixlr');
echo $this->Html->css('custom');
$i=0;
foreach($images as $image){
	echo "<img class='image' onclick='onImageClick(".$image.")' src='".$image."'/>";
	$i++;
}

?>