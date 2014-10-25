<?php
	echo $this->Html->script('pixlr');
	echo $this->Html->css('custom');
?>

<?php if(!empty($images)): ?>

    <?php foreach($images as $image): ?>

       <img class='image' src="<?php echo $image ?>"/>

    <?php endforeach; ?>

<?php else: ?>

    <p>This is an empty scenario.</p>
<?php endif; ?>