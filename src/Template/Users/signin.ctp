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
        <legend><?= __d('passengers', 'Please enter your username and password') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password') ?>
        <?= $this->Form->input('remember_me', ['name' => 'remember_me', 'type' => 'checkbox', 'label' => __d('passengers', 'Remember Me')]) ?>
    </fieldset>
    <?= $this->Form->button(__d('passengers', 'Sign In')); ?>
    <?= $this->Html->link(__d('passengers', 'Sign Up'), ['action' => 'signup'], ['class' => 'btn']); ?>
<?= $this->Form->end() ?>
</div>
