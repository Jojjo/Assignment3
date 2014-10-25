<?php echo $this->Html->script('pixlr'); ?>

<?php if(!empty($images)): ?>

    <?php foreach($images as $image): ?>

       <img id='image' src="<?php echo $image ?>"/>

    <?php endforeach; ?>

<?php else: ?>

    <p>This is an empty scenario.</p>
<?php endif; ?>