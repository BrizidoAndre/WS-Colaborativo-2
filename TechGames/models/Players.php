<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "Players".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property int $isRemoved
 * @property string|null $name
 * @property string|null $token
 * @property int|null $token_time
 *
 * @property PiecesPlayers[] $piecesPlayers
 * @property Points[] $points
 */
class Players extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $passwordConfirmation;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['isRemoved'], 'default', 'value' => 0],
            [['email', 'password', 'phone'], 'required'],
            [['isRemoved'], 'integer'],
            [['email', 'phone', 'name', 'passwordConfirmation'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 522],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'isRemoved' => 'Is Removed',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[PiecesPlayers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPiecesPlayers()
    {
        return $this->hasMany(PiecesPlayers::class, ['player_id' => 'id']);
    }

    /**
     * Gets query for [[Points]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoints()
    {
        return $this->hasMany(Points::class, ['player_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $player = self::findOne(['token' => $token]);
        if (!!$player) {
            $nowTimeStamp = (new \DateTime())->getTimestamp();
            $dif = $nowTimeStamp - $player->token_time;
            if ($dif > 60 * 60) {
                $player->token = null;
                $player->token_time = null;
                $player->save();
                return null;
            }
        }
        return $player;
    }

    public function getId()
    {
        // TODO: Implement getId() method.
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
