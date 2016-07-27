<?php

use yii\db\Migration;

/**
 * Handles adding type_status to table `registrations`.
 */
class m160727_075513_add_type_status_column_to_registrations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('registrations', 'status', $this->integer());
        $this->addColumn('registrations', 'type', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('registrations', 'status');
        $this->dropColumn('registrations', 'type');
    }
}
