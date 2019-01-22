<?php
namespace Passengers\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{



    public function implementedEvents()
    {
        return [
            'Controller.Users.afterSignUp' => 'onSignUp',
        ];
    }

    public function onSignUp($event, $user)
    {
        if ($user->isNew()) {
            $this->send('resetPassword', [$user]);
        }
    }

    public function signUp($user)
    {
        return $this->to($user->email)
            ->subject(__('Thank you for registration'))
            ->template('Passengers.signup')
            ->emailFormat('both')
            ->set(["user" => $user]);
    }

    public function resetPassword($user)
    {
        return $this->to($user->email)
            ->subject(__('Password reset notification'))
            ->template('Passengers.reset')
            ->emailFormat('both')
            ->set(['user' => $user]);
    }

}
