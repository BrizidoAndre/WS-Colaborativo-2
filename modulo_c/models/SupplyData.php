<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SupplyData".
 *
 * @property string $marketId
 * @property string $productId
 * @property int|null $amount
 *
 * @property Market $market
 * @property Product $product
 * @property SupplyOperation[] $supplyOperations
 */
class SupplyData extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SupplyData';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'default', 'value' => null],
            [['marketId', 'productId'], 'required'],
            [['amount'], 'integer'],
            [['marketId', 'productId'], 'string', 'max' => 33],
            [['marketId', 'productId'], 'unique', 'targetAttribute' => ['marketId', 'productId']],
            [['marketId'], 'exist', 'skipOnError' => true, 'targetClass' => Market::class, 'targetAttribute' => ['marketId' => 'marketId']],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['productId' => 'productId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'marketId' => 'Market ID',
            'productId' => 'Product ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * Gets query for [[Market]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarket()
    {
        return $this->hasOne(Market::class, ['marketId' => 'marketId']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['productId' => 'productId']);
    }

    /**
     * Gets query for [[SupplyOperations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplyOperations()
    {
        return $this->hasMany(SupplyOperation::class, ['marketId' => 'marketId', 'productId' => 'productId']);
    }

    public function getId()
    {
        return $this->productId;
    }

}
