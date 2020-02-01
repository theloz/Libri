<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone_number
 * @property string|null $username
 * @property string|null $useractive
 * @property string|null $email
 * @property string|null $password
 * @property string|null $authkey
 * @property string|null $password_reset_token
 * @property string|null $user_image
 * @property string|null $user_level
 * @property string|null $last_login
 * @property string|null $create_dttm
 * @property string|null $mod_dttm
 * @property int|null $create_id
 * @property int|null $mod_id
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 'yes';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'create_id', 'mod_id'], 'default', 'value' => null],
            [['id', 'create_id', 'mod_id'], 'integer'],
            [['last_login', 'create_dttm', 'mod_dttm'], 'safe'],
            [['first_name', 'last_name', 'username', 'password', 'authkey', 'password_reset_token'], 'string', 'max' => 250],
            [['phone_number'], 'string', 'max' => 30],
            [['email', 'user_image'], 'string', 'max' => 500],
            [['user_level'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'username' => Yii::t('app', 'Username'),
            'useractive' => Yii::t('app', 'Useractive'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'authkey' => Yii::t('app', 'Authkey'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'user_image' => Yii::t('app', 'User Image'),
            'user_level' => Yii::t('app', 'User Level'),
            'last_login' => Yii::t('app', 'Last Login'),
            'create_dttm' => Yii::t('app', 'Create Dttm'),
            'mod_dttm' => Yii::t('app', 'Mod Dttm'),
            'create_id' => Yii::t('app', 'Create ID'),
            'mod_id' => Yii::t('app', 'Mod ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'useractive' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'useractive' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'useractive' => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $user = self::find()
                ->where([
                    "username" => $username, 
                ])
                ->one();
        return new static($user);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password ===  sha1($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
