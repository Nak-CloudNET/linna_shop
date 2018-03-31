<?php
	$v = "";
	/* if($this->input->post('name')){
	  $v .= "&product=".$this->input->post('product');
	  } */
	
	if ($this->input->post('start_date')) {
		$v .= "&start_date=" . $this->input->post('start_date');
	}
	if ($this->input->post('end_date')) {
		$v .= "&end_date=" . $this->input->post('end_date');
	}
	if(isset($date)){
		$v .= "&d=" . $date;
	}

?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
        $("#product").autocomplete({
            source: '<?= site_url('reports/suggestions'); ?>',
            select: function (event, ui) {
                $('#product_id').val(ui.item.id);
                //$(this).val(ui.item.label);
            },
            minLength: 1,
            autoFocus: false,
            delay: 300,
        });
    });
</script>
<?php if ($Owner) {
	    echo form_open('reports/saleman_actions', 'id="action-form"');
	}
?>

<div class="box">
    <div class="box-header">
        <h2 class="blue">
			<i class="fa-fw fa fa-heart"></i><?=lang('sales'); //lang('sales') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')';?>
			<?php 
				if ($this->input->post('start_date')) {
					echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
				}
			?>
        </h2>
		<div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?=lang("actions")?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fa fa-file-excel-o"></i> <?=lang('export_to_excel')?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="pdf" data-action="export_pdf">
                                <i class="fa fa-file-pdf-o"></i> <?=lang('export_to_pdf')?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="combine" data-action="combine">
                                <i class="fa fa-file-pdf-o"></i> <?=lang('combine_to_pdf')?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="bpo"
                            title="<b><?=$this->lang->line("delete_sales")?></b>"
                            data-content="<p><?=lang('r_u_sure')?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?=lang('i_m_sure')?></a> <button class='btn bpo-close'><?=lang('no')?></button>"
                            data-html="true" data-placement="left">
                            <i class="fa fa-trash-o"></i> <?=lang('delete_sales')?>
                        </a>
                    </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </div>
<?php if ($Owner) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php } ?>
	<div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?=lang('list_results');?></p>
				<div id="form">

                    <?php echo form_open("reports/saleman"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                <?php
                                $bl[""] = "";
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control datetime" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control datetime" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="SLData" class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
							<tr>
								<th style="width: 3% !important; text-align: center;">
									<input class="checkbox checkth input-xs" type="checkbox" name="check"/>
								</th>
								<th><?php echo $this->lang->line("sale_code"); ?></th>
								<th><?php echo $this->lang->line("saleman_name"); ?></th>
								<th><?php echo $this->lang->line("phone_number"); ?></th>
								<th><?php echo $this->lang->line("amount"); ?></th>
								<th><?php echo $this->lang->line("paid"); ?></th>
								<th><?php echo $this->lang->line("balance"); ?></th>
							</tr>
                        </thead>
                        <tbody>
                        <?php
						if ($this->input->POST('biller')) {
							$biller = $this->input->POST('biller');
						} else {
							$biller = NULL;
						}
						
						if ($this->input->POST('start_date')) {
							$start_date = $this->input->POST('start_date');
						} else {
							$start_date = NULL;
						}
						if ($this->input->POST('end_date')) {
							$end_date = $this->input->POST('end_date');
						} else {
							$end_date = NULL;
						}
						
						if ($start_date) {
							$start_date = $this->erp->fld($start_date);
							$end_date = $this->erp->fld($end_date);
						}
						
						$wheres = "";
						/*if ($start_date && $start_date != "0000-00-00 00:00:00") {
							$wheres = " and s.date > '$start_date' ";
						}
						if ($end_date && $end_date != "0000-00-00 00:00:00") {
							$wheres = ($wheres != "" ? $wheres . " and s.date < '$end_date' " : $wheres);
						}
						if($biller && $biller != ""){
							$wheres = ($wheres != "" ? $wheres . " and s.biller_id = '$biller' " : $wheres);
						}*/
						
						$sdv = $this->db;
                        $sdv->select("username, phone, id")->from('users u');
						$query = $sdv->get()->result();
						$i = 1;
						$tAmount 	= 0;
						$tPaid		= 0;
						$tbalance	= 0;
						foreach ($query as $rows) {
							$sale = $this->db->select('sum(total) as sale_amount, sum(paid) as sale_paid')
						     	->from('sales')
							    ->where('saleman_by = ' . $rows->id);
							if($biller){
								$this->db->where('biller_id',$biller);
							}
							if($start_date){
							    $this->db->where('date BETWEEN "'.$start_date.'" AND "'.$end_date.'" ');
							}           
                            $sales = $sale->get()->result();							
							$samount 	= 0;
							$spaid		= 0;

							foreach($sales as $rw)
							{
								$samount 	= $rw->sale_amount;
								$spaid		= $rw->sale_paid;
							}
						   ?>
							<tr class="active">
								<td style="width: 3% !important; text-align: center;">
									<input class="checkbox multi-select input-xs" type="checkbox" name="val[]" value="<?= $rows->id?>" />
								</td>
								<td><?=$rows->username?></td>
								<td><?=$rows->username?></td>
								<td><?=$rows->phone?></td>
								<td><?=$samount?></td>
								<td><?=$spaid?></td>
								<td><?=$samount - $spaid?></td>
							</tr>
						   <?php
							$tAmount	+= $samount;
							$tPaid		+= $spaid;
							$tbalance	+= ($samount - $spaid);
						}
						?>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="width: 3% !important; text-align: center;">
                                <input class="checkbox checkft input-xs" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang('sale_code')?></th>
                            <th><?= lang('sale_name')?></th>
                            <th><?= lang('phone_number')?></th>
                            <th><?=$tAmount?></th>
                            <th><?=$tPaid?></th>
                            <th><?=$tbalance?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>