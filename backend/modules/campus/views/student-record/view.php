<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\StudentRecordValue;
use backend\modules\campus\models\StudentRecordValueToFile;

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
    <?php
         if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
    ?>
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
    <?php
        }
    ?>
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
                        'query' => $model->getStudentRecordValue()->andwhere([
                            'not',['student_record_key_id'=>4]]),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam'=>'page-studentrecordvaluetofiles',
                        ]
                    ]),
                //'filterModel'=> $CoursewareToCoursewareSearch,
                'columns'=>[
                    //'courseware_master_id',
                    //'student_record_key_id',
                    [
                        'attribute'=>'标题',
                        'value'    =>function($model){
                            return $model->studentRecordKey->title;
                        }
                    ],
                    'body',
                    [
                        'attribute'=>'status',
                        'label'    =>'状态',
                        'value'    =>function($model){
                            return StudentRecordValue::getStatusValueLabel($model->status);
                        }
                    ],
                    'updated_at:datetime',
                    'created_at:datetime'
                ]
            ]).'</div>'
        ?>
    <?php $this->endBlock(); ?>
<?php $this->beginBlock('backend\modules\campus\models\StudentRecordValueToFile'); 
        $student_record_value_ids  = $model->getStudentRecordValue()->asArray()->all();
        //dump($student_record_value_ids);exit;
        if($student_record_value_ids){
            $student_record_value_ids = ArrayHelper::map($student_record_value_ids,'student_record_value_id','student_record_value_id');
        }
?>
            <?=  '<div  class="table-responsive">'.$html.\yii\grid\GridView::widget([
                'layout'=>'{summary}{pager}<br/>{items}{pager}',
                'dataProvider'=>  new \yii\data\ActiveDataProvider([
                        'query' => StudentRecordValueToFile::find()->where(['student_record_value_id'=>$student_record_value_ids]),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam'=>'page-studentrecordvaluetofiles',
                        ]
                    ]),
                //'filterModel'=> $CoursewareToCoursewareSearch,
                'columns'=>[
                    [
                    'attribute'=>'student_record_value_to_file_id',
                    'label'    => 'id',
                    ],
                    [
                    //'attribute' => '2',
                    'label'     => '内容',
                    'value'     =>function($model){
                        return $model->studentRecordValue->body;
                        }
                    ],
                    [
                        'label' => '文件',
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $grid){
                            $url = $model->fileStorageItem->url.$model->fileStorageItem->file_name;
                            if(strstr($model->fileStorageItem->type,'image')){
                                return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
                            }else{
                                return Html::a($model->fileStorageItem->type, $url, ['title' => '访问','target' => '_blank']);
                            }
                        }
                    ],
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
                [
                        'label'   =>  '<b class="">我的图片'.$model->getStudentRecordValue()->count().'</b>',
                        'content' => $this->blocks['backend\modules\campus\models\StudentRecordValueToFile'],
                        'active'  =>false,
                ]

            ]
        ]
    );
    ?>
</div>
