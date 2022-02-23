<?php

/**
 * @var \app\models\Video $model
 * @var \app\i18n\Formatter $formatter
 */

declare(strict_types=1);

$formatter = \Yii::$app->getFormatter();
?>

<div class="video-list-item" data-key="<?= $model->id; ?>">
    <a
        href="<?= \yii\helpers\Url::to(['video/view', 'slug' => $model->slug]); ?>"
        title="<?= \yii\helpers\Html::encode($model->title); ?>"
    >
        <div class="img-preview">
            <img src="<?= $model->thumb_path; ?>" alt="">
        </div>

        <div class="content">
            <div class="title"><?= \yii\helpers\Html::encode($model->title); ?></div>
            <div class="duration"><?= $formatter->asTimeDuration($model->duration, true); ?></div>
            <div class="views"><?= $formatter->asCount($model->views); ?></div>
            <div class="created-at"><?= $formatter->asDatetime($model->created_at); ?></div>
        </div>
    </a>
</div>
