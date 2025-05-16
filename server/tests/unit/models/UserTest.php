<?php

namespace tests\unit\models;

use app\models\UserBackup;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = UserBackup::findIdentity(100))->notEmpty();
        verify($user->username)->equals('admin');

        verify(UserBackup::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = UserBackup::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(UserBackup::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = UserBackup::findByUsername('admin'))->notEmpty();
        verify(UserBackup::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = UserBackup::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

}
