<?php

use yii\helpers\Html;
?>

<article class="list-item col-sm-12 list-group-item" data-key="<?= $model->id ?>">
    <h3><?= $model->notice->title; ?><?php if ($model->status == 0): ?> <span class="label label-default">New</span><?php endif; ?></h3>
    <p style="margin-left: 25px;"><i><?= $model->notice->text; ?></i></p>
    <?php if ($model->status == 0): ?>
        <a href="<?php
        if (isset($_REQUEST['page']))
            echo yii\helpers\Url::to(['notices/my', 'readId' => $model->id, 'page' => $_REQUEST['page']]);
        else
            echo yii\helpers\Url::to(['notices/my', 'readId' => $model->id]);
        ?>"><button type="button" class="btn btn-default" style="float: right;" aria-label="Left Align">
                Mark as read <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            </button>
        </a>
    <?php endif;
    ?>
</article>