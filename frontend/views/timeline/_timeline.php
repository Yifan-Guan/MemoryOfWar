<?php
use yii\helpers\Html;

/* @var $events array */
?>

<div class="">
    <?php foreach ($events as $phase => $phaseEvents): ?>
        <h3 class=""><?= Html::encode($phase) ?></h3>
        
        <ul class="list-group">
            <?php foreach ($phaseEvents as $event): ?>
                <li class="list-group-item event-item" data-id="<?= $event->id ?>">
                    <div class="event-title"><?= Html::encode($event->title) ?></div>
                    <?php if ($event->date): ?>
                        <div class="event-date"><?= Html::encode($event->date) ?></div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>