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
<?php $this->extend('/Admin/Common/active_cell'); ?>

<?php $this->assign('title', $this->Html->link($cell->title, ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'index'])) ?>

<table class="table table-striped table-condensed">
    <tr>
        <th><?= __('Username'); ?></th>
        <th><?= __('Email'); ?></th>
        <th><?= __('Created'); ?></th>
        <th><?= __('Active'); ?></th>
        <th class="actions"><?= __('Actions'); ?></th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= h($user->username); ?>&nbsp;</td>
        <td><?= h($user->email); ?>&nbsp;</td>
        <td><?= h($user->created); ?>&nbsp;</td>
        <td><?= $user->active ? $this->Html->icon('', ['class' => 'fa-check']) : $this->Html->icon('', ['class' => 'fa-times']); ?>&nbsp;</td>
        <td class="actions">
			<div class="btn-group btn-group-sm">
				<?= $this->Html->link(__('Delete'), ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'delete', $user->id], ['title' => __('Are you sure you want to delete {0}?', $user->username), 'class' => 'btn btn-danger btn-confirmation', 'icon' => 'fa-trash-o']); ?>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li>
						<?= $this->Html->link(__('View'), ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'view', $user->id], ['class' => '', 'icon' => 'fa-eye']); ?>
					</li>
					<li>
						<?= $this->Html->link(__('Edit'), ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'edit', $user->id], ['class' => '', 'icon' => 'fa-edit']); ?>
					</li>
				</ul>
			</div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
