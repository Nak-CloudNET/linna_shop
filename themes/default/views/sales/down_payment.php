<?php /* $this->erp->print_arrays($customer); */ ?>
<div class="row">

    <div class="col-sm-2">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div style="max-width:200px; margin: 0 auto;">
                    <?=
                    $user->avatar ? '<img alt="" src="' . base_url() . 'assets/uploads/avatars/thumbs/' . $user->avatar . '" class="avatar">' :
                        '<img alt="" src="' . base_url() . 'assets/images/' . $user->gender . '.png" class="avatar">';
                    ?>
                </div>
                <h4><?= lang('login_email'); ?></h4>

                <p><i class="fa fa-envelope"></i> <?= $user->email; ?></p>
            </div>
        </div>
    </div>

    <div class="col-sm-10">

        <ul id="myTab" class="nav nav-tabs">
            <li class=""><a href="#edit" class="tab-grey"><?= lang('Customer Info') ?></a></li>
            <li class=""><a href="#cpassword" class="tab-grey"><?= lang('Product Info') ?></a></li>
            <li class=""><a href="#avatar" class="tab-grey"><?= lang('Down Payment') ?></a></li>
			<li class=""><a href="#product" class="tab-grey"><?= lang('Amount') ?></a></li>
        </ul>

        <div class="tab-content">
            <div id="edit" class="tab-pane fade in">

                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-edit nb"></i><?= lang('Customer Info'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                                echo form_open('auth/edit_user/' . $user->id, $attrib);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
									
									
										<table width="100%" style="line-height:31px">
											<tr>
												<td width="25%" style="font-family:'Khmer OS Muol Light'; font-size:14px;"> <?= lang('អតិថិជន / Customer');?> </td>
												<td width="50%">: <?= $customer->name ? $customer->name : $customer->company; ?> </td>
												<td width="5px" rowspan="2"> </td>
												<td width="10%" rowspan="2"> <?= lang('លេខវិក្ក័យបត្រ <br/> Invoice No');?> </td>
												<td width="15%" rowspan="2" style="padding-left:0px;">: <?= $inv->reference_no; ?> </td>
											</tr>
											<tr>
												<td width="25%" style="font-family:'Khmer OS'; font-size:14px;"> <?= lang('ឈ្មោះ​ក្រុមហ៊ុន ឬ អតិថិជន <br/> Company name / Customer');?> </td>
												<td width="50%">: <?= $customer->company ? $customer->company : $customer->name; ?> </td>
											</tr>
											<tr>
												<td width="25%" style="font-family:'Khmer OS Muol Light'; font-size:14px;"> <?= lang('ទូរស័ព្ទ​លេខ / Telephone No');?> </td>
												<td width="50%">: <?= $customer->phone; ?> </td>
												<td width="5px" rowspan="2"> </td>
												<td width="10%" rowspan="2"> <?= lang('កាលបរិច្ឆេទ <br/> Date');?> </td>
												<td width="15%" rowspan="2" style="padding-left:0px;">: <?= $this->erp->hrld($inv->date); ?> </td>
											</tr>
											<tr>
												<td width="25%" style="font-family:'Khmer OS'; font-size:14px;"> <?= lang('លេខអត្តសញ្ញាណកម្ម អតប  (VATTIN)');?></td>
												<td width="50%">: <?= $customer->vat_no; ?></td>
											</tr>
										</table>
									

                                    </div>
                                </div>
                                <p><?php  /* echo form_submit('update', lang('update'), 'class="btn btn-primary" id="updateUser"');  */?></p>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="cpassword" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-key nb"></i><?= lang('Product_info'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped print-table order-table">

									<thead>

									<tr>
										<th><?= lang("no"); ?></th>
										<?php if($setting->show_code == 1 && $setting->separate_code == 1) { ?>
										<th><?= lang('product_code'); ?></th>
										<?php } ?>
										<th><?= lang("description"); ?></th>
										<th><?= lang("unit"); ?></th>
										<th><?= lang("quantity"); ?></th>
										<th><?= lang("unit_price"); ?></th>
										<?php
										if ($Settings->tax1) {
											echo '<th>' . lang("tax") . '</th>';
										}
										if ($Settings->product_discount && $inv->product_discount != 0) {
											echo '<th>' . lang("discount") . '</th>';
										}
										?>
										<th><?= lang("subtotal"); ?></th>
									</tr>

									</thead>

									<tbody>

									<?php $r = 1;
									$tax_summary = array();
									foreach ($rows as $row):
									$free = lang('free');
									$product_unit = '';
									$total = 0;
									
									if($row->variant){
										$product_unit = $row->variant;
									}else{
										$product_unit = $row->uname;
									}
									
									$product_name_setting;
									if($setting->show_code == 0) {
										$product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
									}else {
										if($setting->separate_code == 0) {
											$product_name_setting = $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : '');
										}else {
											$product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
										}
									}
									?>
										<tr>
											<td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
											<?php if($setting->show_code == 1 && $setting->separate_code == 1) { ?>
											<td style="vertical-align:middle;">
												<?= $row->product_code ?>
											</td>
											<?php } ?>
											<td style="vertical-align:middle;">
												<?= $product_name_setting ?>
												<?= $row->details ? '<br>' . $row->details : ''; ?>
												<?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
											</td>
											<td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $product_unit ?></td>
											<td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->erp->formatQuantity($row->quantity); ?></td>
											<td style="text-align:right; width:100px;"><?= $this->erp->formatMoney($row->unit_price); ?></td>
											<?php
											if ($Settings->tax1) {
												echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->erp->formatMoney($row->item_tax) . '</td>';
											}
											if ($Settings->product_discount && $inv->product_discount != 0) {
												echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->erp->formatMoney($row->item_discount) . '</td>';
											}
											?>
											<td style="text-align:right; width:120px;"><?= $row->subtotal!=0?$this->erp->formatMoney($row->subtotal):$free; 
												$total += $row->subtotal;
												?></td>
										</tr>
										<?php
										$r++;
									endforeach;
									?>
									<?php
									$col = 4;
									if($setting->show_code == 1 && $setting->separate_code == 1) {
										$col += 1;
									}
									if ($Settings->product_discount && $inv->product_discount != 0) {
										$col++;
									}
									if ($Settings->tax1) {
										$col++;
									}
									if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1) {
										$tcol = $col - 2;
									} elseif ($Settings->product_discount && $inv->product_discount != 0) {
										$tcol = $col - 1;
									} elseif ($Settings->tax1) {
										$tcol = $col - 1;
									} else {
										$tcol = $col;
									}
									?>
									<?php if ($inv->grand_total != $inv->total) { ?>
										<tr>
											<td></td>
											<td colspan="<?= $tcol; ?>"
												style="text-align:right; padding-right:10px;"><?= lang("total"); ?>
												(<?= $default_currency->code; ?>)
											</td>
											<?php
											if ($Settings->tax1) {
												echo '<td style="text-align:right;">' . $this->erp->formatMoney($inv->product_tax) . '</td>';
											}
											if ($Settings->product_discount && $inv->product_discount != 0) {
												echo '<td style="text-align:right;">' . $this->erp->formatMoney($inv->product_discount) . '</td>';
											}
											?>
											<td style="text-align:right; padding-right:10px;"><?= $this->erp->formatMoney($inv->total + $inv->product_tax); ?></td>
										</tr>
									<?php } ?>
									<?php if ($return_sale && $return_sale->surcharge != 0) {
										echo '<tr><td></td><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("return_surcharge") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoney($return_sale->surcharge) . '</td></tr>';
									}
									?>
									<?php if ($inv->order_discount != 0) {
										echo '<tr><td></td><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoney($inv->order_discount) . '</td></tr>';
									}
									?>
									<?php if ($Settings->tax2 && $inv->order_tax != 0) {
										echo '<tr><td></td><td colspan="' . $col . '" style="text-align:right; padding-right:10px;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoney($inv->order_tax) . '</td></tr>';
									}
									?>
									<?php if ($inv->shipping != 0) {
										echo '<tr><td></td><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoney($inv->shipping) . '</td></tr>';
									}
									?>
									<tr>
										<td></td>
										<td colspan="<?= $col; ?>"
											style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
											(<?= $default_currency->code; ?>)
										</td>
										<td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->erp->formatMoney($inv->grand_total); ?></td>
									</tr>
									<tr>
										<td></td>
										<td colspan="<?= $col; ?>"
											style="text-align:right; font-weight:bold;"><?= lang("paid"); ?>
											(<?= $default_currency->code; ?>)
										</td>
										<td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->paid); ?></td>
									</tr>
									<tr>
										<td></td>
										<td colspan="<?= $col; ?>"
											style="text-align:right; font-weight:bold;"><?= lang("balance"); ?>
											(<?= $default_currency->code; ?>)
										</td>
										<td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->grand_total - $inv->paid); ?></td>
									</tr>
									</tbody>
								</table>
							</div>
                        </div>
                    </div>
                </div>
            </div>
			<div id="avatar" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-file-picture-o nb"></i><?= lang('down_payment'); ?></h2>
                    </div>
                    <div class="box-content">
						<div class="row">
							<div class="col-md-0">
								<div class="col-md-4">
									
									<div class="form-group">
										<label for="slcustomer"><?= lang('Grand Total') ?></label>
										<input name="grand_total" type="text" id="grand_total" value="<?= $this->erp->formatDecimal($inv->grand_total - $inv->paid); ?>" style="pointer-events:none"
											   class="form-control grand_total"
											   placeholder="<?= lang('Grand Total') ?>"/>
									</div>
								</div>
								<div class="col-md-4">
									
									<div class="form-group">
										<label for="slcustomer"><?= lang('Deposit') ?></label>
										<input name="deposit" type="text" id="deposit" style="pointer-events:none"
											   class="form-control deposit"
											   placeholder="<?= lang('Deposit') ?>"/>
									</div>
								</div>
								<div class="col-md-4">
									
									<div class="form-group">
										<label for="slcustomer"><?= lang('Down Payment') ?></label>
										<input name="down_payment" type="text" id="down_payment"
											   class="form-control down_payment"
											   placeholder="<?= lang('Down Payment') ?>"/>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-0">
							   <div class="col-md-4">
									
									<div class="form-group">
										<label for="slcustomer"><?= lang('Loan Amount') ?></label>
										<input name="loan_amount" type="text" id="loan_amount"
											   class="form-control loan_amount"
											   placeholder="<?= lang('Loan Amount') ?>"/>
									</div>
								</div>
							</div>
						</div>
					
                        <div class="row">
							<div class="depreciation_1" >
							
								<div class="row">
									<div class="col-md-12">
										<div class="col-md-4">
											<div class="form-group">
												<input name="depreciation_rate1[]" type="text" id="depreciation_rate_1"
													   class="form-control depreciation_rate1"
													   placeholder="<?= lang('rate_percentage') ?>"/>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">

												<input name="depreciation_term[]" type="text" id="depreciation_term_1"
													   class="form-control kb-pad" value=""
													   placeholder="<?= lang('term_months') ?>"/>
												<input type="hidden" id="current_date" class="current_date" class="current_date[]" value="<?php echo date('m/d/Y'); ?>" />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<select name="frequency[]" id="frequency"
														class="form-control frequency"
														placeholder="<?= lang('frequency') ?>">
													<?php
													$opt ='<option value=""></option>';
													foreach($frequency AS $fre)
													{
														$opt.="<option value=".$fre->day .">".$fre->description ."</option>";
													}
													echo $opt;
													?>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<select name="depreciation_type[]" id="depreciation_type_1"
														class="form-control depreciation_type"
														placeholder="<?= lang('payment_type') ?>">
													<option value=""> &nbsp; </option>
													<option value="1"><?= lang("normal"); ?></option>
													<option value="2"><?= lang("custom"); ?></option>
													<option value="3"><?= lang("fixed"); ?></option>
													<option value="4"><?= lang("normal_fixed"); ?></option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<select name="principle_type[]" id="principle_type_1"
														class="form-control principle_type"
														placeholder="<?= lang('principle_type') ?>">
													<option value="none"> None </option>
													<?php foreach($principle as $data){ ?>
														<option value="<?=$data->id?>"><?= $data->name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									
									<div class="col-md-12">
										
										<div class="col-md-4">
											<div class="form-group" id="print_" style="display:none">
												<button type="button" class="btn btn-primary col-md-12 print_depre" id="print_depre" style="margin-bottom:5px;"><i class="fa fa-print"> &nbsp; </i>
													<?= lang('print') ?>
												</button>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" id="export_" style="display:none">
												<button type="button" class="btn btn-primary col-md-12 export_depre" id="export_depre" style="margin-bottom:5px;"><i class="fa fa-file-excel-o"> &nbsp; </i>
													<?= lang('export') ?>
												</button>
												<div style="clear:both; height:15px;"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="dep_tbl" style="display:none;">
										<table border="1" width="100%" class="table table-bordered table-condensed tbl_dep" id="tbl_dep1">
											<tbody>

											</tbody>
										</table>

									</div>
									<div class="dep_export" style="display:none;"></div>
								</div>
								<div class="form-group">
									<div class="dep_tbl" style="display:none;">
										<table border="1" width="100%" class="table table-bordered table-condensed tbl_dep" id="tbl_dep">
											<tbody>
										
											</tbody>
										</table>
										<table id="export_tbl" width="70%" style="display:none;">
										
										</table>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
			<div id="product" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-file-picture-o nb"></i><?= lang('product'); ?></h2>
                    </div>
                    <div class="box-content">
						<?php echo form_open_multipart("auth/update_permission/".$user->id); ?>
                        <div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th colspan="2"><?=lang('sales')?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?=lang('product_type')?></td>
										<td>
											<input type="checkbox" value="1" id="sales-standard" class="checkbox" name="sales_standard" <?php echo $p->{'sales_standard'} ? "checked" : ''; ?>><label
                                            for="sales-standard" class="padding05"><?= lang('standard') ?></label>
											<input type="checkbox" value="1" id="sales-combo" class="checkbox" name="sales_combo" <?php echo $p->{'sales_combo'} ? "checked" : ''; ?>><label
                                            for="sales-combo" class="padding05"><?= lang('combo') ?></label>
											<input type="checkbox" value="1" id="sales-digital" class="checkbox" name="sales_digital" <?php echo $p->{'sales_digital'} ? "checked" : ''; ?>><label
                                            for="sales-digital" class="padding05"><?= lang('digital') ?></label>
											<input type="checkbox" value="1" id="sales-service" class="checkbox" name="sales_service" <?php echo $p->{'sales_service'} ? "checked" : ''; ?>><label
                                            for="sales-service" class="padding05"><?= lang('service') ?></label>
										</td>
									</tr>
									<tr>
										<td style="width:20%;"><?=lang('category')?></td>
										<td style="width:80%;">
											<div class="input-group" style="width:100%;">
												<?php
													$cats = '';
													foreach ($cat as $cate) {
														$cats[$cate->id] = $cate->name;
													}
													echo form_dropdown('cate[]', $cats, '', 'id="cate" class="form-control" multiple="multiple"');
												?>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th colspan="2">
											<?=lang('purchases')?>
										</th>
									</tr>
									<tr>
										<td><?=lang('product_type')?></td>
										<td>
											<input type="checkbox" value="1" id="purchases-standard" class="checkbox" name="purchases_standard"  <?php echo $p->{'purchase_standard'} ? "checked" : ''; ?>><label
                                            for="purchases-standard" class="padding05"><?= lang('standard') ?></label>
											
											<input type="checkbox" value="1" id="purchases-combo" class="checkbox" name="purchases_combo" <?php echo $p->{'purchase_combo'} ? "checked" : ''; ?>><label
                                            for="purchases-combo" class="padding05"><?= lang('combo') ?></label> 
											
											<input type="checkbox" value="1" id="purchases-digital" class="checkbox" name="purchases_digital" <?php echo $p->{'purchase_digital'} ? "checked" : ''; ?>><label
                                            for="purchases-digital" class="padding05"><?= lang('digital') ?></label> 
											
											<input type="checkbox" value="1" id="purchases-service" class="checkbox" name="purchases_service" <?php echo $p->{'purchase_service'} ? "checked" : ''; ?>><label
                                            for="purchases-service" class="padding05"><?= lang('service') ?></label>
										</td>
									</tr>
									<tr>
										<td style="width:20%;"><?=lang('category')?></td>
										<td style="width:80%;">
											<div class="input-group" style="width:100%;">
												<?php
													$cats = '';
													foreach ($cat as $cate) {
														$cats[$cate->id] = $cate->name;
													}
													echo form_dropdown('pcate[]', $cats, '', 'id="pcate" class="form-control" multiple="multiple"');
												?>
											</div>
										</td>
									</tr>
								</thead>
							</table>
						</div>
						<?php echo form_submit('update_permission', lang('update_permission'), 'class="btn btn-primary"'); ?>
						<?php echo form_close(); ?>
					</div>
                </div>
            </div>
        </div>
    </div>
	
	
	
    <script>
        $(document).ready(function () {
            $('#change-password-form').bootstrapValidator({
                message: 'Please enter/select a value',
                submitButtons: 'input[type="submit"]'
            });
        });
    </script>
	
	
    <?php if ($Owner && $id != $this->session->userdata('user_id')) {
		?>
    <script type="text/javascript" charset="utf-8">
	
		$("#down_payment").on("change",function()
		{
			
			var ds 			  = $(this).val();
			var down_payment  = 0 ;
			
			var grand_total   = $("#grand_total").val()-0;
			var deposit       = $("#deposit").val()-0;
			var balance		  = parseFloat(grand_total-deposit);
            if (ds.indexOf("%") !== -1) {
				
                var pds = ds.split("%");
                if (!isNaN(pds[0])) {
                    down_payment = parseFloat(((balance) * parseFloat(pds[0])) / 100);
                } else {
                    down_payment = parseFloat((balance * ds) / 100);
                }
				$(this).val((down_payment).toFixed(2));
            } else {
                down_payment = (parseFloat(ds));
				
            }
			
			$("#loan_amount").val((balance-down_payment).toFixed(2));
		});
		
		/* ######Loan Funtion###### */
		
		$(document).on('change','#depreciation_type_1, #depreciation_rate_1, #depreciation_term_1',function() {
			$("#depreciation_term_1,#frequency,#depreciation_type_1").attr("disabled",false);
			var p_type = $('#depreciation_type_1').val();
			var pr_type = $('#principle_type_1').val();
			var rate = $('#depreciation_rate_1').val();
			var term = $('#depreciation_term_1').val();
			var frequency = $("#frequency option:selected").val();
			var total_amount = $('#grand_total').val()-0;
			var down_pay = $('#down_payment').val();
			var loan_amount = total_amount - down_pay;
			if(!pr_type) {
				depreciation(loan_amount,rate,term,frequency,p_type,total_amount, new Date());
			}
		});
		
		
		$(document).on('change','#principle_type_1',function()
		{
			var option = $("#principle_type_1 option:selected").val();
			if(option!='none')
			{
				$("#depreciation_term_1,#frequency,#depreciation_type_1").attr("disabled",true);
			}else{
				$("#depreciation_term_1,#frequency,#depreciation_type_1").attr("disabled",false);
			}
			
			if(option!='none')
			{
				principal(option);
			}
			
			
		});
		
		
		function principal(principal_id)
		{
			var principal_id = principal_id;
			
			$.ajax({
					type: 'post',
					url: '<?= site_url('sales'); ?>',
					dataType: "json",
					data: {
						term: 'term',
						principal_id: principal_id
					},
					success: function (data) {
						
					}
			});   
			
			
			/* tr += '<tr>';
			tr += '<th class="text-center"> <?= lang("period"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("rate"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("percentage"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("payment"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("total_payment"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("balance"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("note"); ?> </th>';
			tr += '<th class="text-center"> <?= lang("dateline"); ?> </th>';
			tr += '</tr>';
		
			var principle = amount/term;
			var interest = 0;
			var balance = amount;
			var payment = 0;
			var k=0;
			var total_principle = 0;
			var total_payment = 0;
			for(i=1;i<=term;i++){
				if(i== 1){
					interest = (amount*(rate/100));
					var dateline = moment(start_date).format('DD/MM/YYYY');
				}else{
					interest = balance *((rate/100));
					var dateline = moment(start_date).add(k,'days').format('DD/MM/YYYY');
				}
				balance -= principle;
				if(balance <= 0){
					balance = 0;
				}
				payment = principle + interest;
				tr += '<tr> <td class="text-center">'+ i +'<input type="hidden" name="no[]" id="no" class="no" value="'+ i +'" /></td> ';
				tr += '<td>'+ formatMoney(interest) +'<input type="hidden" name="interest[]" id="interest" class="interest" width="90%" value="'+ formatDecimal(interest) +'"/></td>';
				tr += '<td>'+ formatMoney(principle) +'<input type="hidden" name="principle[]" id="principle" class="principle" width="90%" value="'+ formatDecimal(principle) +'"/></td>';
				tr += '<td>'+ formatMoney(payment) +'<input type="hidden" name="payment_amt[]" id="payment_amt" class="payment_amt" width="90%" value="'+ formatDecimal(payment) +'"/></td>';
				tr += '<td>'+ formatMoney(balance) +'<input type="hidden" name="balance[]" id="balance" class="balance" width="90%" value="'+ formatDecimal(balance) +'"/></td>';
				tr += '<td> <input name="note[]" class="note form-control" id="'+i+'" ></input> <input type="hidden" name="note1[]" id="note1" class="note1_'+i+'" width="90%"/></td>';
				tr += '<td>'+ dateline +'<input type="hidden" class="dateline" name="dateline[]" id="dateline" value="'+ dateline +'" /> </td> </tr>';
				total_principle += principle;
				total_payment += payment;
				k+= frequency;
			}
			tr += '<tr> <td colspan="2"> <?= lang("total"); ?> </td>';
			tr += '<td>'+ formatMoney(total_principle) +'</td>';
			tr += '<td>'+ formatMoney(total_payment) +'</td>';
			tr += '<td colspan="3"> &nbsp; </td> </tr>'; */
			
			
		}
		
		
		
		function depreciation(amount,rate,term_of_day,frequency,p_type,total_amount, start_date){
			
			var term = (term_of_day/frequency).toFixed(0);
			frequency = parseFloat(frequency);
			var d = new Date();
			if(p_type == ''){
				$('#print_').hide();
				$('#export_').hide();
				return false;
			}else{
				$('#print_').show();
				$('#export_').show();
				if(rate == '' || rate < 0) {
					if(term == '' || term <= 0) {
						$('.dep_tbl').hide();
						alert("Please choose Rate and Term again!");
						return false;
					}else{
						$('.dep_tbl').hide();
						alert("Please choose Rate again!"); 
						return false;
					}
				}else{
					if(term == '' || term <= 0) {
						$('.dep_tbl').hide();
						alert("Please choose Term again!"); 
						return false;
					}else{
						var tr = '';
						if(p_type == 1 || p_type == 3 || p_type == 4){
							tr += '<tr>';
							tr += '<th class="text-center"> <?= lang("Pmt No."); ?> </th>';
							tr += '<th class="text-center"> <?= lang("interest"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("principal"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("total_payment"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("balance"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("note"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("payment_date"); ?> </th>';
							tr += '</tr>';
						}else if(p_type == 2){
							tr += '<tr>';
							tr += '<th class="text-center"> <?= lang("period"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("rate"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("percentage"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("payment"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("total_payment"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("balance"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("note"); ?> </th>';
							tr += '<th class="text-center"> <?= lang("dateline"); ?> </th>';
							tr += '</tr>';
						}
						if(p_type == 1){
							var principle = amount/term;
							var interest = 0;
							var balance = amount;
							var payment = 0;
							var k=0;
							var total_principle = 0;
							var total_payment = 0;
							for(i=1;i<=term;i++){
								if(i== 1){
									interest = (amount*(rate/100));
									var dateline = moment(start_date).format('DD/MM/YYYY');
								}else{
									interest = balance *((rate/100));
									var dateline = moment(start_date).add(k,'days').format('DD/MM/YYYY');
								}
								balance -= principle;
								if(balance <= 0){
									balance = 0;
								}
								payment = principle + interest;
								tr += '<tr> <td class="text-center">'+ i +'<input type="hidden" name="no[]" id="no" class="no" value="'+ i +'" /></td> ';
								tr += '<td>'+ formatMoney(interest) +'<input type="hidden" name="interest[]" id="interest" class="interest" width="90%" value="'+ formatDecimal(interest) +'"/></td>';
								tr += '<td>'+ formatMoney(principle) +'<input type="hidden" name="principle[]" id="principle" class="principle" width="90%" value="'+ formatDecimal(principle) +'"/></td>';
								tr += '<td>'+ formatMoney(payment) +'<input type="hidden" name="payment_amt[]" id="payment_amt" class="payment_amt" width="90%" value="'+ formatDecimal(payment) +'"/></td>';
								tr += '<td>'+ formatMoney(balance) +'<input type="hidden" name="balance[]" id="balance" class="balance" width="90%" value="'+ formatDecimal(balance) +'"/></td>';
								tr += '<td> <input name="note[]" class="note form-control" id="'+i+'" ></input> <input type="hidden" name="note1[]" id="note1" class="note1_'+i+'" width="90%"/></td>';
								tr += '<td>'+ dateline +'<input type="hidden" class="dateline" name="dateline[]" id="dateline" value="'+ dateline +'" /> </td> </tr>';
								total_principle += principle;
								total_payment += payment;
								k+= frequency;
							}
							tr += '<tr> <td colspan="2"> <?= lang("total"); ?> </td>';
							tr += '<td>'+ formatMoney(total_principle) +'</td>';
							tr += '<td>'+ formatMoney(total_payment) +'</td>';
							tr += '<td colspan="3"> &nbsp; </td> </tr>';
						}else if(p_type == 2) {
							var principle = 0;
							var interest = 0;
							var percent = 0;
							var balance = amount;
							var rate_amount = ((rate/100));
							var payment = ((amount * rate_amount)*((Math.pow((1+rate_amount),term))/(Math.pow((1+rate_amount),term)-1)));
							var k=0;
							var total_principle = 0;
							var total_payment = 0;
							for(i=1;i<=term;i++){
								if(i== 1){
									interest = (amount*(rate/100));
									var dateline = moment(start_date).format('DD/MM/YYYY');
									principle = payment - interest;
									percent = (principle / balance) * 100;
									balance -= principle;
									if(balance <= 0){
										balance = 0;
									}
									tr += '<tr> <td class="text-center">'+ i +'<input type="hidden" name="no[]" id="no" class="no" value="'+ i +'" /></td> ';
									tr += '<td><input type="text" name="rate[]" id="rate" class="rate" style="width:60px;" value="'+ formatDecimal(interest) +'"/><input type="hidden" name="interest[]" id="interest" class="interest" width="90%" value="'+ formatDecimal(interest) +'"/></td>';
									tr += '<td><input type="text" name="percentage[]" id="percentage" class="percentage" style="width:60px;" value="'+ percent.toFixed(4) +'"/><input type="hidden" name="percentage_[]" id="percentage_" class="percentage_" style="width:60px;" value="'+ percent +'"/></td>';
									tr += '<td><input type="text" name="pmt_principle[]" id="pmt_principle" class="pmt_principle" style="width:60px;" value="'+ formatDecimal(principle) +'" /><input type="hidden" name="principle[]" id="principle" class="principle" width="90%" value="'+ formatDecimal(principle) +'"/></td>';
									tr += '<td><input type="text" name="total_payment[]" id="total_payment" class="total_payment" style="width:60px;" value="'+ formatDecimal(payment) +'" readonly/><input type="hidden" name="payment_amt[]" id="payment_amt" class="payment_amt" width="90%" value="'+ formatDecimal(payment) +'"/></td>';
									tr += '<td><input type="text" name="amt_balance[]" id="amt_balance" class="amt_balance" style="width:60px;" value="'+ formatDecimal(balance) +'" readonly/><input type="hidden" name="balance[]" id="balance" class="balance" style="width:60px;" value="'+ formatDecimal(balance) +'"/></td>';
									tr += '<td> <input name="note[]" class="note form-control" id="'+i+'" ></input> <input type="hidden" name="note1[]" id="note1" class="note1_'+i+'" width="90%"/></td>';
									tr += '<td><input type="text" class="dateline" name="dateline[]" id="dateline" value="'+ dateline +'" size="6" /></td> </tr>';
								}else{
									interest = (balance *(rate/100));
									var dateline = moment(start_date).add(k,'days').format('DD/MM/YYYY');
									principle = payment - interest;
									percent = (principle / balance) * 100;
									balance -= principle;
									if(balance <= 0){
										balance = 0;
									}
									tr += '<tr> <td class="text-center">'+ i +'<input type="hidden" name="no[]" id="no" class="no" value="'+ i +'" /></td> ';
									tr += '<td><input type="text" name="rate[]" id="rate" class="rate" style="width:60px;" value="'+ formatDecimal(interest) +'"/><input type="hidden" name="interest[]" id="interest" class="interest" width="90%" value="'+ formatDecimal(interest) +'"/></td>';
									tr += '<td><input type="text" name="percentage[]" id="percentage" class="percentage" style="width:60px;" value="'+ percent.toFixed(4) +'"/><input type="hidden" name="percentage_[]" id="percentage_" class="percentage_" style="width:60px;" value="'+ percent +'"/></td>';
									tr += '<td><input type="text" name="pmt_principle[]" id="pmt_principle" class="pmt_principle" style="width:60px;" value="'+ formatDecimal(principle) +'" /><input type="hidden" name="principle[]" id="principle" class="principle" width="90%" value="'+ formatDecimal(principle) +'"/></td>';
									tr += '<td><input type="text" name="total_payment[]" id="total_payment" class="total_payment" style="width:60px;" value="'+ formatDecimal(payment) +'" readonly/><input type="hidden" name="payment_amt[]" id="payment_amt" class="payment_amt" width="90%" value="'+ formatDecimal(payment) +'"/></td>';
									tr += '<td><input type="text" name="amt_balance[]" id="amt_balance" class="amt_balance" style="width:60px;" value="'+ formatDecimal(balance) +'" readonly/><input type="hidden" name="balance[]" id="balance" class="balance" style="width:60px;" value="'+ formatDecimal(balance) +'"/></td>';
									tr += '<td> <input name="note[]" class="note form-control" id="'+i+'" ></input><input type="hidden" name="note1[]" id="note1" class="note1_'+i+'" width="90%"/></td>';
									tr += '<td><input type="text" class="dateline" name="dateline[]" id="dateline" value="'+ dateline +'" size="6" /></td> </tr>';
								}
								total_principle += principle;
								total_payment += payment;
								k+= frequency;
							}
							tr += '<tr> <td colspan="3"> <?= lang("Total"); ?> </td>';
							//tr += '<td><input type="text" name="total_percen" id="total_percen" class="total_percen" style="width:60px;" value="" readonly/></td>';
							tr += '<td><input type="text" name="total_pay" id="total_pay" class="total_pay" style="width:60px;" value="'+ formatDecimal(total_principle) +'" readonly/></td>';
							tr += '<td><input type="text" name="total_amount" id="total_amount" class="total_amount" style="width:60px;" value="'+ formatDecimal(total_payment) +'" readonly/></td>';
							tr += '<td colspan="3"> &nbsp; </td> </tr>';
						}else if(p_type == 3) {
							var principle = 0;
							var interest = 0;
							var balance = amount;
							var rate_amount = ((rate/100));
							var payment = ((amount * rate_amount)*((Math.pow((1+rate_amount),term))/(Math.pow((1+rate_amount),term)-1)));
							var k=0;
							var total_principle = 0;
							var total_payment = 0;
							for(i=1;i<term;i++){
								if(i== 1){
									interest = (amount*(rate/100));
									var dateline = moment(start_date).format('DD/MM/YYYY');
								}else{
									interest = ( balance *(rate/100));
									var dateline = moment(start_date).add(k,'days').format('DD/MM/YYYY');
								}
								principle = payment - interest;
								balance -= principle;
								if(balance <= 0){
									balance = 0;
								}
								tr += '<tr> <td class="text-center">'+ i +'<input type="hidden" name="no[]" id="no" class="no" value="'+ i +'" /></td> ';
								tr += '<td>'+ formatMoney(interest) +'<input type="hidden" name="interest[]" id="interest" class="interest" width="90%" value="'+ formatDecimal(interest) +'"/></td>';
								tr += '<td>'+ formatMoney(principle) +'<input type="hidden" name="principle[]" id="principle" class="principle" width="90%" value="'+ principle +'"/></td>';
								tr += '<td>'+ formatMoney(payment) +'<input type="hidden" name="payment_amt[]" id="payment_amt" class="payment_amt" width="90%" value="'+ formatDecimal(payment) +'"/></td>';								
								tr += '<td>'+ formatMoney(balance) +'<input type="hidden" name="balance[]" id="balance" class="balance" width="90%" value="'+ formatDecimal(balance) +'"/></td>';
								tr += '<td> <input name="note[]" class="note form-control" id="'+i+'" ></input> <input type="hidden" name="note1[]" id="note1" class="note1_'+i+'" width="90%"/></td>';
								tr += '<td>'+ dateline +'<input type="hidden" class="dateline" name="dateline[]" id="dateline" value="'+ dateline +'" /></td> </tr>';
								total_principle += principle;
								total_payment += payment;
								k+= frequency;
							}
							tr += '<tr> <td colspan="2"> <?= lang("Total"); ?> </td>';
							tr += '<td>'+ formatMoney(total_principle) +'</td>';
							tr += '<td>'+ formatMoney(total_payment) +'</td>';
							tr += '<td colspan="3"> &nbsp; </td> </tr>';
						} else if(p_type == 4){
							var principle = amount/term;
							var interest = (amount * (rate/100));
							var balance = amount;
							var payment = 0;
							var k=0;
							var total_principle = 0;
							var total_payment = 0;
							for(i=1;i<term;i++){
								if(i== 1){
									var dateline = moment(start_date).format('DD/MM/YYYY');
								}else{
									var dateline = moment(start_date).add(k,'days').format('DD/MM/YYYY');
								}
								payment = principle + interest;
								
								balance -= principle;
								if(balance <= 0){
									balance = 0;
								}
								tr += '<tr> <td class="text-center">'+ i +'<input type="hidden" name="no[]" id="no" class="no" value="'+ i+'" /></td> ';
								tr += '<td>'+ formatMoney(interest) +'<input type="hidden" name="interest[]" id="interest" class="interest" width="90%" value="'+ interest +'"/></td>';
								tr += '<td>'+ formatMoney(principle) +'<input type="hidden" name="principle[]" id="principle" class="principle" width="90%" value="'+ principle +'"/></td>';
								tr += '<td>'+ formatMoney(payment) +'<input type="hidden" name="payment_amt[]" id="payment_amt" class="payment_amt" width="90%" value="'+ payment +'"/></td>';
								tr += '<td>'+ formatMoney(balance) +'<input type="hidden" name="balance[]" id="balance" class="balance" width="90%" value="'+ balance +'"/></td>';
								tr += '<td> <input name="note[]" class="note form-control" id="'+i+'" ></input> <input type="hidden" name="note1[]" id="note1" class="note1_'+i+'" width="90%"/></td>';
								tr += '<td>'+ dateline +'<input type="hidden" class="dateline" name="dateline[]" id="dateline" value="'+ dateline +'" /> </td> </tr>';
								total_principle += principle;
								total_payment += payment;
								k+= frequency;
							}
							tr += '<tr> <td colspan="2"> <?= lang("total"); ?> </td>';
							tr += '<td>'+ formatMoney(total_principle) +'</td>';
							tr += '<td>'+ formatMoney(total_payment) +'</td>';
							tr += '<td colspan="3"> &nbsp; </td> </tr>';
						}
						$('.dep_tbl').show();
						$('#tbl_dep').html(tr);
						//$('#tbl_dep1').html(tr);
						$("#loan1").html(tr);
					}
				}
			}
		}
		
		
		
		
		/* ######End Funtion###### */
			
		
		
    </script>
<?php } ?>
