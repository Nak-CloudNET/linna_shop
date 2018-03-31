
<script>
    $(document).ready(function (e) {
		
		
        var oTable = $('#Loan_List').dataTable({
            "aaSorting": [[1, "asc"], [0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?=lang('all')?>"]],
            "iDisplayLength": 100,
            'bProcessing': true, 'bServerSide': true,
			'bFilter': false,
            'sAjaxSource': '<?=site_url('sales/list_loan_data/'.$sale_id)?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?=$this->security->get_csrf_token_name()?>",
                    "value": "<?=$this->security->get_csrf_hash()?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
				
                return nRow;
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, null, {"mRender": formatDecimal}, {"mRender": formatDecimal}, {"mRender": formatDecimal}, {"mRender": formatDecimal}, null, null, null, null],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
               
			   var interest = 0, principle = 0, payment = 0;
                for (var i = 0; i < aaData.length; i++) {
                    interest += parseFloat(aaData[aiDisplay[i]][2]);
                    principle += parseFloat(aaData[aiDisplay[i]][3]);
                    payment += parseFloat(aaData[aiDisplay[i]][4]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[2].innerHTML = currencyFormat(parseFloat(interest));
                nCells[3].innerHTML = currencyFormat(parseFloat(principle));
                nCells[4].innerHTML = currencyFormat(parseFloat(payment));
            },
			"fnInitComplete": function (oSettings, json) {
				alerts();
			}
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('Pmt No.');?>] ", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('balance');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
			{column_number: 9, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
        ], "footer");

    });
	
	function alerts(){
		$('.bb .checkbox').each(function(){		
			var parent = $(this).parent().parent().parent().parent();
			var help = parent.children("td:nth-child(10)").html();
			if(help != ''){
				parent.css('background-color', '#d7edeb !important');
				$(this).attr('disabled',true);
			}
		});
	}
	
</script>		
<div class="modal-dialog modal-lg no-modal-header" style="width:80% !important;">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <!--<button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>-->
            <?php if ($logo) { ?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                         alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
            <?php } ?>
            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-xs-5">
                    <p class="bold">
                        <?= lang("ref"); ?>: <?= $inv->reference_no; ?><br>
                        <?= lang("date"); ?>: <?= $this->erp->hrld($inv->date); ?><br>
                        <?= lang("sale_status"); ?>: <?= lang($inv->sale_status); ?><br>
                        <?= lang("payment_status"); ?>: <?= lang($inv->payment_status); ?><br>
						<?= lang("customer"); ?>: <?= lang($cust_info->company); ?><br>
						<?= lang("address"); ?>: <?= lang($cust_info->address).','.lang($cust_info->city).', '.lang($cust_info->state); ?><br>
						<?= lang("tel"); ?>: <?= lang($cust_info->phone); ?><br>
						<?= lang("email"); ?>: <?= lang($cust_info->email); ?>
                    </p>
                    </div>
                    <div class="col-xs-7 text-right">
						<!--
                        <?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 70, false); ?>
                        <img src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                             alt="<?= $inv->reference_no ?>"/>
							-->
                        <?php $this->erp->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
                        <img src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
                             alt="<?= $inv->reference_no ?>"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row" style="margin-bottom:15px;padding:0 15px;">
                <table class="table table-bordered table-hover table-striped print-table order-table">

                    <thead>
						<tr>
							<th width="5%"><?= lang("No"); ?></th>
							<th width="20%"><?= lang("item_code"); ?></th>
							<th width="35%"><?= lang("description"); ?></th>
							<th width="15%"><?= lang("unit_price"); ?></th>
							<th width="10%"><?= lang("quantity"); ?></th>
							<th width="15%"><?= lang("amount"); ?></th>
						</tr>
                    </thead>

                    <tbody>

                    <?php $n = 1;
                    $tax_summary = array();
					$total_amount = 0;
					$down_payment = 0;
					if($sale_info->other_cur_paid > 0){
						$cur_kh_2_us = ($sale_info->other_cur_paid / $sale_info->other_cur_paid_rate);
						$down_payment = $sale_info->paid + $cur_kh_2_us;
					}else{
						$down_payment = $sale_info->paid;
					}
                    foreach ($list_items as $item):
						$total_amount += ($item->quantity * $item->unit_price);
					?>
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $n; ?></td>
                            <td style="vertical-align:middle;"><?=$item->product_code?></td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?=$item->product_name?></td>
                            <td style="text-align:right; width:100px;"><?=$item->unit_price?></td>
                            <td style="text-align:right; width:120px;"><?=$item->quantity?></td>
							<td style="text-align:right; width:120px;"><?=number_format(($item->quantity * $item->unit_price),2)?></td>
                        </tr>
                    <?php
                        $n++;
                    endforeach;
					$loan_amount = $total_amount - $down_payment;
					if($total_amount > $balance){
                    ?>
						<tr>
							<td colspan="5" style="vertical-align:middle; text-align:right; font-weight:bold;"><?=lang("total_amount")?></td>
							<td style="vertical-alignA:middle; text-align:right; font-weight:bold;"><?=number_format($total_amount,2)?></td>
						</tr>
						<tr>
							<td colspan="5" style="vertical-align:middle; text-align:right; font-weight:bold;"><?=lang("down_payment")?></td>
							<td style="vertical-alignA:middle; text-align:right; font-weight:bold;"><?=number_format(($total_amount - $balance),2)?></td>
						</tr>
					<?php } ?>
						<tr>
							<td colspan="5" style="vertical-align:middle; text-align:right; font-weight:bold;"><?=lang("loan_amount")?></td>
							<td style="vertical-alignA:middle; text-align:right; font-weight:bold;"><?=number_format($balance,2)?></td>
						</tr>
						<tr>
							<td colspan="5" style="vertical-align:middle; text-align:right; font-weight:bold;"><?=lang("interest_rate_per_month")?></td>
							<!--<td style="vertical-alignA:middle; text-align:right; font-weight:bold;"><?=number_format(($loan_row->rated/12),2)?></td>-->
							<td style="vertical-alignA:middle; text-align:right; font-weight:bold;"><?=number_format(($current_interest->interest),2)?></td>
						</tr>
                    </tbody>
                    <tfoot>
					</tfoot>
            </div>

            <div class="table-responsive">
                <table id="Loan_List" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <!--<input class="checkbox checkft" type="checkbox" name="check"/>-->
                            </th>
                            <th><?php echo $this->lang->line("Pmt No."); ?></th>
                            <th><?php echo $this->lang->line("Interest"); ?></th>
                            <th><?php echo $this->lang->line("Principal"); ?></th>
                            <th><?php echo $this->lang->line("Total Payment"); ?></th>
                            <th><?php echo $this->lang->line("Balance"); ?></th>
                            <th><?php echo $this->lang->line("Payment Date"); ?></th>
                            <th><?php echo $this->lang->line("Note"); ?></th>
                            <th><?php echo $this->lang->line("Receive By"); ?></th>
                            <th><?php echo $this->lang->line("Paid Date"); ?></th>
                        </tr>
                        </thead>
                        <tbody class="bb">
                        <tr>
                            <td colspan="11"
                                class="dataTables_empty"><?php echo $this->lang->line("loading_data"); ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <!--<input class="checkbox checkft" type="checkbox" name="check"/>-->
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo $this->lang->line("note"); ?></th>
                            <th><?php echo $this->lang->line("create_by"); ?></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php
                        if ($inv->note || $inv->note != "") { ?>
                            <div class="well well-sm">
                                <p class="bold"><?= lang("note"); ?>:</p>
                                <div><?= $this->erp->decode_html($inv->note); ?></div>
                            </div>
                        <?php
                        }
                        if ($inv->staff_note || $inv->staff_note != "") { ?>
                            <div class="well well-sm staff_note">
                                <p class="bold"><?= lang("staff_note"); ?>:</p>
                                <div><?= $this->erp->decode_html($inv->staff_note); ?></div>
                            </div>
                        <?php } ?>
                </div>

                <div class="col-xs-5 pull-right">
                    <div class="well well-sm">
                        <p>
                            <?= lang("created_by"); ?>: <?= $created_by->first_name . ' ' . $created_by->last_name; ?> <br>
                            <?= lang("date"); ?>: <?= $this->erp->hrld($inv->date); ?>
                        </p>
                        <?php if ($inv->updated_by) { ?>
                        <p>
                            <?= lang("updated_by"); ?>: <?= $updated_by->first_name . ' ' . $updated_by->last_name;; ?><br>
                            <?= lang("update_at"); ?>: <?= $this->erp->hrld($inv->updated_at); ?>
                        </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (!$Supplier || !$Customer) { ?>
                <div class="buttons">
                    <div class="btn-group btn-group-justified">
						
						<!-- Add Payment -->
						<div class="btn-group">
                            <a href="#" data-toggle="modal" data-target="#myModal2" class="add_payment_list tip btn btn-primary pay" title="<?= lang('add_payment') ?>">
                                <i class="fa fa-money"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('add_payment') ?></span>
                            </a>
                        </div>
					
                        <div class="btn-group">
                            <a href="<?= site_url('sales/view/' . $inv->id) ?>" class="tip btn btn-primary" title="<?= lang('view') ?>">
                                <i class="fa fa-file-text-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('view') ?></span>
                            </a>
                        </div>
                        <?php if ($inv->attachment) { ?>
                            <div class="btn-group">
                                <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>" class="tip btn btn-primary" title="<?= lang('attachment') ?>">
                                    <i class="fa fa-chain"></i>
                                    <span class="hidden-sm hidden-xs"><?= lang('attachment') ?></span>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="btn-group">
                            <a href="<?= site_url('sales/email/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal2" class="tip btn btn-primary" title="<?= lang('email') ?>">
                                <i class="fa fa-envelope-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('email') ?></span>
                            </a>
                        </div>
	
                        <div class="btn-group">
                            <a href="<?= site_url('sales/pdf/' . $inv->id) ?>" class="tip btn btn-primary" title="<?= lang('download_pdf') ?>">
                                <i class="fa fa-download"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="tip btn btn-warning" title="<?= lang('print') ?>" onclick="window.print();">
                                <i class="fa fa-print"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('print') ?></span>
                            </a>
                        </div>
                        <!--<div class="btn-group">
                            <a href="#" class="tip btn btn-danger bpo" title="<b><?= $this->lang->line("delete_sale") ?></b>"
                                data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('sales/delete/' . $inv->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                                data-html="true" data-placement="top">
                                <i class="fa fa-trash-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                            </a>
                        </div>-->
                    </div>
                </div>
            <?php } ?>
			<div id="popup" ></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready( function() {
	
	$(".add_payment_list").bind('click',function(){
		//alert($(".bb .checkbox:checked").length); return false;
		var total_payment = 0;
		var id = '';
		var paid_amount = '';
		var principle = '';
		if($(".bb .checkbox:checked").length > 0){
			
			$(".bb .checkbox:checked").each(function(){	
				var parent = $(this).parent().parent().parent().parent();
				id += $(this).val() +'_';
				total_payment += parent.children("td:nth-child(5)").html()-0;
				paid_amount += parent.children("td:nth-child(5)").html() +'_';
				principle += parent.children("td:nth-child(4)").html() +'_';
			});
			
			$(this).attr('href', "<?= site_url('sales/add_payment_loan') ?>/"+total_payment+"/"+id+"/"+paid_amount+"/"+principle);
			
			/*
			var data1 = { check : check,total_payment:total_payment,payment:payment };
			$.ajax({
				url : '<?= site_url('sales/add_payment_loan'); ?>',
				dataType : 'json',
				type : 'get',
				data : data1,
				success:function(data){
					$("#popup").html(data);
				
				}				
			})
			 
			*/
		}else {
			
			alert("Please check..");
			return false;
		}
		
	});
	
});
</script>
