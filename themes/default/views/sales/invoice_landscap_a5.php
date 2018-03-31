<link href="<?= $assets ?>styles/helpers/bootstrap.min.css" rel="stylesheet"/>
<link href="<?= $assets ?>styles/helpers/font-awesome.min.css" rel="stylesheet"/>
<style>
	* {
		font-family: Times New Roman !important;
		font-size: 14px;
	}
	.panel-default {
		border-radius: 0;
		border: 1px solid #000;
	}
	
	.panel-body {
		padding: 5px;
	}
	
	.panel-footer {
		padding: 10px;
		background-color: #FFF !important;
		border-top: 1px solid #000;
	}
	
	.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #000 !important;}
	
	hr {
		border-top: 1px solid #000;
	}

</style>

<?php
	$address = '';
	$address.=$biller->address;
	$address.=($biller->city != '')? ', '.$biller->city : '';
	$address.=($biller->postal_code != '')? ', '.$biller->postal_code : '';
	$address.=($biller->state != '')? ', '.$biller->state : '';
	$address.=($biller->country != '')? ', '.$biller->country : '';
?>

<center>
	<div class="row" style="padding:5px; padding-left:10px; padding-right:10px;">
		<?php for($t=0;$t<2;$t++){ ?>
		
		<div class="col-sm-6">
		
			<div class="row">
			
				<div class="col-sm-4 col-md-4 col-xs-4">
					<img src="<?= base_url() . 'assets/uploads/logos/' . 'Beauty-Home-of-Beauty.png'; ?>" width="200px;" style="margin-top: 20px;" />
				</div>
				
				<div class="col-sm-4 col-md-4 col-xs-4" style="padding-top: 20px;">
					<h3>INVOICE</h3>
				</div>
				
				<div class="col-sm-4 col-md-4 col-xs-4" style="padding-top: 30px;">
					<span>
						<?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 70, false); ?>
							<img src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
								 alt="<?= $inv->reference_no ?>" style="height:30px"/>
								 <?php
								if($pos->display_qrcode) {
								?>
							<?php $this->erp->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
							<img src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
								 alt="<?= $inv->reference_no ?>"/>
						<?php } ?>
					</span>
				</div>
				
			</div>
			
			<div class="row" style="padding-left: 16px; padding-top: 20px;">
				<div class="col-sm-4">
					<p align="left">Date: <?= $this->erp->hrld($inv->date); ?></p>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-5">
					<p align="left">No: <?= $inv->reference_no; ?></p>
				</div>
			</div>
			
			<div class="row" style="padding-left: 16px; padding-top: 5px;">
			
				<div class="col-sm-5 col-md-5 col-xs-5">
				
					<div class="panel panel-default" style="margin-right: 20px;">
						<div class="panel-body">Customer</div>
						<div class="panel-footer" style="backgroud-color: #FFF !important;">
							<table width="100%">
								<tr style="line-height: 40px;">
									<td>Name</td>
									<td>:&nbsp;<?= $customer->name ? $customer->name : $customer->company; ?></td>
								</tr>
								<tr>
									<td>Tel</td>
									<td>:&nbsp;<?= $customer->phone; ?></td>
								</tr>
							</table>
						</div>
					</div>
					
					
				</div>
				
				<div class="col-sm-2 col-md-2 col-xs-2"></div>
				
				<div class="col-sm-5 col-md-5 col-xs-5">
				
					<div class="panel panel-default" style="margin-right: 16px;">
						<div class="panel-footer" style="backgroud-color: #FFF !important; border-top: none;">
							<table width="100%">
								<tr style="line-height: 40px;">
									<td>Email</td>
									<td>:&nbsp;<?= $inv->email ?></td>
								</tr>
								<tr>
									<td>Tel</td>
									<td>:&nbsp;<?= $inv->phone; ?></td>
								</tr>
								<tr style="line-height: 40px;">
									<td>Website</td>
									<td>:&nbsp;beautyplus.asia</td>
								</tr>
							</table>
						</div>
					</div>
					
					
				</div>
				
			</div>
			
		<table class="table-responsive" width="95%" border="0" cellspacing="0">
			<tr>
				<td colspan="2">
					<div class="table-responsive">
						<table class="table table-bordered print-table order-table" style="'font-family:Khmer OS'; font-size:10px;">

							<thead>

							<tr>
								<th style="text-align:center;"><?= lang("Nº"); ?></th>
								<th style="text-align:center;"><?= lang("Item_Code"); ?></th>
								<th style="text-align:center;"><?= lang("Description"); ?></th>
								<th style="text-align:center;"><?= lang("Quantity"); ?></th>
								<th style="text-align:center;"><?= lang("Price"); ?></th>
								<?php
								/*if ($Settings->tax1) {
									echo '<th style="text-align:center;">' . lang("អាករឯកតា <br/> Tax") . '</th>';
								}*/
								if ($Settings->product_discount && $inv->product_discount != 0) {
									echo '<th style="text-align:center;">' . lang("Discount") . '</th>';
								}
								?>
								<th style="text-align:center;"><?= lang("Amount"); ?></th>
							</tr>

							</thead>

							<tbody>

							<?php $r = 1;
								$tax_summary = array();

							for ($i = 0; $i < sizeof($rows); $i++):

								//if ($i < sizeof($rows)) {

									$free = lang('free');
									$product_unit = '';
									if($rows[$i]['variant']){
										$product_unit = $rows[$i]['variant'];
									}else{
										$product_unit = $rows[$i]['unit'];
									}
									
									$product_name_setting;
									if($pos->show_product_code == 0) {
										$product_name_setting = $rows[$i]['product_name'] . ($rows[$i]['variant'] ? ' (' . $rows[$i]['variant'] . ')' : '');
									}else{
										$product_name_setting = $rows[$i]['product_name'] . " (" . $rows[$i]['product_code'] . ")" . ($rows[$i]['variant'] ? ' (' . $rows[$i]['variant'] . ')' : '');
									}
									?>
										<tr>
											<td class="tborder" style="border-bottom: 1px solid #FFF !important;text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
											<td class="tborder" style="vertical-align:middle; border-bottom: 1px solid #FFF !important;">
												<?= $rows[$i]['product_code'] ?>
											</td>
											<td class="tborder" style="width: 80px; text-align:center; vertical-align:middle; border-bottom: 1px solid #FFF !important;">
												<?= $product_name_setting ?>
												<?= $rows[$i]['details'] ? '<br>' . $rows[$i]['details'] : ''; ?>
												<?= $rows[$i]['serial_no'] ? '<br>' . $rows[$i]['serial_no'] : ''; ?>
											</td>
											<td class="tborder" style="width: 80px; text-align:center; vertical-align:middle; border-bottom: 1px solid #FFF !important;"><?= $this->erp->formatQuantity($rows[$i]['quantity']); ?></td>
											<!-- <td style="text-align:right; width:100px;"><?= $this->erp->formatMoney($rows[$i]['net_unit_price']); ?></td> -->
											<td class="tborder" style="text-align:center; width:100px; border-bottom: 1px solid #FFF !important;"><?= $rows[$i]['subtotal'] !=0?$this->erp->formatMoney($rows[$i]['unit_price']):$free; ?></td>
											<?php
											/*if ($Settings->tax1) {
												echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($rows->item_tax != 0 && $rows->tax_code ? '<small>('.$rows->tax_code.')</small>' : '') . ' ' . $this->erp->formatMoney($rows->item_tax) . '</td>';
											}*/
											if ($Settings->product_discount && $inv->product_discount != 0) {
												echo '<td class="tborder" style="width: 100px; text-align:center; vertical-align:middle; border-bottom: 1px solid #FFF !important;">' . ($rows[$i]['discount'] != 0 ? '<small>(' . $rows[$i]['discount'] . ')</small> ' : '') . $this->erp->formatMoney($rows[$i]['item_discount']) . '</td>';
											}
											?>
											<td class="tborder" style="text-align:right; width:120px; border-bottom: 1px solid #FFF !important;"><?= $rows[$i]['subtotal']!=0?$this->erp->formatMoney($rows[$i]['subtotal']):$free; ?></td>
										</tr>
										<?php
										$r++;
								/*
								} else {
									if ($Settings->product_discount && $inv->product_discount != 0) {
										echo "
										<tr>
											<td class='tborder' style='height:31px; border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
										</tr>";
									}else{
										echo "
										<tr>
											<td class='tborder' style='height:31px; border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											
										</tr>";
									}
									
							}
							*/
						endfor;
						if($i < 8) {
							for($j = $i; $j < 8; $j++) {
								if($j == 7) {
									if ($Settings->product_discount && $inv->product_discount != 0) {
										echo "
										<tr>
											<td class='tborder' style='height:31px;'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
										</tr>";
									}else{
										echo "
										<tr>
											<td class='tborder' style='height:31px;'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											<td class='tborder'></td>
											
										</tr>";
									}
								}else {
									if ($Settings->product_discount && $inv->product_discount != 0) {
										echo "
										<tr>
											<td class='tborder' style='height:31px; border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
										</tr>";
									}else{
										echo "
										<tr>
											<td class='tborder' style='height:31px; border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											<td class='tborder' style='border-bottom: 1px solid #FFF !important;'></td>
											
										</tr>";
									}
								}
							}
						}
							?>
							</tbody>
							<tfoot>
							
							<?php
							
							$col = 4;
							$row = 3;
							if ($inv->order_discount != 0){
								$row = 5;
							}
							if ($inv->total_discount != 0){
								$col = 5;
							}
							/*
							if ($Settings->product_discount && $inv->product_discount != 0) {
								$col++;
							}
							
							if ($Settings->product_discount && $inv->product_discount != 0) {
								$tcol = $col - 1;
							} elseif ($Settings->product_discount && $inv->product_discount != 0) {
								$tcol = $col - 1;
							} else {
								$tcol = $col;
							}
							
							?>
							<?php if ($inv->grand_total != $inv->total) { ?>
								<tr>
									<td colspan="<?= $tcol; ?>" style="text-align:right; font-weight:bold; padding-right:10px; border-left: 1px solid #fff !important; border-bottom: 1px solid #fff !important;">
										<?= lang("Total"); ?>
									</td>
									
									<?php
									
									if ($Settings->product_discount && $inv->product_discount != 0) {
										echo '<td style="text-align:right; vertical-align:middle; border-top: 1px solid #000 !important;">' . $this->erp->formatMoney($inv->product_discount) . '</td>';
									}
									
									?>
									<td style="text-align:right; font-weight:bold; padding-right:10px; vertical-align:middle;"><?= $this->erp->formatMoney($inv->total); ?></td>
								</tr>
							<?php } ?>
							
							<?php if ($inv->order_discount != 0) {
								echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px; font-weight:bold; border-left: 1px solid #fff !important; border-bottom: 1px solid #fff !important;">' . lang("Discount") . '</td><td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:5px;">' . $this->erp->formatMoney($inv->order_discount) . '</td></tr>';
							}
							?>
							<?php if ($Settings->tax2 && $inv->order_tax != 0) {
								echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px; font-weight:bold;">' . lang("អាករលើតម្លៃបន្ថែម ".number_format($vattin->rate)."%/VAT(".number_format($vattin->rate)."%)") . '</td><td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:5px;">' . $this->erp->formatMoney($inv->order_tax) . '</td></tr>';
							}
							?>
							<?php if ($inv->shipping != 0) {
								echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;font-weight:bold;">' . lang("ការ​ដឹក​ជញ្ជូន/Shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoney($inv->shipping) . '</td></tr>';
							}
							*/
							?>
							
							
							<tr>
								<td colspan="<?=$col ?>"rowspan="<?=$row ?>" style="border-left: 1px solid #fff !important; border-right: 1px solid #fff !important; border-bottom: 1px solid #fff !important;">
									<p><strong>Note:</strong>&nbsp;All items cannot be returned in cash.</p>
								</td>
								<td
									style="text-align:right; font-weight:bold; border-bottom:1px solid #fff !important; border-left: 1px solid #fff !important;"><?= lang("Total"); ?>
								</td>
								<td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:5px;"><?= $this->erp->formatMoney($inv->total); ?></td>
								
								
							</tr>
							
							<?php if ($inv->order_discount != 0) {
								
								echo '<tr><td style="text-align:right; padding-right:10px; font-weight:bold; border-left: 1px solid #fff !important; border-bottom: 1px solid #fff !important;">' . lang("Discount") . '</td><td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:5px;">' . $this->erp->formatMoney($inv->order_discount) . '</td></tr>';
							}
							?>
							
							<?php if ($inv->order_discount != 0) {
								echo '<tr><td style="text-align:right; padding-right:10px; font-weight:bold; border-left: 1px solid #fff !important; border-bottom: 1px solid #fff !important;">' . lang("Grand_Total") . '</td><td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:5px;">' . $this->erp->formatMoney($inv->grand_total) . '</td></tr>';
							}
							?>
							
							
							
							<tr>
								<td 
									style="text-align:right; font-weight:bold; border-bottom:1px solid #fff !important; border-left: 1px solid #fff !important;"><?= lang("Paid"); ?>
								</td>
								<td style="text-align:right; font-weight:bold; padding-top:5px;"><?= $this->erp->formatMoney($inv->paid); ?></td>
							</tr>
							<tr>
								<td 
									style="text-align:right; font-weight:bold; border-bottom:1px solid #fff !important; border-left: 1px solid #fff !important;"><?= lang("Balance"); ?>
								</td>
								<td style="text-align:right; font-weight:bold; padding-top:5px;"><?= $this->erp->formatMoney($inv->grand_total - $inv->paid); ?></td>
							</tr>

							</tfoot>
						</table>
					</div>
				</td>
			</tr>
			
			<!--<tr>
				<td colspan="2">
					<table border="0" cellspacing="0">
						<tr>
							<td colspan="3" width="33%" valign="bottom" style="text-align:center;padding-top:70px;">
								<hr style="border:dotted 1px; width:160px; vertical-align:bottom !important;  margin-bottom:2px;" />
								<b style="font-size:10px;text-align:center;margin-left:3px;"><?= lang('​ហត្ថលេខា និង ឈ្មោះ​​អតិថិជន​  <br/> Customer`s Signature & Name'); ?></b>
							</td><td>&nbsp;</td><td>&nbsp;</td>
							<td colspan="3" width="33%" valign="bottom" style="text-align:center;padding-top:50px;">
								
							</td><td>&nbsp;</td><td>&nbsp;</td>
							<td colspan="3" width="33%" valign="bottom" style="text-align:center;padding-top:70px;">
								<hr style="border:dotted 1px; width:160px; vertical-align:bottom !important; margin-bottom:2px;" />
								<b style="font-size:10px;text-align:center;margin-left:3px;"><?= lang('​ហត្ថលេខា និង ឈ្មោះ​អ្នក​ទទួល​  <br/> Receiver`s Signature & Name'); ?></b>
							</td> 
						</tr>						
					</table>
					
					<div class="row" style="padding-top: 20px;">
						<div class="col-sm-2">
							<p style="font-size: 10px !important;">សូមអរគុណ<br>Thank you</p>
						</div>
					</div>
					
				</td>
			</tr>-->
		</table>
		<div class="row" style="padding-left: 16px; margin-top:20px; width: 90%">
			
				<div class="col-sm-3" style="line-height:0px;">
					<hr>
					Customer Sig'
				</div>
				
				<div class="col-sm-3" style="line-height:0px;">
					<hr>
					Delivery By
				</div>
				
				<div class="col-sm-3" style="line-height:0px;">
					<hr>
					Receiver`s
				</div>
				
				<div class="col-sm-3">
					<p style="padding-top: 30px;">Thanks</p>
				</div>
				
			</div>
		</div>
		<?php } ?>

		<!-- Print and Back To Add Sale Button -->
		<style>
			@media print {
			  #printReportYongWang, #backToAddSale {
			    display: none !important;
			  }
			}
		</style>

		<div style="text-align: left; margin-left: 45px;">
			<button onclick="printReport()" id="printReportYongWang" class="btn btn-success btn-xs" style="margin-top: 20px;">
				<strong>Print</strong>
			</button>
			<a href="<?=base_url()?>sales/add" id="backToAddSale">
				<button class="btn btn-danger btn-xs" style="margin-top: 20px;">
					<strong>Back To Add Sale</strong>
				</button>
			</a>
		</div>

		<script>
			function printReport() {
		    window.print();
			}

			document.getElementById('printReportYongWang').focus();
		</script>
		<!-- /Print and Back To Add Sale Button -->
	</div>
</center>