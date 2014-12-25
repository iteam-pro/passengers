<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) MindForce Team (http://mindforce.com)
* @link          http://mindforce.me Passengers CakePHP 3 Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/
?>
<?php $this->layout = 'unsigned' ?>

<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __d('passengers', 'Please enter your credentials to sign up') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password_new') ?>
        <?= $this->Form->input('password_confirmation') ?>
    </fieldset>
    <?= $this->Form->button(__d('passengers', 'Sign Up')); ?>
    <?= $this->Html->link(__d('passengers', 'Sign In'), ['action' => 'signin'], ['class' => 'btn']); ?>
    <?= $this->Form->end() ?>
</div>
