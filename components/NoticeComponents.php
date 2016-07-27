<?php

namespace app\components;

use app\components\NoticeTemplate;
use app\types\NoticeEmailTemplateTypes;

class NoticeComponents extends NoticeTemplate {

    public static function notifyUsers($title, $content, $readMoreLink, $notficeTypes, $users, $createdBy, $noticeId = null, $emailTemplateType = null) {
        if (in_array('Email', $notficeTypes)) {
            self::email($title, $content, $readMoreLink, $users, $notficeTypes, $createdBy, $noticeId, $emailTemplateType);
        }
        if (in_array('Browser', $notficeTypes)) {
            self::browser($title, $content, $users, $notficeTypes, $createdBy, $noticeId);
        }
        if (in_array('SMS', $notficeTypes)) {
            self::sms($title, $content, $users, $notficeTypes, $createdBy, $noticeId);
        }
        if (in_array('Telegram', $notficeTypes)) {
            self::telegram($title, $content, $users, $notficeTypes, $createdBy, $noticeId);
        }
    }

    private static function email($title, $content, $readMoreLink, $users, $notficeTypes, $createdBy, $noticeId = null, $emailTemplateType = null) {
        switch ($emailTemplateType) {
            case NoticeEmailTemplateTypes::$NEW_ARTICLE:
                self::notifyArticle($title, $content, $readMoreLink, $users, $createdBy);
                break;
            case NoticeEmailTemplateTypes::$RAW_NOTICE_CREATED:
                self::rawNotice($title, $content, $users);
                break;
            case NoticeEmailTemplateTypes::$USER_SET_INACTIVE:
                self::accountDisable($users);
                break;
            case NoticeEmailTemplateTypes::$LOGIN_NOTICE:
                self::accountLoggedIn($users);
                break;
        }
    }

    private static function browser($title, $content, $users, $notficeTypes, $createdBy, $noticeId = null) {
        $trasactionCompleted = true;
        $storeNotice = new \app\models\database\Notices();
        if ($noticeId == null) {
            $storeNotice->author_id = $createdBy;
            $storeNotice->created_at = date("Y-m-d H:i:s");
            $storeNotice->title = $title;
            $storeNotice->text = $content;
            $storeNotice->notice_type = self::getNoticeIdsString($notficeTypes);
            $storeNotice->afterSaveEnable = false;
            if ($storeNotice->save()) {
                foreach ($users as $user) {
                    $storeNoticeReadyBy = new \app\models\database\NoticeReadBy();
                    $storeNoticeReadyBy->author_id = $user;
                    $storeNoticeReadyBy->notice_id = $storeNotice->id;
                    $storeNoticeReadyBy->created_at = date("Y-m-d H:i:s");
                    $storeNoticeReadyBy->status = 0;
                    if (!$storeNoticeReadyBy->save()) {
                        DebugComponents::echoArr($storeNoticeReadyBy->errors);
                    }
                }
            } else {
                DebugComponents::echoArr($storeNotice->errors);
            }
            return true;
//            DebugComponents::echoArr(\app\models\database\NoticeReadBy::find()->where(['notice_id' => $storeNotice->id])->all());
        } else {
            foreach ($users as $user) {
                $storeNotfication = new \app\models\database\NoticeReadBy();
                $storeNotfication->author_id = $user;
                $storeNotfication->notice_id = $noticeId;
                $storeNotfication->created_at = date("Y-m-d H:i:s");
                $storeNotfication->status = 0;
                if (!$storeNotfication->save())
                    DebugComponents::echoArr($storeNotfication->errors);
            }
        }
    }

    private static function sms($title, $content, $users, $notficeTypes, $createdBy, $noticeId = null) {
        
    }

    private static function telegram($title, $content, $users, $notficeTypes, $createdBy, $noticeId = null) {
        
    }

    private static function getNoticeIdsString($arr) {
        $where = '';
        $firstIteration = true;
        $ids = array();
        foreach ($arr as $type) {
            if ($firstIteration) {
                $firstIteration = false;
                $where .= "type = '$type'";
            }
            $where .= " OR type = '$type'";
        }
        $noticceIds = \app\models\database\NoticeTypes::find()->where($where)->all();
        foreach ($noticceIds as $id)
            array_push($ids, $id->id);
        return $ids;
    }

}
