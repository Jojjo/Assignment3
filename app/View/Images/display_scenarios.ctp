<script type="text/javascript" src="http://apps.pixlr.com/lib/pixlr.js"></script>

<?php
echo $this->Html->script('jquery');
foreach ($scenarios as $scenario):?>

    <?php echo $this->Html->link($scenario, array('action' => 'display_scenario', $scenario)); ?>

    <div>
        <p><strong id="title_<?php echo $scenario; ?>"></strong></p>
        <p><strong id="desc_<?php echo $scenario; ?>"></strong></p>
    </div>

    <script type="application/javascript">
        $.ajax({
            url: "http://localhost/images/proxy/get/<?php echo $scenario; ?>",
            cache: false
        }).done(function (html) {
            var scenario = jQuery.parseJSON(html)
            console.log(scenario);
            $('#title_<?php echo $scenario; ?>').html(scenario.title);
            $('#desc_<?php echo $scenario; ?>').html(scenario.description);
        });
    </script>
<?php endforeach ?>


