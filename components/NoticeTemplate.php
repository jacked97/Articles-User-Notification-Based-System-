<?php

namespace app\components;

use app\components\NoticeComponents;

class NoticeTemplate {

    private static $articleTemplatePath = '/../email-templates/article.html';
    private static $rawNoticeTemplatePath = '/../email-templates/raw-notice.html';
    private static $accountDisabledTemplatePath = '/../email-templates/account-disabled.html';
    private static $accountLoggedTemplatePath = '/../email-templates/account-logged-in.html';

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

    protected static function accountDisable($users) {
        $templatePath = __DIR__ . self::$accountDisabledTemplatePath;
        $template = file_get_contents($templatePath);
        $subject = "Account Disabled";
        $usersDB = \app\models\database\Registrations::find()->where('id IN (' . join(',', $users) . ')')->all();
        $template = str_replace("{site-name}", \Yii::$app->name, $template);
        foreach ($users as $user) {
            $currItrUser = self::getUserDataFromId($usersDB, $user);
            $tempTemplate = $template;
            $status = "";
            $tempTemplate = str_replace("{username}", $currItrUser->username, $tempTemplate);
            if ($currItrUser->status == 1)
                $status = "Enabled";
            else
                $status = "Disbaled";
            $tempTemplate = str_replace("{status}", $status, $tempTemplate);
            \Yii::$app->mailer->compose()
                    ->setTo($currItrUser->username)
                    ->setFrom(\Yii::$app->params['adminEmail'])
                    ->setSubject($subject)
                    ->setTextBody($tempTemplate)
                    ->send();
        }
    }

    protected static function accountLoggedIn($users) {
        $templatePath = __DIR__ . self::$accountLoggedTemplatePath;
        $template = file_get_contents($templatePath);
        $subject = "Account Disabled";
        $usersDB = \app\models\database\Registrations::find()->where('id IN (' . join(',', $users) . ')')->all();
        $template = str_replace("{site-name}", \Yii::$app->name, $template);
        $template = str_replace("{datetime}", date("Y-m-d H:i:s"), $template);
        foreach ($users as $user) {
            $currItrUser = self::getUserDataFromId($usersDB, $user);
            $tempTemplate = $template;
            $status = "";
            $tempTemplate = str_replace("{username}", $currItrUser->username, $tempTemplate);
            if ($currItrUser->status == 1)
                $status = "Enabled";
            else
                $status = "Disbaled";
            $tempTemplate = str_replace("{status}", $status, $tempTemplate);
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
