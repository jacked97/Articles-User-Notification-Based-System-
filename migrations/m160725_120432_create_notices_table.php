<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notices`.
 */
class m160725_120432_create_notices_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {

        $this->createTable('notice_types', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->timestamp()
        ]);

        $this->createTable('notices', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->timestamp(),
            'author_id' => $this->integer(),
        ]);
        $this->addForeignKey('notices_author_registrations', 'notices', 'author_id', 'registrations', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notices');
        $this->dropTable('notice_types');
    }

}
