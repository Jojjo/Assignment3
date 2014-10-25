

<?php if(!empty($images)): ?>

    <?php foreach($images as $image): ?>

        <?php echo $this->Html->link($this->Html->image($image), 'javascript:pixlr.edit({image:"' . $image . '", service:"express", target:"' . Configure::read('Pixlr.save') . '", exit:"' . Configure::read('Pixlr.return') . $scenarioId . '"});', array('escape' => false)); ?>

    <?php endforeach; ?>

<?php else: ?>

    <p>This is an empty scenario.</p>
<?php endif; ?>