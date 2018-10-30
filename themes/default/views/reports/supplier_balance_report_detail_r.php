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
            },
            minLength: 1,
            autoFocus: false,
            delay: 300,
        });
    });
</script>
<style type="text/css">
    .numeric {
        text-align:right !important;
    }

</style>
<?php //if ($Owner || $Admin) {
    $sdate='';
    $edate='';
    $supp='';
    if(isset($_POST['start_date'])){
        $sdate=date("Y-d-m", strtotime($_POST['start_date']));
    }
    if(isset($_POST['end_date'])){
        $edate=date("Y-d-m", strtotime($_POST['end_date']));
    }
    if($edate=='1970-01-01'){
        $edate='';
    }
    if($sdate=='1970-01-01'){
        $sdate='';
    }
    if(isset($_POST['supplier'])){
        $supp=$_POST['supplier'];
    }
//echo $sdate.'---'.$edate;
   //echo $supp;
    echo form_open('reports/supplier_balance_report_r', 'id="action-form"');
    //}

?>
<style>
    #POData .active th,#POData .foot td{
            color: #fff;
            background-color: #428BCA;
            border-color: #357ebd;
    }

</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-star"></i><?=lang('Supplier_Balance_Report')  . '';?>
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
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?=lang("actions")?>"></i></a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                         <li>
                            <a href="javascript:void(0)" id="combine_payable" data-action="combine_payable">
                                <i class="fa fa-money"></i> <?=lang('combine_payable')?>
                            </a>
                        </li>
                        <?php if ($Owner || $Admin) { ?>
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
                        <?php }else{ ?>
                            <?php if($GP['accounts-export']) { ?>
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
                            <?php }?>
                        <?php }?>
                        <li>
                            <a href="#" id="combine" data-action="combine">
                                <i class="fa fa-file-pdf-o"></i> <?=lang('combine_to_pdf')?>
                            </a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <?php if (!empty($warehouses)) {?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?=lang("warehouses")?>"></i></a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?=site_url('purchases')?>"><i class="fa fa-building-o"></i> <?=lang('all_warehouses')?></a></li>
                            <li class="divider"></li>
                            <?php
                                foreach ($warehouses as $warehouse) {
                                        echo '<li ' . ($warehouse_id && $warehouse_id == $warehouse->id ? 'class="active"' : '') . '><a href="' . site_url('purchases/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                                    }
                                ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?=form_submit('performAction', 'performAction', 'id="action-form-submit"')?>
    </div>
    <?= form_close()?>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?=lang('list_results');?></p>
                <div id="form">

                    <?php echo form_open("reports/supplier_balance_report_detail_r"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="supplier"><?= lang("supplier"); ?></label>
                                <?php
                                $sup["0"] = lang('all');
                                foreach ($suppliera as $supplier) {
                                    $check          = $this->accounts_model->getTotalSupplierBalance($supplier->id);
                                    if($check[0]->amount>0){
                                        $sup[$supplier->id] =  $supplier->name .' ('. $supplier->company .')';
                                    }
                                }
                                echo form_dropdown('supplier', $sup, (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="supplier_id" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("supplier") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date" '); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date',(isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control datetime" id="end_date"'); ?>
                            </div>
                        </div>
                        <?php 
                            // $this->erp->print_arrays($suppliera);
                        ?>
                     <!--  <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="balance"><?= lang("balance"); ?></label>
                                <?php
                                    $wh["all"] = "All";
                                    $wh["balance0"] = "Zero Balance";
                                    $wh["owe"] = "Owe";

                                echo form_dropdown('balance', $wh, (isset($_POST['balance']) ? $_POST['balance'] : ''), 'class="form-control" id="balance" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("balance") . '"');
                                ?>
                            </div>
                        </div>-->

                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="POData" cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-bordered table-hover">

                            <tr class="active">
                                <th class="text-center"><?php echo $this->lang->line("type"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("date"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("reference"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("Project"); ?></th>

                                <th class="text-center"><?php echo $this->lang->line("Due Date"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("payment_term"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("Aging"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("amount"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("return"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("paid"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("deposit"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("discount"); ?></th>
                                <th class="text-center"><?php echo $this->lang->line("balance"); ?></th>

                            </tr>


                        <?php
                        $total_amount       = 0;
                        $total_return       = 0;
                        $total_paid         = 0;
                        $total_deposit      = 0;
                        $total_discount     = 0;

                        foreach($suppliers as $supplier)
                        {
                        $items          = $this->accounts_model->getApBySupplier_r($supplier->id,$sdate, $edate);
                        if($sdate)
                        {
                            $old_amount    = $this->accounts_model->getSuppilerOldAmount($supplier->id,$sdate, $edate);
                            $old_payment   = $this->accounts_model->getSuppilerOldPayment($supplier->id,$sdate, $edate);
                            $old_balance   = $old_amount[0]->amount-($old_payment[0]->paid+$old_payment[0]->discount);
                        }else{
                            $old_balance    = 0;
                        }

                        $sup_balance    = $old_balance;
                        $amount         = $start_date2?$old_balance:0;
                        $return         = 0;
                        $paid           = 0;
                        $deposit        = 0;
                        $discount       = 0;
                       $t_aging=0;
                        $check          = $this->accounts_model->getTotalSupplierBalance($supplier->id);
                        if($check[0]->amount>0){
                        ?>
                        <tr style="background: whitesmoke">
                            <th class="th_parent" colspan="12"><?= lang("supplier")?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?= $supplier->company ?></th>
                            <th class="numeric"><?= $this->erp->formatNumber($old_balance) ?></th>
                        </tr>

                        <?php
                        $i=0;
                        $ci=0;
                        //$this->erp->print_arrays($items);
                        foreach($items as $data)
                        {
                         $aging=0;
                        $amount      += $data->amount;
                        $return      += $data->return_amount;
                        $paid        += $data->paid;
                        $deposit     += $data->deposit;
                        $discount    += $data->discount;
                        $aging=$data->payment_term?abs($data->ddd):abs($data->dd);
                        //$t_aging+=$aging;
                        $sup_balance += $data->amount-($data->return_amount+$data->paid+$data->deposit);
                         $getBS='';
                         $p_term=[];
                         $project=[];
                         $due_date=[];
                        if($data->type=='Purchase'){
                            if($getBS=$this->db->query("select biller_id,created_by from erp_purchases where reference_no='".$data->reference_no."' ")->result()) {
                                foreach ($getBS as $gbs) {
                                        if($gbs->created_by){
//                                            echo $gbs->created_by;
                                            if($get_nbs=$this->db->query("select  concat(erp_users.first_name,' ',erp_users.last_name) as saleman from erp_users where id='".$gbs->created_by."' ")->result()){
                                                foreach($get_nbs as $nbs){
                                                    $saleman[$ci] = $nbs->saleman;
//                                                    echo  $saleman[$ci].'<br>';
                                                }
                                            }
                                        }
                                    if($gbs->biller_id){
                                        if($get_nbss=$this->db->query("select company from erp_companies where id='".$gbs->biller_id."' ")->result()){
                                            foreach($get_nbss as $nbss){
                                                $project[$ci] = $nbss->company;
//                                                echo  $project[$ci].'ss<br>';
                                            }
                                        }
                                    }

                                }
                            }
                            if($data->payment_term!=0){
                                if( $getBSp=$this->db->query("select erp_payment_term.description,erp_payment_term.due_day from erp_payment_term where erp_payment_term.id='".$data->payment_term."' ")->result()) {
                                    foreach ($getBSp as $gbsp) {

                                                    $p_term[$ci] = $gbsp->description;
                                            }
                                    }
                                }
                        }
                        if($data->type=='Payment'){
                            if( $getBS=$this->db->query("select biller_id,created_by from erp_payments where reference_no='".$data->reference_no."' ")->result()) {
                                foreach ($getBS as $gbs) {
                                    if($gbs->biller_id){
                                        if($get_nbss=$this->db->query("select company from erp_companies where id='".$gbs->biller_id."' ")->result()){
                                            foreach($get_nbss as $nbss){
                                                $project[$ci] = $nbss->company;
//                                                echo  $project[$ci].'ss<br>';
                                            }
                                        }
                                    }

                                }
                            }
                        }


                        $ci++;
                        //echo  $ci.'-'.$i.'<br>';
//                        $this->erp->print_arrays($project);
//echo $project[1];
                        ?>
                            <?php
                               if($sup_balance!=0){
                                if($data->type=='Purchase'){
                                   ?>
                                   <tr  class=''  style="cursor: pointer" id="row_click1" <?= $type  ?> >
                                       <td><?=$data->type?></td>
                                       <td><?=$this->erp->hrsd($data->date)?></td>
                                       <td><?=$data->reference_no?></td>
                                       <td><?=$project[$i] ?></td>

                                       <td><?=$data->payment_term?$this->erp->hrsd($data->due_date):$this->erp->hrsd($data->date)?></td>
                                       <td><?=$p_term[$i]?$p_term[$i]:'' ?></td>
                                       <td><?= $aging ?></td>
                                       <td class="text-right"><?= $data->amount>0?number_format($data->amount,2):''?></td>
                                       <td  class="text-right"><?= $data->return_amount>0?$this->erp->formatMoney($data->return_amount):''?></td>
                                       <td  class="text-right">
                                           <?=$data->paid!=0?$data->paid <0?$this->erp->formatNegativeMoney(abs($data->paid)):number_format(abs($data->paid),2):''?>
                                       </td>
                                       <td  class="text-rightz"><?= $data->deposit>0?number_format($data->deposit,2):''?></td>
                                       <td  class="text-right"><?= $data->discount>0?number_format($data->discount,2):''?></td>
                                       <td  class="text-right"><?=number_format($sup_balance,2)?></td>
                                   </tr>
                                   <?php
                                }
                               }
                            ?>





                                                <?php
                                                $i++;
                                                $total_sale                 += ($data->amount);
                                                $total_pay_amoun            += $data->paid;
                                                $total_discount             += $data->discount>0?$data->discount:0;
                                                $total_deposit              += $data->deposit>0?$data->deposit:0;
                                                $total_sale_show            += ($data->amount);
                                                $total_pay_amoun_show       += $data->paid;
                                                $total_return_amoun_show    += $data->return_amount;
                                                $total_discount_show        += $data->discount>0?$data->discount:0;
                                                $total_deposit_show         += $data->deposit>0?$data->deposit:0;

                                                $total_am = $total_sale-$total_pay_amoun-$total_return_amoun-$total_discount-$total_deposit+$total_old_return_payment;

                                            }
                                        ?>

                                    <tr class="bg-success">
                                        <td class="text-right" colspan="6"><b>Total</b></td>
                                        <td class="text-right"></td>
                                        <td class="text-right"><b><?=number_format($total_sale_show,2)?></b></td>
                                        <td class="text-right"><b><?=number_format($total_return_amoun_show,2)?></b></td>
                                        <td class="text-right"><b><?=number_format($total_pay_amoun_show,2)?></b></td>
                                        <td class="text-right"><b><?=number_format($total_deposit_show,2)?></b></td>
                                        <td class="text-right"><b><?=number_format($total_discount_show,2)?></td>
                                        <td class="text-right"><b><?= $total_am?($total_am>0?number_format(abs($total_am),2):number_format($total_am,2)):($old_balance>0?number_format(abs($old_balance),2):number_format($old_balance,2)) ?></b></td>
                                    </tr>
                            <?php
                                        $total_sale2            += $total_sale;
                                        $total_pay_amoun2       += $total_pay_amoun;
                                        $total_return_amoun2    += $total_return_amoun;
                                        $total_discount2        += $total_discount;
                                        $total_deposit2         += $total_deposit;
                                        $total_am2              += $total_am?$total_am:$old_balance;
                                    }

                            }
                            ?>

                            <tr class="foot1 warning">
                                <td class="text-right" colspan="7"><b>Grand Total</b></td>

                                <td class="text-right"><b><?=number_format($total_sale2,2)?></b></td>
                                <td class="text-right"><b><?=number_format($total_return_amoun2,2)?></b></td>
                                <td class="text-right"><b><?=number_format($total_pay_amoun2,2)?></b></td>
                                <td class="text-right"><b><?=number_format($total_deposit2,2)?></b></td>
                                <td class="text-right"><b><?=number_format($total_discount2,2)?></b></td>
                                <td class="text-right"><b><?= $total_am2?(($total_am2+$total_old_balance)<0?number_format(abs($total_am2),2):number_format($total_am2,2)):number_format($total_old_balance,2) ?></b></td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {

        $('.row_click').click(function () {

        //<a href="<?= site_url('reports/r_modal/' . $aa->sale_id) ?>" data-toggle="modal" data-target="#myModal2" class="tip btn btn-primary" title="View Invoice">

               // <span class="hidden-sm hidden-xs">View Invoice</span>
            //</a>
           //$('#myModal').modal({remote: '<?= site_url('reports/r_modal/' . $aa->sale_id) ?>?data=' + arrItems + ''});
           // $('#myModal').modal('show');
        });


        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    $(document).ready(function(){

        $("#excel").click(function(e){
            e.preventDefault();
            window.location.href = "<?=site_url('Account/arByCustomer/0/xls/'.$customer2.'/'.$start_date2.'/'.$end_date2.'/'.$balance2)?>";
            return false;
        });
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('Account/arByCustomer/pdf/?v=1'.$v)?>";
            return false;
        });

    });
</script>