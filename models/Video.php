<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property string $slug
 * @property string $title
 * @property string $video_path
 * @property string $thumb_path
 * @property int    $duration
 * @property int    $views
 * @property string $created_at
 */
class Video extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'public.video';
    }

    public function rules(): array
    {
        return [
            [['slug', 'title', 'video_path', 'thumb_path', 'duration', 'views'], 'required'],
            [['slug', 'title', 'video_path', 'thumb_path'], 'string', 'max' => 255],
            [['duration', 'views'], 'integer'],
        ];
    }
}
