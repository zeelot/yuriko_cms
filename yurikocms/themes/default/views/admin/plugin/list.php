<?php
/**
 * admin/plugin/list.php
 *
 * @param Sprig		$plugins
 * @param String	$pagination
 */
?>

<table>
	<thead>
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Title'); ?></th>
			<th><?php echo __('Status'); ?></th>
		</tr>
	</thead>
	<tbody>

	<?php foreach($plugins as $plugin): ?>

	<tr>
		<td><?php echo $plugin->name; ?></td>
		<td><?php echo $plugin->title; ?></td>
		<td><?php echo $plugin->status; ?></td>
	</tr>

	<?php endforeach; ?>

	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">Pagination: </td>
		</tr>
	</tfoot>
</table>