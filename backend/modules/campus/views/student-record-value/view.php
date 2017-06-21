<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', 'Student Record Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Values'), 'url' => ['index']];
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
        <?= Yii::t('backend', 'Student Record Value') ?>
        <small>
            <?= $model->student_record_value_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
            [ 'update', 'student_record_value_id' => $model->student_record_value_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
            ['create', 'student_record_value_id' => $model->student_record_value_id, 'StudentRecordValue'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\StudentRecordValue'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'student_record_key_id',
        'student_record_id',
        'body',
        'status',
        'sort',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'student_record_value_id' => $model->student_record_value_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
<?php $this->beginBlock('StudentRecordValueToFiles'); ?>
<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
  <?= Html::a(
            '<span class="glyphicon glyphicon-list"></span> ' . Yii::t('backend', 'List All') . ' Student Record Value To Files',
            ['student-record-value-to-file/index'],
            ['class'=>'btn text-muted btn-xs']
        ) ?>
  <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New') . ' Student Record Value To File',
            ['student-record-value-to-file/create', 'StudentRecordValueToFile' => ['student_record_value_id' => $model->student_record_value_id]],
            ['class'=>'btn btn-success btn-xs']
        ); ?>
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-StudentRecordValueToFiles', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-StudentRecordValueToFiles ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getStudentRecordValueToFiles(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-studentrecordvaluetofiles',
        ]
    ]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('backend', 'First'),
        'lastPageLabel'  => Yii::t('backend', 'Last')
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
])
 . '</div>' 
?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


    <?= Tabs::widget(
                 [
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
    'label'   => '<small>Student Record Value To Files <span class="badge badge-default">'.count($model->getStudentRecordValueToFiles()->asArray()->all()).'</span></small>',
    'active'  => false,
],
 ]
                 ]
    );
    ?>
</div>
