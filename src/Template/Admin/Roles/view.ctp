<?php $this->extend('/Admin/Common/form'); ?>

<?php $this->assign('title', __('Role')); ?>

<dl class="dl-horizontal">
	<dt><?= __('Title'); ?></dt>
	<dd>
		<?= h($role->title); ?>
		&nbsp;
	</dd>
	<dt><?= __('Slug'); ?></dt>
	<dd>
		<?= h($role->slug); ?>
		&nbsp;
	</dd>
	<dt><?= __('Admin'); ?></dt>
	<dd>
		<?= $role->admin ? $this->Html->icon('', ['class' => 'fa-check']) : $this->Html->icon('', ['class' => 'fa-times']); ?>
		&nbsp;
	</dd>
	<dt><?= __('Core'); ?></dt>
	<dd>
		<?= $role->core ? $this->Html->icon('', ['class' => 'fa-check']) : $this->Html->icon('', ['class' => 'fa-times']); ?>
		&nbsp;
	</dd>
	<dt><?= __('Created'); ?></dt>
	<dd>
		<?= h($role->created); ?>
		&nbsp;
	</dd>
	<dt><?= __('Modified'); ?></dt>
	<dd>
		<?= h($role->modified); ?>
		&nbsp;
	</dd>
</dl>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('List Roles'), ['action' => 'index'], ['class' => 'btn btn-primary']); ?> 
	<?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id], ['class' => 'btn btn-warning']); ?> 
	<?= $this->Html->link(__('New Role'), ['action' => 'add'], ['class' => 'btn btn-info']); ?> 
		<?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-default']); ?> 
		<?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-default']); ?> 
	<?php if(!$role->core): ?>
		<?= $this->Html->link(__('Delete Role'), ['action' => 'delete', $role->id], ['title' => __('Are you sure you want to delete # {0}?', $role->id), 'class' => 'btn btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
	<?php endif; ?>
</div>
<?php $this->end(); ?>
<div class="related">
	<h3><?= __('Related Users'); ?></h3>
	<?php if (!empty($role->users)): ?>
	<table class="table table-striped">
		<tr>
			<th><?= __('Id'); ?></th>
			<th><?= __('Username'); ?></th>
			<th><?= __('Email'); ?></th>
			<th><?= __('Created'); ?></th>
			<th><?= __('Modified'); ?></th>
			<th><?= __('Active'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
		</tr>
		<?php foreach ($role->users as $users): ?>
		<tr>
			<td><?= h($users->id) ?></td>
			<td><?= h($users->username) ?></td>
			<td><?= h($users->email) ?></td>
			<td><?= h($users->created) ?></td>
			<td><?= h($users->modified) ?></td>
			<td><?= $users->active ? $this->Html->icon('', ['class' => 'fa-check']) : $this->Html->icon('', ['class' => 'fa-times']); ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id], ['class' => 'btn btn-primary', 'icon' => 'fa-eye']); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id], ['class' => 'btn btn-warning', 'icon' => 'fa-edit']); ?>
				<?= $this->Html->link(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['title' => __('Are you sure you want to delete {0}?', $users->username), 'class' => 'btn btn-danger', 'icon' => 'fa-trash-o']); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	<div class="actions">
		<?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-info']); ?>
	</div>
</div>
