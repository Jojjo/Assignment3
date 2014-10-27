<?php echo $this->Html->script('pixlr'); ?>
<?php echo $this->Html->css('custom'); ?>
<?php if(isset($images)):?>
    <p><?php echo $this->Html->link('Delete Dataset', 'http://' . Configure::read('Domain.base') . DIRECTORY_SEPARATOR . Configure::read('Domain.app')  . DIRECTORY_SEPARATOR . 'deletedata' . DIRECTORY_SEPARATOR . $image['datasetId']); ?></p>

    <?php foreach($images as $image): ?>

        <?php if(isset($image['user'])): ?>
            <p>Edited by: <?php echo $image['user']['User']['first_name']; ?> <?php echo $image['user']['User']['last_name']; ?></p>
        <?php endif; ?>

        <p><?php echo $this->Html->link($this->Html->image($image['image'], array('class' => 'image')), 'javascript:pixlr.edit({image:"' . $image['image'] . '", service:"editor", locktarget:"true", redirect:"true", referrer:"mLearn4web", target:"' . Configure::read('Pixlr.updateImage') . $image['name'] . DIRECTORY_SEPARATOR . $image['datasetId']. DIRECTORY_SEPARATOR . $user .'", exit:"' . Configure::read('Pixlr.exit') . $scenarioId. '"});', array('escape' => false)); ?></p>
        <p><?php echo $this->Html->link('Create new version', 'javascript:pixlr.edit({image:"' . $image['image'] . '", service:"editor", locktarget:"true", redirect:"true", referrer:"mLearn4web", target:"' . Configure::read('Pixlr.duplicateImage') . $image['name'] . DIRECTORY_SEPARATOR . $image['datasetId']. DIRECTORY_SEPARATOR . $user .'", exit:"' . Configure::read('Pixlr.exit') . $scenarioId. '"});', array('escape' => false)); ?></p>

    <?php endforeach; ?>

<?php else: ?>

	<p>This is an empty scenario.</p>

<?php endif; ?>