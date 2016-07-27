<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "registrations".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $full_name
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $type
 *
 * @property Articles[] $articles
 * @property NoticeReadBy[] $noticeReadBies
 * @property Notices[] $notices
 */
class Registrations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'registrations';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'password'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['username', 'password', 'full_name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'full_name' => 'Full Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles() {
        return $this->hasMany(Articles::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeReadBies() {
        return $this->hasMany(NoticeReadBy::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices() {
        return $this->hasMany(Notices::className(), ['author_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes) {
        if (!$insert) {
            if (in_array('status', array_keys($changedAttributes))) {
                $notficeTypes = array(\app\types\NoticeTypes::$EMAIL);
                $users = array($this->id);
                \app\components\NoticeComponents::notifyUsers('', '', '', $notficeTypes, $users, '', null, \app\types\NoticeEmailTemplateTypes::$USER_SET_INACTIVE);
            }
        }
    }

}
