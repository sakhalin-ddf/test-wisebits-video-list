<?php

use yii\db\Migration;

/**
 * Class m220220_145509_add_video_table
 */
class m220220_145509_add_video_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
CREATE TABLE "public"."video" (
    "id" SERIAL8 NOT NULL,
    "slug" VARCHAR(255) NOT NULL,
    "title" VARCHAR(255) NOT NULL,
    "video_path" VARCHAR(255) NOT NULL,
    "thumb_path" VARCHAR(255) NOT NULL,
    "duration" INT4 NOT NULL,
    "views" INT4 NOT NULL,
    "created_at" TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ("id")
);
SQL;

        $this->execute($sql);

        $this->execute('CREATE UNIQUE INDEX "video_idx_slug" ON "public"."video" USING BTREE ("slug")');
        $this->execute('CREATE INDEX "video_idx_views" ON "public"."video" USING BTREE ("views")');
        $this->execute('CREATE INDEX "video_idx_created_at" ON "public"."video" USING BTREE ("created_at")');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP INDEX "public"."video_idx_created_at"');
        $this->execute('DROP INDEX "public"."video_idx_views"');
        $this->execute('DROP INDEX "public"."video_idx_slug"');

        $sql = <<<SQL
DROP TABLE "public"."video"
SQL;

        $this->execute($sql);
    }
}
