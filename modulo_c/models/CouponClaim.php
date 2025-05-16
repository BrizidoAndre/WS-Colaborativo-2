<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CouponClaim".
 *
 * @property string $couponId
 * @property string $costumerId
 * @property string $code
 *
 * @property User $costumer
 * @property Coupon $coupon
 */
class CouponClaim extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CouponClaim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['couponId', 'costumerId', 'code'], 'required'],
            [['couponId', 'costumerId', 'code'], 'string', 'max' => 33],
            [['code'], 'unique'],
            [['couponId', 'costumerId'], 'unique', 'targetAttribute' => ['couponId', 'costumerId']],
            [['couponId'], 'exist', 'skipOnError' => true, 'targetClass' => Coupon::class, 'targetAttribute' => ['couponId' => 'couponId']],
            [['costumerId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['costumerId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'couponId' => 'Coupon ID',
            'costumerId' => 'Costumer ID',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[Costumer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCostumer()
    {
        return $this->hasOne(User::class, ['userId' => 'costumerId']);
    }

    /**
     * Gets query for [[Coupon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::class, ['couponId' => 'couponId']);
    }

    public function getId()
    {
        return $this->couponId;
    }
}
