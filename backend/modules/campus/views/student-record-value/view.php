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
* @var backend\modules\campus\models\StudentRecordValue $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '成绩管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '成绩管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->student_record_value_id, 'url' => ['view', 'student_record_value_id' => $model->student_record_value_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud student-record-value-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '成绩管理') ?>
        <small>
            <?= $model->student_record_value_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'student_record_value_id' => $model->student_record_value_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'student_record_value_id' => $model->student_record_value_id, 'StudentRecordValue'=>$copyParams],
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

    <?php $this->beginBlock('backend\modules\campus\models\StudentRecordValue'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'student_record_value_id',
        [
            'attribute' => 'school_id',
            'value' => function($model){
                return isset($model->school) ? $model->school->school_title : '';
            }
        ],
        [
            'attribute' => 'grade_id',
            'value' => function($model){
                return isset($model->grade) ? $model->grade->grade_name : '';
            }
        ],
        [
            'attribute' => 'student_record_key_id',
            'label' => '科目标题',
            'value' => function($model){
                if (isset($model->studentRecordKey) && !empty($model->studentRecordKey->title)) {
                    return $model->studentRecordKey->title;
                }
                return '无标题';
            }
        ],
        [
            'attribute' =>'user_id',
            'label'     => '姓名',
            'format'    => 'raw',
            'value'     => function($model){
                return  Html::a('[id'.$model->user_id.']-'.Yii::$app->user->identity->getUserName($model->user_id),[
                    'user-to-school/account',
                    'user_id'=>$model->user_id
                    ]);
            }
        ],
        // 'student_record_id',
        [
            'attribute' => 'exam_type',
            'value' => function($model){
                return StudentRecordValue::getExamTypeLabel($model->exam_type);
            }
        ],
        'total_score',
        'score',
        // 'body',
        [
            'attribute' => 'status',
            'value' => function($model){
                return StudentRecordValue::getStatusValueLabel($model->status);
            }
        ],
        'sort',
    ],
    ]); ?>

    
    <hr/>

    <!--<?php /* Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'student_record_value_id' => $model->student_record_value_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); */ ?>-->
    <?php $this->endBlock(); ?>


    
<?php $this->beginBlock('StudentRecordValueToFiles'); ?>

<div style='position: relative'>
    <div style='position:absolute; right: 0px; top: 0px;'>
      <!--<?php /* Html::a(
                '<span class="glyphicon glyphicon-list"></span> ' . Yii::t('backend', 'List All') . ' Student Record Value To Files',
                ['student-record-value-to-file/index'],
                ['class'=>'btn text-muted btn-xs']
            ) */ ?>-->
      <!--<?php /* Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New') . ' Student Record Value To File',
                ['student-record-value-to-file/create', 'StudentRecordValueToFile' => ['student_record_value_id' => $model->student_record_value_id]],
                ['class'=>'btn btn-success btn-xs']
            ); */ ?>-->
    </div>
</div>

<?php Pjax::begin([
    'id'=>'pjax-StudentRecordValueToFiles',
    'enableReplaceState'=> false,
    'linkSelector'=>'#pjax-StudentRecordValueToFiles ul.pagination a, th a',
    'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']
]) ?>
<?php
    $qiniu = '';
    if(Yii::$app->user->can('manager') ||  \Yii::$app->user->can('E_manager')){
        $qiniu = '<div>'.common\widgets\Qiniu\UploadCourseware::widget([
                'uptoken_url' => yii\helpers\Url::to(['token-cloud']),
                'upload_url'  => yii\helpers\Url::to(['upload-cloud','student_record_value_id'=>$model->student_record_value_id]),
                        //'delete_url'  => yii\helpers\Url::to(['delete-cloud'])
            ]).'</div><br /> ';
    }
?>

<?= '<div class="table-responsive">' .$qiniu. \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getStudentRecordValueToFile(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-studentrecordvaluetofiles',
        ]
    ]),
    'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('backend', '首页'),
        'lastPageLabel'  => Yii::t('backend', '尾页')
    ],
    'columns' => [
        [
            'class'      => 'yii\grid\ActionColumn',
            'template'   => '{view} {update}',
            'contentOptions' => ['nowrap'=>'nowrap'],
            'urlCreator' => function ($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = 'student-record-value-to-file' . '/' . $action;
                $params['StudentRecordValueToFile'] = ['student_record_value_id' => $model->primaryKey()[0]];
                return $params;
            },
            'buttons'    => [

            ],
            'controller' => 'student-record-value-to-file'
        ],
        'student_record_value_to_file_id',
        'student_record_value_id',
        // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
        [
            'class' => yii\grid\DataColumn::className(),
            'attribute' => 'file_storage_item_id',
            'value' => function ($model) {
                if ($rel = $model->getFileStorageItem()->one()) {
                    return Html::a($rel->file_storage_item_id, ['file-storage-item/view', 'file_storage_item_id' => $rel->file_storage_item_id,], ['data-pjax' => 0]);
                } else {
                    return '';
                }
            },
            'format' => 'raw',
        ],
    ]
])  . '</div>';  ?>

<?php Pjax::end() ?>
<?php $this->endBlock() ?>


    <?= Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'label'   => '<b class=""># '.$model->student_record_value_id.'</b>',
                'content' => $this->blocks['backend\modules\campus\models\StudentRecordValue'],
                'active'  => true,
            ],
            [
                'content' => $this->blocks['StudentRecordValueToFiles'],
                'label'   => '<small>成绩单<span class="badge badge-default">'.count($model->getStudentRecordValueToFile()->asArray()->all()).'</span></small>',
                'active'  => false,
            ],
        ]
    ]); ?>
</div>
