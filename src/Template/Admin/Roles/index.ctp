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

<?php $this->assign('title', __('Roles')); ?>

<table class="table table-striped">
	<tr>
		<th><?= $this->Paginator->sort('id'); ?></th>
		<th><?= $this->Paginator->sort('title'); ?></th>
		<th><?= $this->Paginator->sort('slug'); ?></th>
		<th><?= $this->Paginator->sort('admin'); ?></th>
		<th><?= $this->Paginator->sort('core'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($roles as $role): ?>
	<tr>
		<td><?= h($role->id); ?>&nbsp;</td>
		<td><?= h($role->title); ?>&nbsp;</td>
		<td><?= h($role->slug); ?>&nbsp;</td>
		<td><?= $role->admin ? $this->Html->icon('check', ['iconSet' => 'fa']) : $this->Html->icon('times', ['iconSet' => 'fa']); ?>&nbsp;</td>
		<td><?= $role->core ? $this->Html->icon('check', ['iconSet' => 'fa']) : $this->Html->icon('times', ['iconSet' => 'fa']); ?>&nbsp;</td>
		<td class="actions">
			<?= $this->Html->link(__('View'), ['action' => 'view', $role->id], ['class' => 'btn btn-sm btn-primary', 'icon' => 'eye']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $role->id], ['class' => 'btn btn-sm btn-warning', 'icon' => 'edit']); ?>
			<?php if(!$role->core): ?>
				<?= $this->Html->link(__('Delete'), ['action' => 'delete', $role->id], ['title' => __('Are you sure you want to delete # {0}?', $role->id), 'class' => 'btn btn-sm btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('New Role'), ['action' => 'add'], ['class' => 'btn btn-primary']); ?>
	<?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-default']); ?>
	<?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-default']); ?>
</div>
<?php $this->end(); ?>
