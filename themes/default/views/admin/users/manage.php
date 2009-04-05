<?php
/*
 * Variables:
 * $users = ORM_Iterator of all the user objects
 */
?>

<div>
	<h1>Users</h1>
	<table class="admin">
		<tr>
			<th>Username</th>
			<th>E-Mail</th>
			<th>Actions</th>
		</tr>
		<?php foreach($users as $user): ?>
		<tr>
			<td><?php echo $user->username; ?></td>
			<td><?php echo $user->email; ?></td>
			<td>
				<?php echo html::anchor('admin/users/edit/'.$user->id,
					html::image('media/images/fam_silk/wrench.png',
						array('alt'=>'Edit', 'title'=>'Edit'))); ?>
			-
				<?php echo html::anchor('admin/users/delete/'.$user->id,
					html::image('media/images/fam_silk/bin.png',
						array('alt'=>'Delete', 'title'=>'Delete'))); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="3"><?php echo html::anchor('admin/users/create', 'Create New User'); ?></th>
		</tr>
	</table>	
</div>

