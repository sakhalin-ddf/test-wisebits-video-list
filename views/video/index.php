<?php

declare(strict_types=1);

/**
 * @var yii\web\View                    $this
 * @var \yii\data\DataProviderInterface $dataProvider
 */
$this->title = 'My Yii Application';

?>

<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
    </div>

    <div class="body-content">
        <?= \yii\widgets\ListView::widget([
            'options' => [
                'tag' => false
            ],
            'itemOptions' => [
                'tag' => false
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
            ],
        ]); ?>
    </div>
</div>
