<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <?=
        yii\widgets\ListView::widget([
            'options' => [
                'tag' => 'div',
            ],
            'dataProvider' => $listDataProvider,
            'itemView' => function ($model, $key, $index, $widget) {
        $itemContent = $this->render('/notice-view-provider/_notice_item', ['model' => $model]);


        return $itemContent;

        /* Or if you just want to display the list item only: */
        // return $this->render('_list_item',['model' => $model]);
    },
            'itemOptions' => [
                'tag' => false,
            ],
            'summary' => '',
            /* do not display {summary} */
            'layout' => '{items}{pager}',
            'pager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
                'maxButtonCount' => 4,
                'options' => [
                    'class' => 'pagination col-xs-12'
                ]
            ],
        ]);
        ?>
    </div>
</div>
