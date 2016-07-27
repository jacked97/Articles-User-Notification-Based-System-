<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notice_read_by`.
 */
class m160725_133223_create_notice_read_by_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('notice_read_by', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'notice_id' => $this->integer(),
            'created_at' => $this->timestamp(),
            'status' => $this->boolean()
        ]);
        $this->addForeignKey('notices_read_by_registrations', 'notice_read_by', 'author_id', 'registrations', 'id');
        $this->addForeignKey('notices_read_by_notice', 'notice_read_by', 'notice_id', 'notices', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notice_read_by');
    }

}
