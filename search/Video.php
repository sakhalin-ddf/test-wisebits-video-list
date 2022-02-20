<?php

declare(strict_types=1);

namespace app\search;

class Video extends \yii\base\Model
{
    /**
     * @return \yii\data\DataProviderInterface
     *
     * @throws \yii\db\Exception
     */
    public function search(): \yii\data\DataProviderInterface
    {
        $query = \app\models\Video::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'views' => [
                        'asc' => [
                            'views' => SORT_ASC
                        ],
                        'desc' => [
                            'views' => SORT_DESC
                        ],
                    ],
                    'created_at' => [
                        'asc' => [
                            'created_at' => SORT_ASC
                        ],
                        'desc' => [
                            'created_at' => SORT_DESC
                        ],
                    ],
                ],

                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $dataProvider->setTotalCount($this->calcTotalCount());

        return $dataProvider;
    }

    /**
     * @return int
     *
     * @throws \yii\db\Exception
     */
    private function calcTotalCount(): int
    {
        $sql = <<<SQL
SELECT MAX(id)

FROM "public"."video"
SQL;

        return (int) \Yii::$app->getDb()->createCommand($sql)->queryScalar();
    }
}
