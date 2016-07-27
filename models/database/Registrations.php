<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "registrations".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $full_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Articles[] $articles
 * @property NoticeReadBy[] $noticeReadBies
 * @property Notices[] $notices
 */
class Registrations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registrations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'status'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password', 'full_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'status' => 'Status',
            'full_name' => 'Full Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeReadBies()
    {
        return $this->hasMany(NoticeReadBy::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notices::className(), ['author_id' => 'id']);
    }
}
