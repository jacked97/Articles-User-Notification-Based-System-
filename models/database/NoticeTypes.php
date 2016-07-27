<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "notice_types".
 *
 * @property integer $id
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Notices[] $notices
 */
class NoticeTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notices::className(), ['notice_types' => 'id']);
    }
}
