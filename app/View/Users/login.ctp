
<?php echo $this->Form->create('User', array('action' => 'login'));?>
<?php echo $this->Form->inputs(array(
        'legend' => __('Login'),
        'username',
        'password'
    )); ?>
<?php    echo $this->Form->end('Login'); ?>

<?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'add')); ?>

