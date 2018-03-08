<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories common\models\ArticleCategory[] */
/* @var $form yii\bootstrap\ActiveForm */
// var_dump(Yii::$app->language);exit;
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', '如果该字段留空，系统将自动生成一个slug'))
        ->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories,
            'id',
            'title'
        ), ['prompt'=>'']) ?>

    <?php echo $form->field($model, 'body')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'minHeight' => 300,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                //'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    )->label(Yii::t('backend','内容')) ?>

    <?php 
    /*echo $form->field($model, 'thumbnail')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);*/
    ?>

    <?php 
    /*echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]);*/
    ?>

    <?php echo $form->field($model, 'view')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'page_rank')->textInput(['maxlength' => true])->label(Yii::t('backend', '排序'))->hint(Yii::t('backend', '由大到小降序排列')) ?>

    <?php 
        if($model->isNewRecord){
            $model->published_at = time();
        }
        echo $form->field($model, 'published_at')->widget(
        DateTimeWidget::className(),
        [
            'locale'            => Yii::$app->language,
            'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
        ]
    ) ?>
    <?php echo $form->field($model, 'status')->checkbox() ?>
    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
   <?php
        if(!$model->isNewRecord){
            echo common\widgets\Qiniu\UploadBackendArticle::widget(
            [
                'uptoken_url' => yii\helpers\Url::to(['article/token-cloud']),
                'upload_url' => yii\helpers\Url::to(['article/upload-cloud']),
                'article_id' => $model->id,
            ]);
            echo Html::hiddenInput('article_id', $model->id,['id'=>'article_id']);
        }

    ?>

    <?php
    if($model->id && !empty($model->id)){
        echo GridView::widget([
            'dataProvider' =>new \yii\data\ActiveDataProvider( [
                        'query'=> $model->getArticleAttachments(),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam'=>'page-studentrecordvaluetofiles',
                        ]
                ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    /*
                [
                    'attribute' => 'component',
                    'filter' => $components
                ],
                */
               'id',
                [
                    'attribute' => 'base_url',
                    'format' => 'raw',
                    'value' => function($model, $key, $index, $grid){
                        $url = $model->base_url.'/'.$model->path;
                        if(strstr($model->type,'image')){
                            return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
                        }else{
                            return Html::a('访问', $url, ['title' => '访问','target' => '_blank']);
                        }
                    }
                ],
               /* ['attribute' =>'user_id', 'label'=>'用户','value'=>function($model){ 
                    if(empty($model->user_id)){
                        return;
                    }
                    $owner = User::findOne($model->user_id)->attributes;
                    //var_dump($owner);exit();
                    return empty($owner['realname']) ? $owner['username'] : $owner['realname'];
                }],*/
               // 'path',
                [
                    'attribute'=>'path',
                    'value' =>function($model){
                        return $model->base_url.'/'.$model->path;
                    }
                ],
                'type',
                'size:size',
                'name',
                // [
                //     'class'=>\common\grid\EnumColumn::className(),
                //     'attribute'=>'status',
                //     'enum'=>[
                //         FileStorageItem::STATUS_PUBLIC => Yii::t('backend', '发布'),
                //         FileStorageItem::STATUS_PRIVATE => Yii::t('backend', '私有')
                //     ]
                // ],
                'upload_ip',
                'created_at:datetime',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                           'urlCreator' => function($action, $model, $key, $index) {
                            // using the column name as key, not mapping to 'id' like the standard generator
                        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                        if($action == 'delete'){
                            \Yii::$app->session['__crudReturnUrl']  = ['/article/update','id'=>$model->article_id];
                            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . 'delete-attachments' : $action;
                        }else{
                            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                        }
                        //var_dump($model,$key,$index,$action,Yii::$app->controller->id);exit;
                       // var_dump($params);exit;
                        return Url::toRoute($params);
            },
                ]
            ]
        ]);
    }
    ?>