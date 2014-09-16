<?php $this->extend('/Admin/Common/form'); ?>

<?php $this->assign('title', __('User')); ?>

<dl class="dl-horizontal">
	<dt><?= __('Username'); ?></dt>
	<dd>
		<?= h($user->username); ?>
		&nbsp;
	</dd>
	<dt><?= __('Email'); ?></dt>
	<dd>
		<?= h($user->email); ?>
		&nbsp;
	</dd>
	<dt><?= __('Role'); ?></dt>
	<dd>
		<?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : ''; ?>
		&nbsp;
	</dd>
	<dt><?= __('Active'); ?></dt>
	<dd>
		<?= $user->active ? $this->Html->icon('', ['class' => 'fa-check']) : $this->Html->icon('', ['class' => 'fa-times']); ?>
		&nbsp;
	</dd>
	<dt><?= __('Created'); ?></dt>
	<dd>
		<?= h($user->created); ?>
		&nbsp;
	</dd>
	<dt><?= __('Modified'); ?></dt>
	<dd>
		<?= h($user->modified); ?>
		&nbsp;
	</dd>
</dl>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'btn btn-primary']); ?> 
	<?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'btn btn-warning']); ?> 
	<?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'btn btn-info']); ?> 
		<?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index'], ['class' => 'btn btn-default']); ?> 
		<?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add'], ['class' => 'btn btn-default']); ?> 
	<?= $this->Html->link(__('Delete User'), ['action' => 'delete', $user->id], ['title' => __('Are you sure you want to delete {0}?', $user->username), 'class' => 'btn btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
</div>
<?php $this->end(); ?>
