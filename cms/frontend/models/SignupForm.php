<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Exception;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $fullName;
    public $email;
    public $password;
    public $passwordConfirm;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['fullName', 'required'],
            ['fullName', 'string', 'min' => 3, 'max' => 70],

            ['passwordConfirm', 'required'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->full_name = $this->fullName;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user->save();
            $uid = $user->getId();
            $auth = Yii::$app->authManager;
            $auth->assign($auth->getRole(User::ROLE_MEMBER), $uid);
            return $user;
        } catch(Exception $exception) {
            $transaction->rollBack();
            throw new Exception($exception->getMessage());
        }
        return null;
    }
}
