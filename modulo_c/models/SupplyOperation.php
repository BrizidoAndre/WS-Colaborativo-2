<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SupplyOperation".
 *
 * @property string $operationId
 * @property string $operationType
 * @property float $amount
 * @property string $marketId
 * @property string $productId
 *
 * @property SupplyData $market
 */
class SupplyOperation extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const OPERATIONTYPE_SALE = 'sale';
    const OPERATIONTYPE_PURCHASE = 'purchase';
    const OPERATIONTYPE_DONATION = 'donation';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SupplyOperation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operationId', 'operationType', 'amount', 'marketId', 'productId'], 'required'],
            [['operationType'], 'string'],
            [['amount'], 'number'],
            [['operationId', 'marketId', 'productId'], 'string', 'max' => 33],
            ['operationType', 'in', 'range' => array_keys(self::optsOperationType())],
            [['operationId'], 'unique'],
            [['marketId', 'productId'], 'exist', 'skipOnError' => true, 'targetClass' => SupplyData::class, 'targetAttribute' => ['marketId' => 'marketId', 'productId' => 'productId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'operationId' => 'Operation ID',
            'operationType' => 'Operation Type',
            'amount' => 'Amount',
            'marketId' => 'Market ID',
            'productId' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Market]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarket()
    {
        return $this->hasOne(SupplyData::class, ['marketId' => 'marketId', 'productId' => 'productId']);
    }


    /**
     * column operationType ENUM value labels
     * @return string[]
     */
    public static function optsOperationType()
    {
        return [
            self::OPERATIONTYPE_SALE => 'sale',
            self::OPERATIONTYPE_PURCHASE => 'purchase',
            self::OPERATIONTYPE_DONATION => 'donation',
        ];
    }

    /**
     * @return string
     */
    public function displayOperationType()
    {
        return self::optsOperationType()[$this->operationType];
    }

    /**
     * @return bool
     */
    public function isOperationTypeSale()
    {
        return $this->operationType === self::OPERATIONTYPE_SALE;
    }

    public function setOperationTypeToSale()
    {
        $this->operationType = self::OPERATIONTYPE_SALE;
    }

    /**
     * @return bool
     */
    public function isOperationTypePurchase()
    {
        return $this->operationType === self::OPERATIONTYPE_PURCHASE;
    }

    public function setOperationTypeToPurchase()
    {
        $this->operationType = self::OPERATIONTYPE_PURCHASE;
    }

    /**
     * @return bool
     */
    public function isOperationTypeDonation()
    {
        return $this->operationType === self::OPERATIONTYPE_DONATION;
    }

    public function setOperationTypeToDonation()
    {
        $this->operationType = self::OPERATIONTYPE_DONATION;
    }
}
