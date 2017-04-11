<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '文章分类'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-view">

    <p>
        <?php echo Html::a(Yii::t('backend', '更新'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', '删除'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', '确定要删除该项目吗？'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'slug',
            'title',
            'parent.title',
            'status',
        ],
    ]) ?>

</div>
