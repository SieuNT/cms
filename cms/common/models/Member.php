<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string $passwordConfirm
 * @property string $avatar
 * @property string $address
 * @property string $phone_number
 * @property string $about_us
 * @property integer $status
 * @property integer $role
 */
class Member extends \yii\db\ActiveRecord
{

    public $password;
    public $passwordConfirm;
    public $role;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'email'], 'required'],
            [['status'], 'integer'],
            [['full_name'], 'string', 'max' => 70],
            [['email', 'about_us'], 'string', 'max' => 255],
            [['avatar', 'address', 'phone_number'], 'string', 'max' => 15],
            [['email'], 'unique'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['passwordConfirm', 'required'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password'],

            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_DEACTIVATED]],

            ['role', 'default', 'value' => User::ROLE_MEMBER],
            ['role', 'in', 'range' => [User::ROLE_BANNED, User::ROLE_MEMBER, User::ROLE_EDITOR, User::ROLE_MANAGER, User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'avatar' => Yii::t('app', 'Avatar'),
            'address' => Yii::t('app', 'Address'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'about_us' => Yii::t('app', 'About Us'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberQuery(get_called_class());
    }
}
