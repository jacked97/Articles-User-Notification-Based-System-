<?php

namespace app\components;

use app\components\NoticeComponents;

class NoticeTemplate {

    private static $articleTemplatePath = '/../email-templates/article.html';

    protected static function notifyArticle($title, $shortText, $readMoreLink, $users, $createdBy) {
        $templatePath = __DIR__ . self::$articleTemplatePath;
        $template = file_get_contents($templatePath);
        $subject = "New Article Created";

        $template = str_replace("{article-name}", $title, $template);
        $template = str_replace("{short-text}", $shortText, $template);
        $template = str_replace("{read-more-link}", $readMoreLink, $template);
        foreach ($users as $user) {
            \Yii::$app->mailer->compose()
                    ->setTo("to@to.com")
                    ->setFrom('jacked97@gmail.com')
                    ->setSubject($subject)
                    ->setTextBody($template)
                    ->send();
        }
    }

}
