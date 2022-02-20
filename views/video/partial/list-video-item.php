<?php

declare(strict_types=1);

/**
 * @var \app\models\Video $model
 */
?>

<div class="video-list-item">
    <a href="<?= \yii\helpers\Url::to(['video/view', 'slug' => $model->slug]); ?>">
        <div class="img-preview">
            <img src="<?= $model->thumb_path; ?>" alt="">
        </div>

        <div class="content">
            <div class="title"><?= \yii\helpers\Html::encode($model->title); ?></div>
            <div class="duration"><?= \Yii::$app->getFormatter()->asTimeDuration($model->duration); ?></div>
            <div class="views"><?= $model->views; ?></div>
            <div class="created-at"><?= \Yii::$app->getFormatter()->asDatetime($model->created_at); ?></div>
        </div>
    </a>
</div>
