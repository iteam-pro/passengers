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
            <h3 class="panel-title"><?= __d('passengers', 'Please Sign In') ?></h3>
        </div>
        <div class="panel-body">
	        <?= $this->Session->flash(); ?>
	        <?= $this->Flash->render('auth') ?>
	        <?= $this->Form->create() ?>
                <fieldset>
	                <?= $this->Form->input('username', ['label' => '', 'placeholder' => __d('passengers', 'Login or E-mail'), 'autofocus' => true]) ?>
	                <?= $this->Form->input('password', ['label' => '', 'placeholder' => __d('passengers', 'Password')]) ?>
                    <div class="pull-left">
	                       <?= $this->Form->input('remember_me', ['name' => 'remember_me', 'type' => 'checkbox', 'label' => __d('passengers', 'Remember Me')]) ?>
                    </div>
                    <?php
                        if ($signupAllowed) :
                            echo $this->Html->link(__d('passengers', 'Sign Up'), ['action' => 'signup'], ['class' => 'btn btn-link pull-right']);
                        endif;
                    ?>
                    <div class="clearfix"></div>
                </fieldset>
                    <?= $this->Form->button(__d('passengers', 'Login'), ['class' => 'btn btn-lg btn-success btn-block']); ?>
	        <?= $this->Form->end() ?>
        </div>
    </div>
</div>
