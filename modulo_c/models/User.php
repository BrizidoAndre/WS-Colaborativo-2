<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * This is the model class for table "User".
 *
 * @property string $userId
 * @property string $roleId
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $password
 *
 * @property CouponClaim[] $couponClaims
 * @property Coupon[] $coupons
 * @property Employee $employee
 * @property Role $role
 * @property Token[] $tokens
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public const SCENARIO_CUSTOMER = 'customer';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'default', 'value' => null],
            [['email', 'password'], 'required'],
            [['userId', 'roleId'], 'string', 'max' => 33],
            [['name', 'email', 'password'], 'string', 'max' => 300],
            [['phone'], 'string', 'max' => 11],
            [['userId'], 'unique'],
            [['roleId'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['roleId' => 'roleId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'roleId' => 'Role ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
        ];
    }

    /**
     * Gets query for [[CouponClaims]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCouponClaims()
    {
        return $this->hasMany(CouponClaim::class, ['costumerId' => 'userId']);
    }

    /**
     * Gets query for [[Coupons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoupons()
    {
        return $this->hasMany(Coupon::class, ['couponId' => 'couponId'])->viaTable('CouponClaim', ['costumerId' => 'userId']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['employeeId' => 'userId']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['roleId' => 'roleId']);
    }

    /**
     * Gets query for [[Tokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::class, ['user_id' => 'userId']);
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = Token::findOne(['token' => $token]);
        if (!$token) {
            return null;
        }
        $dif = (new \DateTime('now'))->getTimestamp() - $token->created_at;
        if($dif > 60 * 60){
            return null;
        }
        return $token->user;
    }

    public function getId()
    {
        return $this->userId;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }


}
