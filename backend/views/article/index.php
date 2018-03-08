<?php

use common\grid\EnumColumn;
use common\models\ArticleCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Article;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '文章');
$this->params['breadcrumbs'][] = $this->title;
$category = ArticleCategory::find()->orderBy('created_at ASC')->asArray()->all();
$data=[];
foreach ($category as $key => $value) {
    if(empty($value['parent_id'])){
        $prefix = '';
    }else{
        $parent = ArticleCategory::find()->where(['id' => $value['parent_id']])->asArray()->one();
        $prefix = isset($parent['title']) ? $parent['title'].' -> ' : '';
    }
    $data[$value['id']] = $prefix.$value['title'];
}
$model = new Article;
$categories  = $model->category_recursion(ArticleCategory::find()->active()->asArray()->all());
// $categories = ArrayHelper::map($categories, 'id', 'title');
// dump($categories);exit;
?>
<div class="article-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 
            Yii::t('backend', '创建', ['modelClass' => 'Article']),
            ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [

            'id',
            'slug',
            'title',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->title : null;
                },
                'filter' => ArrayHelper::map($categories, 'id', 'title')
            ],
            [
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return isset($model->author->username) ? $model->author->username : '';
                }
            ],
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => [
                    Yii::t('backend', 'Not Published'),
                    Yii::t('backend', 'Published')
                ]
            ],
            'published_at:datetime',
            'created_at:datetime',

            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]); ?>
</div>
