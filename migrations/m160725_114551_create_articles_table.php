<?php

use yii\db\Migration;

/**
 * Handles the creation for table `articles`.
 */
class m160725_114551_create_articles_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->timestamp(),
            'author_id' => $this->integer()
        ]);

        $this->addForeignKey('articles_author_registrations', 'articles', 'author_id', 'registrations', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('articles');
    }

}
