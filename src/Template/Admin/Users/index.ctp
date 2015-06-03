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
<?php $this->extend('/Admin/Common/index'); ?>

<?php $this->assign('title', __('Users')); ?>

<table class="table table-striped">
	<tr>
		<th><?= $this->Paginator->sort('id'); ?></th>
		<th><?= $this->Paginator->sort('username', __d('passengers', 'User Name')); ?></th>
		<th><?= $this->Paginator->sort('email', __d('passengers', 'Email')); ?></th>
		<th><?= $this->Paginator->sort('created', __d('passengers', 'Registred')); ?></th>
		<th><?= $this->Paginator->sort('modified', __d('passengers', 'Last visit')); ?></th>
		<th><?= $this->Paginator->sort('active', __d('passengers', 'Is Active')); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?= h($user->id); ?>&nbsp;</td>
		<td><?= h($user->username); ?>&nbsp;</td>
		<td><?= h($user->email); ?>&nbsp;</td>
		<td><?= h($user->created); ?>&nbsp;</td>
		<td><?= h($user->modified); ?>&nbsp;</td>
		<td><?= $user->active ? $this->Html->icon('check') : $this->Html->icon('times'); ?>&nbsp;</td>
		<td class="actions">
			<?= $this->Html->link(__('View'), ['action' => 'view', $user->id], ['class' => 'btn btn-sm btn-primary', 'icon' => 'eye']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'btn btn-sm btn-warning', 'icon' => 'edit']); ?>
			<?= $this->Html->link(__('Delete'), ['action' => 'delete', $user->id], ['title' => __('Are you sure you want to delete {0}?', $user->username), 'class' => 'btn btn-sm btn-danger btn-confirmation', 'icon' => 'trash-o']); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'btn btn-primary']); ?>	<?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index'], ['class' => 'btn btn-default']); ?>
	<?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add'], ['class' => 'btn btn-default']); ?>
</div>
<?php $this->end(); ?>
