<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NoticeTypes */

$this->title = 'Create Notice Types';
$this->params['breadcrumbs'][] = ['label' => 'Notice Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
