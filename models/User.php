<?php

namespace app\models;

use app\models\database\Registrations;

class User extends \yii\base\Object implements \yii\web\IdentityInterface {

    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $full_name;
    public $created_at, $updated_at, $status, $type;
    public static $ADMIN = 'admin', $USER = 'user';

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $dbUser = Registrations::find()
                ->where([
                    "id" => $id, 'status' => 1
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $dbUser = Registrations::find()
                ->where(["accessToken" => $token, 'status' => 1])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $dbUser = Registrations::find()
                ->where([
                    "username" => $username, 'status' => 1
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === $password;
    }

    public function isAdmin() {
        if ($this->type == self::$ADMIN)
            return true;
        else
            return false;
    }

    public function isUser() {
        if ($this->type == self::$USER)
            return true;
        else
            return false;
    }

}
