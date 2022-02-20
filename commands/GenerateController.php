<?php

declare(strict_types=1);
/**
 * @see http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Faker\Factory;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Inflector;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 */
class GenerateController extends Controller
{
    /**
     * @return int Exit code
     */
    public function actionVideo(int $count = 1000)
    {
        $db = \Yii::$app->getDb();
        $faker = Factory::create('en_US');
        $i = 0;

        $sql = <<<SQL
INSERT INTO "public"."video"
    (title, slug, video_path, thumb_path, duration, views, created_at)

VALUES
    (:title, :slug, :video_path, :thumb_path, :duration, :views, :created_at)
SQL;

        $youtubeCodes = [
            'T-39e6q3MaY',
            '3DrU3pFXSsY',
            'rs0QynAOsJ4',
            '3ZEFD5tTRDI',
            'YCAEzuMebGg',
            '3ngjmr31F0I',
            'CzT2k-vD62Q',
            'Ct0az4ulhlc',
            'RKAuQoxkuws',
            'cuFFZYJAWd0',
            '3AvTnh3Aimo',
            'mxtofLh44I0',
        ];

        $batchSize = 100;
        $rows = [];

        echo "Count of generated records: {$i}";

        while ($i < $count) {
            ++$i;

            $code = $faker->randomElement($youtubeCodes);

            $title = $faker->sentence(\random_int(4, 8));
            $slug = Inflector::slug($title, '-', true).'-'.$i;

            $rows[] = [
                'title' => $title,
                'slug' => $slug,
                'video_path' => "https://www.youtube.com/embed/{$code}",
                'thumb_path' => "https://i.ytimg.com/vi/{$code}/hqdefault.jpg",
                'duration' => \random_int(120, 5400),
                'views' => \random_int(0, 50_000_000),
                'created_at' => $faker->dateTimeBetween('-10 years', 'now')->format('c'),
            ];

            if (\count($rows) >= $batchSize) {
                $this->batchInsertVideos($rows);

                $rows = [];

                echo "\rCount of generated records: {$i}";
            }
        }

        $this->batchInsertVideos($rows);
        $rows = [];

        echo "\rCount of generated records: {$i}\n";

        return ExitCode::OK;
    }

    /**
     * @param array $rows
     *
     * @throws \yii\db\Exception
     */
    private function batchInsertVideos(array $rows): void
    {
        if (\count($rows) === 0) {
            return;
        }

        \Yii::$app
            ->getDb()
            ->createCommand()
            ->batchInsert(
                'public.video',
                \array_keys($rows[0]),
                \array_map('\array_values', $rows),
            )
            ->execute();
    }
}
