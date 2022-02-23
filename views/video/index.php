<?php

/**
 * @var yii\web\View $this
 * @var \yii\data\DataProviderInterface $dataProvider
 */

declare(strict_types=1);

$this->title = 'My Yii Application';

?>

<div class="page-video-list">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
    </div>

    <div class="sorting">
        <?= \yii\helpers\Html::beginForm([null, 'page' => 1], 'get'); ?>

        <p class="lead">
            Sorting by
            <?= $dataProvider->getSort()->link('created_at'); ?>,
            <?= $dataProvider->getSort()->link('views'); ?>;
            Show
            <?= \yii\helpers\Html::dropDownList(
                $dataProvider->getPagination()->pageSizeParam,
                $dataProvider->getPagination()->pageSize,
                [
                    8 => 8,
                    24 => 24,
                    48 => 48,
                ],
                [
                    'id' => 'video-per-page-input',
                ],
            ); ?>
            records on page.
        </p>

        <?= \yii\helpers\Html::endForm(); ?>
    </div>

    <div class="body-content">
        <?= \yii\widgets\ListView::widget([
            'options' => [
                'tag' => false,
            ],
            'itemOptions' => [
                'tag' => false,
            ],
            'itemView' => 'partial/list-video-item',
            'layout' => '<div class="video-list">{items}</div>{pager}',
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => \yii\bootstrap4\LinkPager::class,
                'firstPageLabel' => '<<',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'lastPageLabel' => '>>',
                'maxButtonCount' => 5,
            ],
        ]); ?>
    </div>
</div>
