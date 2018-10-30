<?php

    $ref='';
    $proj='';
    $salem='';
    $start_date='';
    $end_date='';
    if(isset($_POST['start_date'])){
        if($_POST['start_date']==''){
            $start_date='';
        }
        else{
            $d=strtr($_POST['start_date'], '/', '-');
            $start_date=date('Y/m/d', strtotime($d));
        }
    }
    if(isset($_POST['end_date'])){
        if($_POST['end_date']==''){
            $end_date='';
        }
        else {
            $d = strtr($_POST['end_date'], '/', '-');
            $end_date = date('Y/m/d', strtotime($d));
        }
    }
    if(isset($_POST['ref_no'])){
        $ref=$_POST['ref_no'];
    }
    if(isset($_POST['project'])){
        $proj=$_POST['project'];
    }
    if(isset($_POST['saleman'])){
        $salem=$_POST['saleman'];
}
// echo $_POST['customer'];
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
    echo form_open('account/arByCustomer_actions', 'id="action-form"');
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
                class="fa-fw fa fa-star"></i><?=lang('Customer_Balance_Detail') . '';?>
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

                    <?php echo form_open("account/customer_report_ar"); ?>
                    <div class="row">
                         <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("customer", "customer"); ?>
                                <?php echo form_input('customer', (isset($_POST['customer'])? $_POST['customer'] : ''), 'class="form-control" id="customer"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang(" start_date", "start_date"); ?>
                                <?php echo form_input('start_date', $start_date2?date("d/m/Y", strtotime($start_date2)):'', 'class="form-control date" id="start_date" '); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', $end_date2?date("d/m/Y", strtotime($end_date2)):'', 'class="form-control date" id="end_date"'); ?>
                            </div>
                        </div>
                        <!--<div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("reference_no", "reference_no"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="form-control" id="reference_no"'); ?>
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
                    <table id="POData" cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-bordered table-hover table-striped">
                        <tr class="active">
                            <th class="text-center"><?php echo $this->lang->line("type"); ?></th>
                            <th class="text-center"><?php echo $this->lang->line("date"); ?></th>
                            <th class="text-center"><?php echo $this->lang->line("reference"); ?></th>
                            <th class="text-center"><?php echo $this->lang->line("Project"); ?></th>
                            <th class="text-center"><?php echo $this->lang->line("saleman"); ?></th>
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
//                        $this->erp->print_arrays($customers);
                            $total_sale2            = 0;
                            $total_am2              = 0;
                            $total_pay_amoun2       = 0;
                            $total_return_amoun2    = 0;
                            $total_old_balance      = 0;
                            $total_discount2        = 0;
                            $total_deposit2         = 0;
                            $total_return           = 0;

                        foreach($customers as $cus){
                            if($cus->customer){

                                $invoices = $this->accounts_model->ar_by_invoice($cus->customer_id);
                                    $items = $this->accounts_model->getArByCustomer_ar($cus->customer_id, $start_date2, $end_date2,$ref,$proj);
                                    $old_sale = $this->accounts_model->getSaleOldBalance($cus->customer_id, $start_date2, $end_date2);
                                    $old_return = $this->accounts_model->getReturnSaleOldBalance($cus->customer_id, $start_date2, $end_date2);
                                    $old_payment = $this->accounts_model->getPaymentOldBalance($cus->customer_id, $start_date2, $end_date2);
                                    $old_deposit = $this->accounts_model->getDepositOldBalance($cus->customer_id, $start_date2, $end_date2);
                                    $total_discount = $start_date2 ? $old_payment[0]->discount : 0;

                                $total_paid_old=$old_return[0]->paid >0?$old_payment[0]->paid -($old_return[0]->paid-$old_deposit[0]->deposit):$old_payment[0]->paid;
                                $total_des_old=$old_return[0]->paid >0?$old_deposit[0]->deposit -($old_return[0]->paid-$old_payment[0]->paid):$old_deposit[0]->deposit;

                                $old_balance = $old_sale[0]->grand_total - $old_return[0]->return_grand_total - $total_paid_old - $old_payment[0]->discount  ;
                                $am = $start_date2 ? $old_balance : 0;
                                $total_old_balance += $old_balance;
                 // $this->erp->print_arrays($end_date);
                        ?>
                        <?php if($items){?>

                        <tr class="success">
                            <th class="th_parent" colspan="10"><?= lang("customer") ?> <i
                                        class="fa fa-angle-double-right" aria-hidden="true"></i> <?= $cus->customer ?>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                                    <th style="text-align: right"><?= $old_balance ?></th>


                        <?php
                        if(1){
                            $total_sale = $start_date2 ? $old_sale[0]->grand_total : 0;
                            $total_pay_amoun = $start_date2 ? $old_payment[0]->paid : 0;
                            $total_return_amoun = $start_date2 ? $old_return[0]->return_grand_total : 0;
                            $total_deposit = $start_date2 ? $old_deposit[0]->deposit : 0;
                            $total_old_return_payment = $start_date2 ? $old_return_payment->return_paid : 0;
                            $total_sale_show = 0;
                            $total_sale=0;
                            $total_pay_amoun_show = 0;
                            $total_return_amoun_show = 0;
                            $total_deposit_show = 0;
                            $total_discount_show = 0;
                            $total_am = 0;
                            $total_return_amoun=0;
                            $total_pay_amoun=0;
                            $total_deposit=0;
                            $total_discount=0;

                            //echo '$am='.$am.'<br>';
                        foreach($items as $sale ){

                         //$this->erp->print_arrays($items);
                            $am += ($sale->amount - $sale->paid - $sale->discount - $sale->return_amount - $sale->deposit);

                            $total_return_amoun += $sale->return_amount;
                        ?>
                        <?php
                            $spaid='';
                            $test=0;

                            //$am += ($sale->amount - ((-1$sale->paid) - $sale->discount - $sale->return_amount - $sale->deposit);
//                            if($am<=0){
//                                $am*=(-1);
//                                $spaid='(-1)';
//                            }
//                            else{
//                                $spaid='1';
//                            }
                               // echo '$am+=('.$sale->amount.'-('.$spaid.'*'.(-1) *$sale->paid.')-'.$sale->discount.'-'.$sale->return_amount.'-'.$sale->deposit.')='.$am.' , <br>';
                            ?>
                        <tr>
                            <td><?= $sale->type ?></td>
                            <td><?= $this->erp->hrsd($sale->date) ?></td>
                            <td><?= $sale->reference_no ?></td>
                            <td><?= $sale->biller ?></td>
                            <td><?= $sale->saleman ?></td>
                            <td><?= $sale->payment_term ? $this->erp->hrsd($sale->due_date) : $this->erp->hrsd($sale->date) ?></td>
                            <td><?= $sale->payment_term ? $sale->payment_term : '' ?></td>
                            <td><?= $sale->payment_term ? abs($sale->ddd) : abs($sale->dd) ?></td>
                            <td class="text-right"><?= $sale->amount > 0 ? number_format($sale->amount, 2) : '' ?></td>
                            <td class="text-right"><?= $sale->return_amount!=0 ? number_format($sale->return_amount, 2) : '' ?></td>
                            <td class="text-right">
                                <?= $sale->paid != 0 ? $sale->paid < 0 ? number_format(($sale->paid), 2) : number_format(($sale->paid), 2) : '' ?>
                            </td>
                            <td class="text-right"><?= $sale->deposit > 0 ? number_format($sale->deposit, 2) : '' ?></td>
                            <td class="text-right"><?= $sale->discount > 0 ? number_format($sale->discount, 2) : '' ?></td>
                            <td class="text-right"><?= (number_format($am, 2)) ?></td>
                        </tr>

                        <?php
                        $total_sale += ($sale->amount);
                        $total_pay_amoun += $sale->paid;
                        $total_discount += $sale->discount > 0 ? $sale->discount : 0;
                        $total_deposit += $sale->deposit > 0 ? $sale->deposit : 0;
                        $total_sale_show += ($sale->amount);
                        $total_pay_amoun_show += $sale->paid;
                        $total_return_amoun_show += $sale->return_amount;
                        $total_discount_show += $sale->discount > 0 ? $sale->discount : 0;
                        $total_deposit_show += $sale->deposit > 0 ? $sale->deposit : 0;

                        $total_am = $am;

                        ?>
                        <?php } ?>
                        <tr>
                            <td class="text-right" colspan="6"><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><b><?= number_format($total_sale_show, 2) ?></b></td>
                            <td class="text-right"><b><?= number_format($total_return_amoun_show, 2) ?></b></td>
                            <td class="text-right"><b><?= abs(number_format($total_pay_amoun_show, 2)) ?></b></td>
                            <td class="text-right"><b><?= number_format($total_deposit_show, 2) ?></b></td>
                            <td class="text-right"><b><?= number_format($total_discount_show, 2) ?></td>
                            <td class="text-right">
                                <b><?= $total_am ? ($total_am > 0 ? number_format(abs($total_am), 2) : number_format($total_am, 2)) : ($old_balance > 0 ? number_format(abs($old_balance), 2) : number_format($old_balance, 2)) ?></b>
                            </td>
                        </tr>
                        <?php
                        $total_sale2 += $total_sale;
                        $total_pay_amoun2 += $total_pay_amoun;
                        $total_return_amoun2 += $total_return_amoun;
                        $total_discount2 += $total_discount;
                        $total_deposit2 += $total_deposit;
                        $total_am2 += $total_am ? $total_am : $old_balance;
                        }
                        }
                        }
                            }
                            ?>

                            <tr class="foot">
                                <td class="text-right" colspan="6"><b>Grand Total</b></td>
                                <td></td><td></td>
                                <td class="text-right"><b><?=number_format($total_sale2,2)?></b></td>
                                <td class="text-right"><b><?=number_format($total_return_amoun2,2)?></b></td>
                                <td class="text-right"><b><?=abs(number_format($total_pay_amoun2,2))?></b></td>
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
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    $(document).ready(function(){

        $("#excel").click(function(e){
            e.preventDefault();
            window.location.href = "<?=site_url('Account/arByCustomer/0/xls/'.$customer2.'/'.$start_date.'/'.$end_date.'/'.$balance2)?>";
            return false;
        });
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('Account/arByCustomer/pdf/?v=1'.$v)?>";
            return false;
        });

    });
</script>