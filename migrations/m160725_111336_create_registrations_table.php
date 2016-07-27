<?php

use yii\db\Migration;

/**
 * Handles the creation for table `registrations`.
 */
class m160725_111336_create_registrations_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('registrations', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'full_name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->timestamp()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('registrations');
    }

}
