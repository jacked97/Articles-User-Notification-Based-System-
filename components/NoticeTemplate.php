<?php

namespace app\components;

use app\components\NoticeComponents;

class NoticeTemplate {

    private static $articleTemplatePath = '/../email-templates/article.html';
    private static $rawNoticeTemplatePath = '/../email-templates/raw-notice.html';

    protected static function notifyArticle($title, $shortText, $readMoreLink, $users, $createdBy) {
        $templatePath = __DIR__ . self::$articleTemplatePath;
        $template = file_get_contents($templatePath);
        $subject = "New Article Created";

        $template = str_replace("{article-name}", $title, $template);
        $template = str_replace("{short-text}", $shortText, $template);
        $template = str_replace("{read-more-link}", $readMoreLink, $template);
        $template = str_replace("{site-name}", \Yii::$app->name, $template);
        $usersDB = \app\models\database\Registrations::find()->where('id IN (' . join(',', $users) . ')')->all();
        foreach ($users as $user) {
            $currItrUser = self::getUserDataFromId($usersDB, $user);
            $tempTemplate = $template;
            $tempTemplate = str_replace("{username}", $currItrUser->username, $tempTemplate);
            \Yii::$app->mailer->compose()
                    ->setTo($currItrUser->username)
                    ->setFrom(\Yii::$app->params['adminEmail'])
                    ->setSubject($subject)
                    ->setTextBody($tempTemplate)
                    ->send();
        }
    }

    protected static function rawNotice($title, $text, $users) {
        $templatePath = __DIR__ . self::$rawNoticeTemplatePath;
        $template = file_get_contents($templatePath);
        $subject = "New Notice: " . $title;
        $template = str_replace("{notice-content}", $text, $template);
        $usersDB = \app\models\database\Registrations::find()->where('id IN (' . join(',', $users) . ')')->all();
        foreach ($users as $user) {
            $currItrUser = self::getUserDataFromId($usersDB, $user);
            $tempTemplate = $template;
            $tempTemplate = str_replace("{username}", $currItrUser->username, $tempTemplate);
//            DebugComponents::echoArr($currItrUser);
            \Yii::$app->mailer->compose()
                    ->setTo($currItrUser->username)
                    ->setFrom(\Yii::$app->params['adminEmail'])
                    ->setSubject($subject)
                    ->setTextBody($tempTemplate)
                    ->send();
        }
    }

    protected static function getUserDataFromId($dataArr, $id) {
        foreach ($dataArr as $user) {
            if ($user->id == $id)
                return $user;
        }
        return null;
    }

}
