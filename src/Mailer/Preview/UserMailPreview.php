<?php
namespace Passengers\Mailer\Preview;

use Cake\ORM\TableRegistry;
use DebugKit\Mailer\MailPreview;

class UserMailPreview extends MailPreview
{
    public function signUp()
    {
        //TODO: loadModel from ModelAwareTrait do not work
        //$this->loadModel('Passengers.Users');
        $usersTable = TableRegistry::get('Passengers.Users');
        $user = $usersTable->find()->first();
        $user->password = 'sampleSecretPassword';
        return $this->getMailer('Passengers.User')
            ->signUp($user);
    }

    public function resetPassword()
    {
        //TODO: loadModel from ModelAwareTrait do not work
        //$this->loadModel('Passengers.Users');
        $usersTable = TableRegistry::get('Passengers.Users');
        $user = $usersTable->find()->first();
        $user->password = 'sampleSecretPassword';
        return $this->getMailer('Passengers.User')
            ->resetPassword($user);
    }
}
