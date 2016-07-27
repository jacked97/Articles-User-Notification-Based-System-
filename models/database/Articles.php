<?php

namespace app\models\database;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property integer $author_id
 *
 * @property Registrations $author
 */
class Articles extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['author_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'content' => 'Content',
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
        if ($insert) {
            $allUsers = Registrations::find()->select('id')->all();
            $users = array();
            $noticeType = array(\app\types\NoticeTypes::$BROWSER, \app\types\NoticeTypes::$EMAIL);
            $title = 'Article: ' . $this->title;
            $shortDescription = substr($this->content, 0, 100);
            $readMoreLink = \yii\helpers\Url::to(['articles/view', 'id' => $this->id], true);
            foreach ($allUsers as $user) {
                if ($user->id != Yii::$app->user->id)
                    array_push($users, $user->id);
            }
            \app\components\NoticeComponents::notifyUsers($title, $shortDescription, $readMoreLink, $noticeType, $users, Yii::$app->user->id, null, \app\types\NoticeEmailTemplateTypes::$NEW_ARTICLE);
        }
        //exit;
    }

}
