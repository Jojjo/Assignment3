<script type="text/javascript" src="http://apps.pixlr.com/lib/pixlr.js"></script>

<?php 
echo $this->Html->script('pixlr');
echo $this->Html->css('custom');

foreach($images as $image){
	echo "<img src='".$image."'/>";
}

?>