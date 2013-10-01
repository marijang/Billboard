<section class="title">
	<h4><?php echo lang('billboard:item_list'); ?></h4>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open('admin/billboard/delete');?>
	<?php if (!empty($billboard)): ?>
		<table border="0" class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('billboard:name'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $billboard as $item ): ?>
				<tr id="item_<?php echo $item->id; ?>">
					<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
					<td><?php echo $item->id; ?></td>
					<td class="actions">
						<?php echo
						//anchor('billboard', lang('billboard:view'), 'class="button" target="_blank"').' '.
						anchor('admin/billboard/edit/'.$item->id, lang('billboard:edit'), 'class="button"').' '.
						anchor('admin/billboard/delete/'.$item->id, 	lang('billboard:delete'), array('class'=>'button')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
	<?php else: ?>
		<div class="no_data"><?php echo lang('billboard:no_items'); ?></div>
	<?php endif;?>
	<?php echo form_close(); ?>
</div>
</section>