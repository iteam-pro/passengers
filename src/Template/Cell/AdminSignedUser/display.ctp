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
$this->loadHelper('RearEngine.AdminMenu');
$this->loadHelper('Tools.Gravatar', ['default' => 'mm', 'ext' => 'png']);
//debug($user);
?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <?= $this->Gravatar->image($user['email'], ['size' => 20, 'class' => 'img-circle'])?> <?= $user['username'] ?> <span class="caret"></span>
    </a>
    <?= $this->AdminMenu->render($children, 1, ['class' => 'dropdown-menu']); ?>
</li>
