<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_customer_group'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/add_customer_group", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label for="name"><?php echo $this->lang->line("group_name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('name', '', 'class="form-control" id="name" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label for="percent"><?php echo $this->lang->line("group_percentage"); ?></label>

                <div
                    class="controls"> <?php echo form_input('percent', '', 'class="form-control" id="percent" required="required"'); ?> </div>
            </div>
			
			<div class="form-group">
			   <input type="checkbox" name="makeup_cost" id="makeup_cost" class="form-control" value="1" <?php echo set_checkbox('makeup_cost', '1'); ?> >
				<?= lang("makeup_cost", "makeup_cost"); ?>
			</div>
			
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_customer_group', lang('add_customer_group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?= $modal_js ?>