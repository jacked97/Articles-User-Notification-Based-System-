<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "notices_mtom_types".
 *
 * @property integer $id
 * @property integer $notice_id
 * @property integer $notice_type_id
 *
 * @property Notices $notice
 * @property NoticeTypes $noticeType
 */
class NoticesMtomTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notices_mtom_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_id', 'notice_type_id'], 'integer'],
            [['notice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notices::className(), 'targetAttribute' => ['notice_id' => 'id']],
            [['notice_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => NoticeTypes::className(), 'targetAttribute' => ['notice_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notice_id' => 'Notice ID',
            'notice_type_id' => 'Notice Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotice()
    {
        return $this->hasOne(Notices::className(), ['id' => 'notice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeType()
    {
        return $this->hasOne(NoticeTypes::className(), ['id' => 'notice_type_id']);
    }
}
