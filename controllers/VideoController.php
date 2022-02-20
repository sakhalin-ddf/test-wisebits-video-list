<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Video;
use yii\web\Controller;

class VideoController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new \app\search\Video();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(string $slug)
    {
        $model = Video::findOne(['slug' => $slug]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
