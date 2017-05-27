<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\StudentRecordValue;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecord $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '学员档案管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学员档案管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_id' => $model->student_record_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud student-record-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '学员档案管理') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'student_record_id' => $model->student_record_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'student_record_id' => $model->student_record_id, 'StudentRecord'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\StudentRecord'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            [
            'attribute'=>'user_id',
            'value'=>function($model){
                return isset($model->user->username) ? $model->user->username : '';
                }
            ],
            [
            'attribute'=>'school_id',
            'value'=>function($model){
            return isset($model->school->school_title) ? $model->school->school_title : '';
                }
            ],
            [
                'attribute'=>'grade_id',
                'value'=>function($model){
                    return isset($model->grade->grade_name) ? $model->grade->grade_name  : '';
                }
            ],
            [
                'attribute'=>'course_id',
                'label'    => '课程标题',
                'value'=>function($model){
                    return isset($model->course->title) ? $model->course->title  : '';
                }
            ],
            'title',
            [
                'attribute' => 'status',
                'value' => backend\modules\campus\models\StudentRecord::getStatusLabel($model->status)
            ],
            'sort',
            'updated_at:datetime',
            'created_at:datetime'
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'student_record_id' => $model->student_record_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', '确定要删除该项目吗？') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    <?php  $html = '';  $this->beginBlock('backend\modules\campus\models\StudentRecordValue'); ?>
            <?=  '<div  class="table-responsive">'.$html.\yii\grid\GridView::widget([
                'layout'=>'{summary}{pager}<br/>{items}{pager}',
                'dataProvider'=>  new \yii\data\ActiveDataProvider([
                        'query' => $model->getStudentRecordValue(),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam'=>'page-studentrecordvaluetofiles',
                        ]
                    ]),
                //'filterModel'=> $CoursewareToCoursewareSearch,
                'columns'=>[
                    //'courseware_master_id',
                    'student_record_id',
                    'student_record_key_id',
                    'body',
                    'status',
                    'updated_at:datetime',
                    'created_at:datetime'
                ]
            ]).'</div>'
        ?>
    <?php $this->endBlock(); ?>

<?= Tabs::widget(
        [
                 'id' => 'relation-tabs',
                 'encodeLabels' => false,
                 'items' => [
                [
                        'label'   => '<b class=""># '.$model->student_record_id.'</b>',
                        'content' => $this->blocks['backend\modules\campus\models\StudentRecord'],
                        'active'  => false,
                ],
                [
                        'label'   => '<b class="">学生档案详情 '.$model->getStudentRecordValue()->count().'</b>',
                        'content' => $this->blocks['backend\modules\campus\models\StudentRecordValue'],
                        'active'  => true,
                ],

            ]
        ]
    );
    ?>
</div>
