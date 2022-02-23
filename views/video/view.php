<?php

/**
 * @var \app\models\Video $model
 * @var \app\i18n\Formatter $formatter
 */

declare(strict_types=1);

$formatter = \Yii::$app->getFormatter();

$playerHtml = <<<HTML
<style>*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style>
<a href='{$model->video_path}?autoplay=1'>
    <img src='{$model->thumb_path}' alt='{$model->title}'>
    <span>▶</span>
</a>
HTML;

?>

<div class="page-video-view">
    <div class="player">
        <iframe
            src=""
            srcdoc="<?= $playerHtml; ?>"
            frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
    </div>

    <div class="content">
        <h1><?= \yii\helpers\Html::encode($model->title); ?></h1>
        <p>Duration: <?= $formatter->asTimeDuration($model->duration); ?></p>
        <p>Views: <?= $formatter->asCount($model->views); ?></p>
    </div>
</div>
