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
        <legend><?= __d('passengers', 'Reset Password') ?></legend>
        <?= $this->Form->input('email', ['placeholder' => __d('passengers', 'EMail'), 'label'=> false]) ?>
    </fieldset>
    <?= $this->Form->button(__d('passengers', 'Reset my password'), ['class' => 'btn btn-lg btn-success btn-block']); ?>
<?= $this->Form->end() ?>
</div>
