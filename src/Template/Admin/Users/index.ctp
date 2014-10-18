<?php $this->extend('/Admin/Common/index'); ?>

<?php $this->assign('title', __('Users')); ?>
<?php
$this->start('search');
	echo $this->Form->create(null, [
		'class' => 'form-inline',
	    'url' => [
	        'action' => 'index'
	    ]
	]);
	echo $this->Form->input('search', [
        'label' => false,
		'placeholder' => __('Username or email'),
		'class' => '',
		'div' => false
    ]);
	echo $this->Form->submit(__('Search'), [
        'class' => 'btn btn-default'
	]);
	echo $this->Form->end();
$this->end();
?>

<table class="table table-striped">
	<tr>
		<th><?= $this->Paginator->sort('id'); ?></th>
		<th><?= $this->Paginator->sort('username'); ?></th>
		<th><?= $this->Paginator->sort('email'); ?></th>
		<th><?= $this->Paginator->sort('created'); ?></th>
		<th><?= $this->Paginator->sort('modified'); ?></th>
		<th><?= $this->Paginator->sort('active'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?= h($user->id); ?>&nbsp;</td>
		<td><?= h($user->username); ?>&nbsp;</td>
		<td><?= h($user->email); ?>&nbsp;</td>
		<td><?= h($user->created); ?>&nbsp;</td>
		<td><?= h($user->modified); ?>&nbsp;</td>
		<td><?= $user->active ? $this->Html->icon('', ['class' => 'fa-check']) : $this->Html->icon('', ['class' => 'fa-times']); ?>&nbsp;</td>
		<td class="actions">
			<?= $this->Html->link(__('View'), ['action' => 'view', $user->id], ['class' => 'btn btn-sm btn-primary', 'icon' => 'fa-eye']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'btn btn-sm btn-warning', 'icon' => 'fa-edit']); ?>
			<?= $this->Html->link(__('Delete'), ['action' => 'delete', $user->id], ['title' => __('Are you sure you want to delete {0}?', $user->username), 'class' => 'btn btn-sm btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
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