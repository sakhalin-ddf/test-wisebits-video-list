<?php

declare(strict_types=1);

namespace app\assets;

use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class LayoutAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/layout';

    public $css = [
        'layout.css',
        'videos.css',
    ];

    public $js = [
        'videos.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
    ];
}
