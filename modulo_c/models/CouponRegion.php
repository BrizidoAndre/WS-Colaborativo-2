<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CouponRegion".
 *
 * @property string $couponId
 * @property float $latitude
 * @property float $longitude
 * @property float $distance
 *
 * @property Coupon $coupon
 */
class CouponRegion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CouponRegion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['couponId', 'latitude', 'longitude', 'distance'], 'required'],
            [['latitude', 'longitude', 'distance'], 'number'],
            [['couponId'], 'string', 'max' => 33],
            [['couponId'], 'unique'],
            [['couponId'], 'exist', 'skipOnError' => true, 'targetClass' => Coupon::class, 'targetAttribute' => ['couponId' => 'couponId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'couponId' => 'Coupon ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'distance' => 'Distance',
        ];
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

}
