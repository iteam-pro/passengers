<?php $this->extend('/Admin/Common/form'); ?>

<?php $this->assign('title', __('Edit User')); ?>

<?php $this->assign('form_create', $this->Form->create($user)); ?>

<?php
	echo $this->Form->input('id');
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('password_confirm', ['label' => __('Password confirmation')]);
	echo $this->Form->input('email', ['label' => __('Email')]);
	echo $this->Form->input('role_id', ['label' => __('Role for user'), 'options' => $roles]);
	echo $this->Form->input('active', ['label' => __('Is Active')]);
?>

<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

<?php $this->assign('form_end', $this->Form->end()); ?>

<?php $this->start('actions'); ?>
<div class="btn-group">
	<?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'btn btn-primary']); ?>
	<?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index'], ['class' => 'btn btn-default']); ?>
	<?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add'], ['class' => 'btn btn-default']); ?> 
	<?= $this->Html->link(__('Delete'), ['action' => 'delete', $user->id], ['title' => __('Are you sure you want to delete {0}?', $user->username), 'class' => 'btn btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
</div>
<?php $this->end(); ?>