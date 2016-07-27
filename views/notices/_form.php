<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\database\Notices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'notice_type[]')->listBox(\yii\helpers\ArrayHelper::map(\app\models\database\NoticeTypes::find()->all(),'id','type'),['multiple' => true]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
