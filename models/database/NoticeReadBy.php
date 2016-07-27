<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "notice_read_by".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $notice_id
 * @property string $created_at
 * @property integer $status
 *
 * @property Notices $notice
 * @property Registrations $author
 */
class NoticeReadBy extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'notice_read_by';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['author_id', 'notice_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['notice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notices::className(), 'targetAttribute' => ['notice_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Registrations::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'notice_id' => 'Notice ID',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotice() {
        return $this->hasOne(Notices::className(), ['id' => 'notice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor() {
        return $this->hasOne(Registrations::className(), ['id' => 'author_id']);
    }

}
