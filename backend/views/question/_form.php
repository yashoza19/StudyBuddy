<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Cycle;
use backend\models\Level;
use backend\models\Subject;
use backend\models\Topic;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-form">

    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?php 
        $cycle = \app\models\Cycle::find()->all(); 
        $listData=ArrayHelper::map($cycle,'cycle_id','name'); 
    ?>
    <?= $form->field($model, 'cycle_id')->dropdownList($listData,['prompt'=>'Choose...','onchange'=>
        '$.post( "index.php?r=level/cycle-level&cycleid="+$(this).val(), function( data ) {
                  $( "#questions-level_id" ).html( data );
            
                });']) ?>

    <?php 
        $level = \app\models\Level::find()->all(); 
        $listData=ArrayHelper::map($level,'level_id','name'); 
    ?>
    <?= $form->field($model, 'level_id')->dropdownList($listData,['prompt'=>'Choose...','onchange'=>
        '$.post( "index.php?r=subject/level-subject&levelid="+$(this).val(), function( data ) {
                  $( "#questions-subject_id" ).html( data );
            
                });']) ?>

    <?php 
        $subject = \app\models\Subject::find()->all(); 
        $listData=ArrayHelper::map($subject,'subject_id','name'); 
    ?>
    <?= $form->field($model, 'subject_id')->dropdownList($listData,['prompt'=>'Choose...','onchange'=>
        '$.post( "index.php?r=topic/subject-topic&subjectid="+$(this).val(), function( data ) {
                  $( "#questions-topic_id" ).html( data );
            
                });']) ?>

    <?php 
        $topic = \app\models\Topic::find()->all(); 
        $listData=ArrayHelper::map($topic,'topic_id','name'); 
    ?>
    <?= $form->field($model, 'topic_id')->dropdownList($listData,['prompt'=>'Choose...']) ?>

    <?php 
        $year = \app\models\Year::find()->all(); 
        $listData=ArrayHelper::map($year,'year_id','name'); 
    ?>
    <?= $form->field($model, 'year_id')->dropdownList($listData,['prompt'=>'Choose...']) ?>

    <?php 
        $section = \app\models\Section::find()->all(); 
        $listData=ArrayHelper::map($section,'section_id','section_name'); 
    ?>
    <?= $form->field($model, 'section_id')->dropdownList($listData,['prompt'=>'Choose...']) ?>

    <?= $form->field($model, 'status')->dropdownList(array('1'=>'Active','0'=>'InActive'),array('prompt'=>'Select Status')) ?>

    <?= $form->field($model,'file')->fileInput(); ?>

    <?= $form->field($model,'file')->fileInput(); ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
