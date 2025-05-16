<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Employee".
 *
 * @property string $employeeId
 * @property string $marketId
 * @property string|null $photo
 *
 * @property User $employee
 * @property Market $market
 */
class Employee extends \yii\db\ActiveRecord
{
    public $address;
    public $role;
    public $name;
    public $email;
    public $phone;
    public $password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo'], 'default', 'value' => null],
            [['name', 'email', 'phone', 'password', 'marketId', 'role', 'photo'], 'required'],
            [['photo'], 'string'],
            [['employeeId', 'marketId'], 'string', 'max' => 33],
            [['employeeId'], 'default', 'value' => Yii::$app->security->generateRandomString(33)],
            [['employeeId'], 'unique'],
            [['marketId'], 'exist', 'skipOnError' => true, 'targetClass' => Market::class, 'targetAttribute' => ['marketId' => 'marketId']],
        ];
    }

    public function fields()
    {
        return [
            'userId' => fn()=>$this->employee->userId,
            'employeeId',
            'name' => fn()=>$this->employee->name,
            'email' => fn()=>$this->employee->email,
            'phone'=> fn()=>$this->employee->phone,
            'marketId',
            'role' => fn()=>$this->employee->role->title,
            'photo'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employeeId' => 'Employee ID',
            'marketId' => 'Market ID',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::class, ['userId' => 'employeeId']);
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

    public function getId()
    {
        return $this->employeeId;
    }
}
