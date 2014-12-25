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

<?php $this->Html->css('Passengers.admin/users/signin', ['block' => true]) ?>

<div class="col-md-4 col-md-offset-4">
    <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= __d('passengers', 'Sign Up') ?></h3>
        </div>
        <div class="panel-body">
	        <?= $this->Session->flash(); ?>
	        <?= $this->Flash->render('auth') ?>
	        <?= $this->Form->create() ?>
                <fieldset>
	                <?= $this->Form->input('username', ['label' => __d('passengers', 'Username'), 'placeholder' => __d('passengers', 'Username')]) ?>
                    <?= $this->Form->input('email', ['label' => __d('passengers', 'E-mail'), 'placeholder' => __d('passengers', 'E-mail')]) ?>
                    <?= $this->Form->input('password_new', ['type' => 'password', 'label' => __d('passengers', 'Password'), 'placeholder' => __d('passengers', 'Password')]) ?>
                    <?= $this->Form->input('password_confirm', ['type' => 'password', 'label' => __d('passengers', 'Password Confirmation'), 'placeholder' => __d('passengers', 'Password Confirmation')]) ?>
                </fieldset>
                <?= $this->Form->button(__d('passengers', 'Register'), ['class' => 'btn btn-lg btn-success btn-block']); ?>
	        <?= $this->Form->end() ?>
            <?= $this->Html->link(__d('passengers', 'Back to Sign In'), ['action' => 'signin'], ['class' => 'btn btn-link btn-block']); ?>
        </div>
    </div>
</div>
