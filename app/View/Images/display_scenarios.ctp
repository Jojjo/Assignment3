<script type="text/javascript" src="http://apps.pixlr.com/lib/pixlr.js"></script>

<?php
echo $this->Html->script('jquery');
foreach ($scenarios as $scenario):?>

    <div>
        <p><?php echo $this->Html->link('(' . $scenario['scenarioId'] .') ' . $scenario['title'], array( 'controller' => 'images', 'action' => 'display_scenario', $scenario['scenarioId'])); ?></p>
        <p><strong><?php echo $scenario['description']; ?></strong></p>
    </div>

<?php endforeach ?>


