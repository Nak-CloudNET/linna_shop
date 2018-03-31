<div class="modal-dialog">

    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
			<h4 class="modal-title"><?= lang('transfer_owner');?></h4>
		</div>
		<?php
			$attrib = array('data-toggle' => 'validator', 'role' => 'form');
            echo form_open_multipart("sales/trasfer_submit/".$id, $attrib);
		?>
		<div class="modal-body">
			<div class="row">
			
				<div class="col-md-12">
					<div class="form-group">
						<?= lang("customer", "slcustomer"); ?>
						<?php if ($Owner || $Admin || $GP['customers-add']) { ?><div class="input-group"><?php } ?>
							<?php
							echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : ""), 'id="slcustomer" data-placeholder="' . lang("select") . ' ' . lang("customer") . '" required="required" class="form-control input-tip" style="width:100%;"');
							?>
							<?php if ($Owner || $Admin || $GP['customers-add']) { ?>
							<div class="input-group-addon no-print" style="padding: 2px 5px;">
								<a href="<?= site_url('customers/add'); ?>" data-toggle="modal" data-target="#myModal2"><i class="fa fa-2x fa-plus-circle" id="addIcon"></i></a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php 
					$curDate = date("Y-m-d h:i:sa");
				?>
				<input type="hidden" name="transfer_date" value="<?php echo $curDate ?>">
				
				<div class="col-md-12">
					<div class="form-group">
						<?= lang("sold_amount"); ?>
						<input type="text" name="sold_amount" class="form-control" value="<?= $transfer_owner->grand_total ?>" style="pointer-events:none" />
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<?= lang("charge_amount"); ?>
						<input type="text" name="charge_amount" class="form-control">
					</div>
				</div>
				
		</div>
		</div>
		<div class="modal-footer">
			<?php echo form_submit('transfer', lang('add_transfer'), 'class="btn btn-primary"'); ?>
		</div>
		<?php echo form_close(); ?>
    </div>
	<?= $modal_js; ?>
	<script>
		$(document).ready(function(){
			var slcustomer = '<?= $id; ?>';
			$('#slcustomer').select2({
				minimumInputLength: 1,
				ajax: {
					url: site.base_url + "customers/suggestions",
					dataType: 'json',
					quietMillis: 15,
					data: function (term, page) {
						return {
							term: term,
							limit: 10
						};
					},
					results: function (data, page) {
						if (data.results != null) {
							return {results: data.results};
						} else {
							return {results: [{id: '', text: 'No Match Found'}]};
						}
					}
				}
			});
		});
	</script>
</div>