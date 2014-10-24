<script type="text/javascript" src="http://apps.pixlr.com/lib/pixlr.js"></script>

<?php 
echo $this->Html->script('pixlr');

foreach($images as $image){
	echo "<img id='image' src='".$image."'/>";
}


?>