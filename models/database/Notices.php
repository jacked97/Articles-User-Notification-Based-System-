<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "notices".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property integer $author_id
 *
 * @property Registrations $author
 */
class Notices extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $notice_type = array();
    public $afterSaveEnable = true;

    public static function tableName() {
        return 'notices';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['author_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['notice_type', 'required'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Registrations::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor() {
        return $this->hasOne(Registrations::className(), ['id' => 'author_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert && $this->afterSaveEnable) {
            $noticeType = array();
            foreach (NoticeTypes::find()->where('id IN (' . join(',', $this->notice_type) . ')')->all() as $notice)
                array_push($noticeType, $notice->type);
            $users = array();
            foreach (Registrations::find()->where('id != ' . Yii::$app->user->id)->all() as $user)
                array_push($users, $user->id);
            \app\components\NoticeComponents::notifyUsers($this->title, $this->text, '', $noticeType, $users, Yii::$app->user->id, $this->id, \app\types\NoticeEmailTemplateTypes::$RAW_NOTICE_CREATED);
        }
        //exit;
    }

}
