<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Search\Registrations */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registrations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registrations-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Registrations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password',
            'full_name',
            'created_at',
            // 'updated_at',
            // 'status',
            // 'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
