<section class="title">
	<!-- We'll use $this->method to switch between billboard.create & billboard.edit -->
	<h4><?php echo lang('billboard:'.$this->method); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

		<div class="form_inputs">

			<ul class="fields">
				<li>
		<label for="title">Title</label>
		<div class="input">
		<?php echo form_input("title", set_value("title", $title)); ?>
		</div>
		</li><li>
		<label for="description">Description</label>
		<div class="input">
		<?php echo form_textarea("description", set_value("description", $description)); ?>
		</div>
		</li><li>
		<label for="date_available_from">Date_available_from</label>
		<div class="input">
		<?php echo form_input("date_available_from", set_value("date_available_from", $date_available_from)); ?>
		</div>
		</li><li>
		<label for="date_available_to">Date_available_to</label>
		<div class="input">
		<?php echo form_input("date_available_to", set_value("date_available_to", $date_available_to)); ?>
		</div>
		</li>
			<!-- <li>
				<label for="fileinput">Fileinput
					<?php if (isset($fileinput->data)): ?>
					<small>Current File: <?php echo $fileinput->data->filename; ?></small>
					<?php endif; ?>
					</label>
				<div class="input"><?php echo form_upload('fileinput', NULL, 'class="width-15"'); ?></div>
			</li> -->
		</ul>

	</div>

	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

	<?php echo form_close(); ?>
</div>
</section>