<?php echo $this->Html->script('pixlr'); ?>
<?php echo $this->Html->css('custom');   ?>
<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'logoutLink')); ?>
<?php if(!empty($images)):?>

    <?php if($auth['Group']['name'] == 'Teachers' || $auth['Group']['name'] == 'Administrators'): ?>

        <p>You have sufficient permissions to <?php echo $this->Html->link('Delete Dataset',  array('controller' => 'images', 'action' => 'delete_scenario_datasets', $scenarioId)); ?></p>

    <?php else: ?>

        <p>You are a student and do not have the necessary privileges to delete <?php echo $scenarioId; ?>'s datasets.</p>

    <?php endif; ?>

    <?php foreach($images as $image): ?>

        <?php if(isset($image['user'])): ?>
            <p>Edited by: <?php echo $image['user']['User']['first_name']; ?> <?php echo $image['user']['User']['last_name']; ?></p>

        <?php endif; ?>

        <?php if(isset($image['version'])): ?>
            <p>Image version: <?php echo $image['version']; ?></p>
        <?php endif; ?>

        <p><?php echo $this->Html->link($this->Html->image($image['image'], array('class' => 'image')), 'javascript:pixlr.edit({image:"' . $image['image'] . '", service:"editor", locktarget:"true", redirect:"true", referrer:"mLearn4web", target:"' . Configure::read('Pixlr.updateImage') . $image['name'] . DIRECTORY_SEPARATOR . $image['datasetId']. DIRECTORY_SEPARATOR . $user .'", exit:"' . Configure::read('Pixlr.exit') . $scenarioId. '"});', array('escape' => false)); ?></p>
        <p><?php echo $this->Html->link('Create new version', 'javascript:pixlr.edit({image:"' . $image['image'] . '", service:"editor", locktarget:"true", redirect:"true", referrer:"mLearn4web", target:"' . Configure::read('Pixlr.duplicateImage') . $image['name'] . DIRECTORY_SEPARATOR . $image['datasetId']. DIRECTORY_SEPARATOR . $user .'", exit:"' . Configure::read('Pixlr.exit') . $scenarioId. '"});', array('escape' => false)); ?></p>

    <?php endforeach; ?>

<?php else: ?>

	<p>This is an empty scenario. You can populate the dataset with Bender Rodriguez to simulate image upload.</p>

<!--    --><?php //if($auth['Group']['name'] == 'Teachers' || $auth['Group']['name'] == 'Administrators'): ?>

        <?php echo $this->Html->link('Populate dataset with Bender Rodriguez', array('controller' => 'images', 'action' => 'create_dataset', $scenarioId)); ?>

<!--    --><?php //else: ?>
<!---->
<!--        <p>You are a student and do not have the necessary privileges to create Bender Rodriguez</p>-->
<!---->
<!--    --><?php //endif; ?>

<?php endif; ?>