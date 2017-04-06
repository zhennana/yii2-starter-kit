<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

$CoursewareToFileSearch = new \backend\modules\campus\models\search\CoursewareToFileSearch;
$CoursewareToFileDataProvider = $CoursewareToFileSearch->search($_GET);
$CoursewareToFileDataProvider->query->andwhere(['courseware_id'=>$model->courseware_id]);
$CoursewareToFileDataProvider->query->orderby(['sort'=>SORT_DESC]);

$CoursewareToCoursewareSearch  = new \backend\modules\campus\models\search\CoursewareToCoursewareSearch;
$CoursewareToCoursewareDataProvider = $CoursewareToCoursewareSearch->search($_GET);
$CoursewareToCoursewareDataProvider->query->andwhere(['courseware_id'=>$model->courseware_id]);
$CoursewareToCoursewareDataProvider->query->orderby(['sort'=>SORT_DESC]);

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Courseware $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '课件详情');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'courseware_id' => $model->courseware_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud courseware-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '课件') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '修改'),
            [ 'update', 'courseware_id' => $model->courseware_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '克隆'),
            ['create', 'courseware_id' => $model->courseware_id, 'Courseware'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>
    <br />
    <div>
        <?php $html = '<br />'.Html::a('创建课件关系',['courseware-to-courseware/create','courseware_id'=>$model->courseware_id],['class'=>'btn btn-success']).'<br  />'?>
    </div>
    <hr />
    <br />
    <?php $this->beginBlock('backend\modules\campus\models\Courseware'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'parent_id',
        [
            'attribute'=>'category_id',
            'value'    =>isset($model->coursewareCategory->name) ? $model->coursewareCategory->name : ''
        ],
        'title',
        'tags',
        'level',
        [
            'attribute'=>'creater_id',
            'value'    =>isset($model->user->username) ? $model->user->username : ''
        ],
        'body:ntext',
        'file_counts',
        'page_view',

        [
            'attribute'=>'status',
            'value'=>\backend\modules\campus\models\Courseware::getStatusValueLabel($model->status)
        ],
        'access_domain',
        'access_other',
        
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'courseware_id' => $model->courseware_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>
    

    <?php $this->beginBlock('backend\modules\campus\models\CoursewareToFile');?>
    <div>
    <?php
        $qiniu = '<div>'.common\widgets\Qiniu\UploadCourseware::widget([
                'uptoken_url' => yii\helpers\Url::to(['token-cloud']),
                'upload_url'  => yii\helpers\Url::to(['upload-cloud','courseware_id'=>$model->courseware_id]),
                        //'delete_url'  => yii\helpers\Url::to(['delete-cloud'])
            ]).'</div><br /> ';
    ?>
    </div>
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main1', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
        <?php
            
            echo   '<div  class="table-responsive">'.$qiniu.\yii\grid\GridView::widget([
                'layout'=>'{summary}{pager}<br/>{items}{pager}',
                'dataProvider'=>$CoursewareToFileDataProvider,
                'filterModel'=> $CoursewareToFileSearch,
                'columns'=>[
                     [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'courseware-to-file',
                        'template' => '{update} {delete}'
                    ],
                    
                    'courseware_id',
                    [
                        'class'     => \common\grid\EnumColumn::ClassName(),
                        'format'    => 'raw',
                        'attribute' => 'status',
                        'enum'      => \backend\modules\campus\models\CoursewareToFile::optsStatus(),
                    ],
                    'sort',
                    'file_storage_item_id',
                    [
                        'attribute' => 'base_url',
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
                    [
                        'attribute'=>'type',
                        'label' => '类型',
                        'format'    => 'raw',
                        'value'    =>function($model){
                            if(isset($model->fileStorageItem->type)){
                                 return $model->fileStorageItem->type;
                                
                            }
                            return '';
                        }
                    ],
                    [
                        'attribute'=>'page_view',
                        'label' => '预览量',
                        'format'    => 'raw',
                        'value'    =>function($model){
                            if(isset($model->fileStorageItem->page_view)){
                                 return $model->fileStorageItem->page_view;
                                
                            }
                            return '';
                        }
                    ],
                   'updated_at:datetime',
                    'created_at:datetime'
                ]
            ]).'</div>'
        ?>
        <?php \yii\widgets\Pjax::end() ?>
    <?php $this->endBlock()?>

     <?php $this->beginBlock('backend\modules\campus\models\CoursewareToCourseware')?>
     <?php \yii\widgets\Pjax::begin([
                'id'=>'pjax-main',
                'enableReplaceState'=> false, 
                'linkSelector'=>'#pjax-main ul.pagination a, th a',
                'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) 
            ?>
        <?=  '<div  class="table-responsive">'.$html.\yii\grid\GridView::widget([
                'layout'=>'{summary}{pager}<br/>{items}{pager}',
                'dataProvider'=> $CoursewareToCoursewareDataProvider,
                'filterModel'=> $CoursewareToCoursewareSearch,
                'columns'=>[
                    //'courseware_master_id',
                    [
                        'attribute'=>'courseware_master_id',
                        'format'    => 'raw',
                        'value'=>function($model){
                            return 'master_id:'.$model->courseware_master_id."<br />".$model->coursewareMaster->title;
                        }
                    ],
                    [
                        'attribute'=>'courseware_id',
                        'format'    => 'raw',
                        'value'=>function($model){
                            return 'courseware_id:'.$model->courseware_id."<br />".$model->courseware->title;
                        }
                    ],
                    'sort',
                     [
                        'class'     => \common\grid\EnumColumn::ClassName(),
                        'format'    => 'raw',
                        'attribute' => 'status',
                        'enum'      => \backend\modules\campus\models\CoursewareToCourseware::optsStatus(),
                    ],
                    'updated_at:datetime',
                    'created_at:datetime'
                ]
            ]).'</div>'
        ?>
        <?php \yii\widgets\Pjax::end() ?>
    <?php $this->endBlock()?>
    
    <?= Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
            'label'   => '<b class="">课件ID # '.$model->courseware_id.'</b>',
            'content' => $this->blocks['backend\modules\campus\models\Courseware'],
            'active'  => false,
            ],
            [
            //'content' => $this->blocks['CoursewareToFile'],
            'label'   => '<b class="">附件</b>',
            'content' => $this->blocks['backend\modules\campus\models\CoursewareToFile'],
            'active'  => true,
            ],
            [
            'label'   => '<b class="">关联课件</b>',
            'content' => $this->blocks['backend\modules\campus\models\CoursewareToCourseware'],
            'active'  => false,
            ],
        ]
    ]);
    ?>
</div>
