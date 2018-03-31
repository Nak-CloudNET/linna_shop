<script type="text/javascript">
	var count = 1;
    $(document).ready(function () {

    	$("#slref").attr('readonly','readonly');
		$('#ref_st').on('ifChanged', function() {
		  if ($(this).is(':checked')) {
			$("#slref").prop('readonly', false);
			$("#slref").val("");
		  }else{
			$("#slref").prop('readonly', true);
			var temp = $("#temp_reference_no").val();
			$("#slref").val(temp);
			
		  }
		});

		<?php if ($this->input->post('customer')) { ?>
        $('#customer').val(<?= $this->input->post('customer') ?>).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "customers/suggestions/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data.results[0]);
                    }
                });
            },
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

        $('#customer').val(<?= $this->input->post('customer') ?>);
        <?php } ?>
		
		$("#add_item").autocomplete({
            source: function (request, response) {
				$.ajax({
					type: 'get',
					url: '<?= site_url('products/suggestionsStock'); ?>',
					dataType: "json",
					data: {
						term: request.term,
						warehouse_id: $("#from_location").val()
					},
					success: function (data) {
						response(data);
					}
				});
            },
			minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_using_stock_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
		
		$('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });
		
		$("#date").datetimepicker({
				format: site.dateFormats.js_sdate, 
				fontAwesome: true, 
				todayBtn: 1, 
				autoclose: 1, 
				minView: 2 
			}).datetimepicker('update', new Date());
		$('.datetime').datetimepicker({format: 'yyyy-mm-dd'});
		
		if (localStorage.getItem('poitems')) {
			localStorage.removeItem('poitems');
		}
		if (localStorage.getItem('from_location')) {
			localStorage.removeItem('from_location');
		}
		if (localStorage.getItem('authorize_id')) {
			localStorage.removeItem('authorize_id');
		}
		if (localStorage.getItem('employee_id')) {
			localStorage.removeItem('employee_id');
		}
		if (localStorage.getItem('shop')) {
			localStorage.removeItem('shop');
		}
		if (localStorage.getItem('account')) {
			localStorage.removeItem('account');
		}
		if (localStorage.getItem('slref')) {
			localStorage.removeItem('slref');
		}

		if (localStorage.getItem('remove_slls')) {
            if (localStorage.getItem('slref')) {
                localStorage.removeItem('slref');
            }
            localStorage.removeItem('remove_slls');
        }

    });
</script>

<?php echo form_open("products/add_using_stock"); ?>

<div class="box">
    <div class="box-header">
        <h2 class="blue">
			<i class="fa-fw fa fa-heart"></i><?= lang('add_stock_using'); ?> 
		</h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
				
				<div class="clearfix"></div>
					
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<?= lang('date', 'date'); ?>
							<?= form_input('date', '', 'class="form-control tip date" required id="date"'); ?>
						</div>

						<div class="form-group">
							<?= lang("reference_no", "slref"); ?>
							<div class="input-group">  
									<?php echo form_input('reference_no', $reference ? $reference :"",'class="form-control input-tip" id="slref"'); ?>
									<input type="hidden"  name="temp_reference_no"  id="temp_reference_no" value="<?= $reference ? $reference :"" ?>" />
								<div class="input-group-addon no-print" style="padding: 2px 5px;background-color:white;">
									<input type="checkbox" name="ref_status" id="ref_st" value="1" style="margin-top:3px;">
								</div>
							</div>
						</div>

						<div class="form-group all">
                            <?= lang("from_location", "from_location") ?>
                            <?php
								$wh[""]="";
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->code .'-'. $warehouse->name;
                                }
                          
								echo form_dropdown('from_location', $wh, '', 'class="form-control"   required  id="from_location" placeholder="' . lang("select") . ' ' . lang("location") . '" style="width:100%"')
                            ?>
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<?= lang('authorize_by', 'authorize_by'); ?>
							<?php
                            
                                foreach ($AllUsers as $AU) {
                                    $users[$AU->id] = $AU->username;
                                }
                          
                            echo form_dropdown('authorize_id', $users,'', 'class="form-control"  required  id="authorize_id" placeholder="' . lang("select") . ' ' . lang("authorize_id") . '" style="width:100%"')
                            ?>
						</div>
						<div class="form-group">
							<?= lang('employee', 'employee'); ?>
							<?php
                            
                                foreach ($employees as $epm) {
                                    $em[$epm->id] = $epm->fullname;
                                }
                          
                            echo form_dropdown('employee_id', $em,'', 'class="form-control"    id="employee_id" placeholder="' . lang("select") . ' ' . lang("employee") . '" style="width:100%"')
                            ?>
							
						</div>
						<div class="form-group">
							<?= lang('project', 'project'); ?>
							 <?php
							 foreach ($biller as $bl) {
                                    $billers[$bl->id] = $bl->code .'-'.$bl->company;
                                }
                            echo form_dropdown('shop', $billers,$setting->site_name, 'class="form-control"   required  id="shop" placeholder="' . lang("select") . ' ' . lang("shop") . '" style="width:100%"')
                            ?>
						</div>
					</div>
					<div class="col-md-4">			
						<div class="form-group">
							<?= lang('account', 'account'); ?>
							<?php
								$gl[""] = "";
                                foreach ($getGLChart as $GLChart) {
                                    $gl[$GLChart->accountcode] = $GLChart->accountcode.' - '.$GLChart->accountname;
                                }
                          
                            echo form_dropdown('account', $gl, '', 'class="form-control"  required  id="account" placeholder="' . lang("select") . ' ' . lang("account") . '" style="width:100%"')
                            ?>
						</div>
						<div class="form-group all">
	                        <?= lang("note", "note") ?>
	                        <?= form_textarea('note','', 'class="form-control" id="note"'); ?>
	                    </div>
					</div>
				</div>	
				
				<div class="row">
					<div class="col-md-12 pr_form" id="sticker">
						<div class="well well-sm">
							<div class="form-group" style="margin-bottom:0;">
								<div class="input-group wide-tip">
									<div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
									<i class="fa fa-2x fa-barcode addIcon"></i></div>
									<?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . $this->lang->line("add_product_to_order") . '"'); ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 pr_form">
						<div class="table-responsive">
							<table id="UsData" class="table table-bordered table-hover table-striped table-condensed reports-table">
								<thead>
									<tr>
										<th style="width:33% !important;">
											<span><?= lang("item_code"); ?></span>
										</th>
										<th style="width:25% !important;"><?= lang("description"); ?></th>
										<th style="width:8% !important;"><?= lang("unit_cost"); ?></th>
										<th style="width:5% !important;"><?= lang("QOH"); ?></th>
										<th style="width:15% !important;"><?= lang("qty_use"); ?></th>
										<th style=""><?= lang("units"); ?></th>
										<th style="width:3% !important;"><i class="fa fa-trash-o" aria-hidden="true"></i></th>
									</tr>
								</thead>
								<tbody class="tbody"></tbody>
							</table>
						</div>
					</div>
				</div>
				
				<!-- Button Submit -->
				<div class="row">
					<div class="col-md-12">
						<div class="fprom-group">
							<input type="hidden"  name="total_item_cost" required id="total_item_cost" class=" form-control total_item_cost" value="">
							
							<?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?>
							
							<button type="button" name="convert_items" class="btn btn-danger" id="reset"><?= lang('reset') ?></button>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
				
            </div>
        </div>
    </div>
	<?php
		$units[""] = "";
		foreach ($all_unit as $getunits) {
			$units[$getunits->id] = $getunits->name;
		}
		$dropdown= form_dropdown("purchase_type", $units, '', 'id="purchase_type"  class="form-control input-tip select" style="width:100%;"');
	?>
</div>

<?php
$unit_option='';
	foreach($all_unit as $getunits){
		$unit_option.= '<option value='.$getunits->id.'>'.$getunits->name.'</option>';
	}
?>