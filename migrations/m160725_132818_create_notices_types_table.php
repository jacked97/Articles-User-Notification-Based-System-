<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notices_types`.
 */
class m160725_132818_create_notices_types_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('notices_mtom_types', [
            'id' => $this->primaryKey(),
            'notice_id' => $this->integer(),
            'notice_type_id' => $this->integer()
        ]);
        $this->addForeignKey('notices_m2m_notice', 'notices_mtom_types', 'notice_id', 'notices', 'id');
        $this->addForeignKey('noticetypes_m2m_types', 'notices_mtom_types', 'notice_type_id', 'notice_types', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('notices_types');
    }

}
