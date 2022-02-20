<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

class ErrorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
