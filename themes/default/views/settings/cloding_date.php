<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('Closing_Date'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("system_settings/closing_date", $attrib); ?>
        <div class="modal-body">
            <div class="form-group">
                <?= lang("date", "date"); ?>
                <div class="controls">
                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="sldate"'); ?>
                </div>
            </div>
            <div class="form-group">
                <?= lang("Note", "note"); ?>
                <div id="note">
                    <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="slnote" style="margin-top: 10px; height: 100px;" '); ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('save_closing_date', lang('Save'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>