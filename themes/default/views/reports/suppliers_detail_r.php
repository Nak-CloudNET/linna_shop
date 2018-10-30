<?php
if ($this->input->post('supplier')) {
    $supplierId = $this->input->post('supplier');
} else {
    $supplierId = NULL;
}
if ($this->input->post('products')) {
    $product_id = $this->input->post('products');
}
else {
    $product_id = NULL;
}
$this->data['product_id'] = $pro_id;
if($this->input->get('p_c')){
    $p_code = $this->input->get('p_c');
}
//        $this->erp->print_arrays($supplierId);
if ($this->input->post('reference_no')) {
    $reference_no = str_replace(' ','',$this->input->post('reference_no'));
} else {
    $reference_no = NULL;
}



if ($this->input->post('start_date')) {

    $start_date =$this->input->post('start_date');
    $start = $this->erp->fld($start_date);
} else {
    $start_date = NULL;
}



if ($this->input->post('end_date')) {
    $end_date = $this->input->post('end_date');
    $end = $this->erp->fld($end_date);
} else {
    $end_date = NULL;
}


if ($this->input->post('biller')) {
    $biller_id = $this->input->post('biller');
} else {
    $biller_id = NULL;
}


?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
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
            };
        $('#customer').val(<?= $this->input->post('customer') ?>);
    })


        <?php } ?>

        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
</script>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suppliers Report Detail</title>

    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">


    <style>

        .header tr{
            width: 100%;
            text-align: center;

        }

        .line_op{
            position: relative;
            text-align: right;
            font-weight: bold;
        }
        .line_op:after{
            position: absolute;
            content: '';
            width: 80%;
            border-top: 1px solid black ;
            top: 0px;
            right: 0px;
        }
        .lp{
            position: relative;
            text-align: right;
            font-weight: bold;
        }
        .lp:after{
            position: absolute;
            content: '';
            width: 80%;
            /*border-bottom: 3px double black ;*/
            /*buttom: -150px;*/
            border-bottom-style: double;
            right: 0px;
            height: 90%;
            /*background: red;*/
        }
        .lp:before{
            position: absolute;
            content: '';
            width: 80%;
            border-bottom: 1px solid black ;
            top:0%;
            right: 0px;
        }
        @media print {
            .print-date-time {
                display: block !important;
            }
        }

    </style>
</head>
<body>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Purchase_Item_Detail'); ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                                class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                                class="icon fa fa-toggle-down"></i></a></li>
                <?php if ($Owner || $Admin || $GP['sales-export']) { ?>
                    <li class="dropdown"><a href="#" id="pdf" data-action="export_pdf"  class="tip" title="<?= lang('download_pdf') ?>"><i
                                    class="icon fa fa-file-pdf-o"></i></a></li>
                    <li class="dropdown"><a href="#" id="excel" data-action="export_excel"  class="tip" title="<?= lang('download_xls') ?>"><i
                                    class="icon fa fa-file-excel-o"></i></a></li>
                    <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                                    class="icon fa fa-file-picture-o"></i></a></li>
                <?php } ?>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="tip" id="print" title="<?= lang('print')?>" onclick="window.print()">
                        <i class="icon fa fa-print"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>
                <div id="form">

                    <?php echo form_open("reports/suppliers_detail_r"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="supplier"><?= lang("supplier"); ?></label>

                                <?php
                                //                                $this->erp->print_arrays($getAllSupplier);
                                $supplierA[0] = $this->lang->line("all");
                                foreach ($getAllSupplier as $supplierB) {
                                    $supplierA[$supplierB->supplier_id] = $supplierB->supplier ;
                                    // $pr1[$product->id]=$product->code;
                                }
                                echo form_dropdown('supplier', $supplierA, (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="product" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("product") . '"');

                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="product_id"><?= lang("product"); ?></label>
                                <?php
                                $p_c='';
                                $pr[0] = $this->lang->line("all");;
                                foreach ($products as $product) {
                                    $pr[$product->id] = $product->name . " | " .$p_c= $product->code ;
                                    // $pr1[$product->id]=$product->code;
                                }
                                echo form_dropdown('products', $pr, (isset($_POST['product']) ? $_POST['product'] : ""), 'class="form-control" id="product" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("product") . '"');

                                ?>
                            </div>
                        </div>
                        <!--<div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("supplier", "supplier"); ?>
                                <?php echo form_input('supplier', (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="supplier"'); ?> </div>
                        </div>-->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="reference_no"><?= lang("reference_no"); ?></label>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="form-control tip" id="reference_no"'); ?>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                <?php
                                $bl["0"] = lang('all');
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>
                        <?php if($this->Settings->product_serial) { ?>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang('serial_no', 'serial'); ?>
                                    <?= form_input('serial', '', 'class="form-control tip" id="serial"'); ?>
                                </div>
                            </div>
                        <?php } ?>
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
                                class="controls"> <?php echo form_submit('submit_sale_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>

            <br>
            <?php
            //                $this->erp->print_arrays($product_detail);
            ?>
            <div class="report-header">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="print-date-time" style="display: none">
                            <br>
                            <br>
                            <span><?php echo date("F d, Y"); ?></span><br>
                            <span><?php echo date("h:i a"); ?></span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <h3 class="text-center" style="font-size: 22px">
                            <?= $billers->company; ?>
                        </h3>
                        <h3 class="text-center" style="font-size: 25px">Collection reports</h3>
                        <p class="text-center">
                            <b>
                                <?php
                                if($start1 != NULL){
                                    echo $start1;
                                }else{
                                    echo date("F d, Y");
                                }
                                ?>
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover"  >
                <thead>
                <tr>
                    <td>Type</td>
                    <td>Date</td>
                    <td>Reference</td>
                    <td>Project</td>
                    <td>Description</td>

                    <!--<td>Name</td>-->
                    <td>Source Name</td>
                    <td>Qty</td>
                    <td>Price</td>
                    <td>Amount</td>
                    <td>Balance</td>
                </tr>
                </thead>
                <tbody>
                <?php

                //                $this->erp->print_arrays($purchase_id);
                $total_qty_footer = 0;
                $total_amt_footer =0 ;
                $count=0;
                $unit=[];
                $cate=[];
                $wh=[];
                if($getWH=$this->db->query("select erp_warehouses.name,erp_purchase_items.warehouse_id from erp_warehouses inner join erp_purchase_items on erp_purchase_items.warehouse_id=erp_warehouses.id  group by erp_warehouses.id")->result()){
                    foreach ($getWH as $gwh) {
                        echo '<tr>
                                                <td colspan="11" class="text-left" style="font-weight:bold; font-size:19px !important; color:green;">
                                                     '.lang("warehouse").'
                                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                                    &nbsp;&nbsp;'.$gwh->name.'
                                                </td>
                                            </tr>';

                        //$this->erp->print_arrays($getWH->warehouse_id);
                        if($getCate=$this->db->query("select erp_products.category_id from erp_products inner join erp_purchase_items on erp_purchase_items.product_id=erp_products.id where erp_purchase_items.warehouse_id=".$gwh->warehouse_id." group  by  erp_products.category_id")->result()){
                            foreach ($getCate as $gc){
                                if($getCateName=$this->db->query("select erp_categories.name from erp_categories where erp_categories.id=$gc->category_id")->result()){
                                    foreach ($getCateName as $gcn){
                                        echo '<tr>
                                                <td colspan="10" style="color:orange;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                            style="font-size:13px;"><b>Category <i
                                                                    class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;'. $gcn->name.'</b></span>
                                                </td>
                                            </tr>';
                                        $purchase_id= $this->reports_model->getSuppliersByID($product_id,$reference_no,$biller_id,$start,$end,$p_code,$gwh->warehouse_id,$gc->category_id);
                                        foreach ($purchase_id as $cu){
                                            $count++;
                                            if($getUnit=$this->db->query(" select erp_units.name from erp_units where id=$cu->unit " )->result()){
                                                foreach ($getUnit as $gu){
                                                    $unit[$count]=$gu->name;
                                                }
                                            }
                                            $st_gu='';
                                            //echo $cu->warehouse_id.',';
                                            if( $unit[$count]!=''){
                                                $st_gu=$unit[$count];
                                            }

//                    $this->erp->print_arrays($getUnit);

                                            ?>


                                            <?php

                                            $product_detail = $this->reports_model->getPurchaseDataAll_r($cu->product_code, $reference_no1,$start,$end,$biller_id, $gwh->warehouse_id,$gc->category_id);
                                            if($product_detail){
                                                ?>
                                                <tr style=""><td colspan="11" style=""><b><?php echo $cu->product_code.'>>'.$cu->name;?></b></td></tr>
                                                <?php
                                                $total_qty = 0;
                                                $total_price = 0;
                                                $total_amt = 0;
                                                $balance = 0;
                                                //$this->erp->print_arrays($product_detail);
                                                foreach ($product_detail as $aa) {
                                                    $total_qty += $aa->quantity;
                                                    $total_price += $aa->unit_cost;
                                                    $total_amt += $aa->unit_cost *$aa->quantity;
                                                    $balance += $aa->unit_cost *$aa->quantity+$aa->item_tax-$aa->item_discount;
                                                    $price = $aa->unit_cost *$aa->quantity+$aa->item_tax-$aa->item_discount;
                                                    ?>

                                                    <tr href="<?= site_url('purchases/modal_view/' . $aa->pu_id) ?>" data-toggle="modal" data-target="#myModal2" style="cursor: pointer">
                                                        <td style="border-left: none"><?php echo $aa->type ;?></td>
                                                        <td><?php echo date("d/m/Y", strtotime($aa->date)); ?></td>
                                                        <td><?php echo $aa->reference_no ;?></td>
                                                        <td><?php echo $aa->company;  ?></td>
                                                        <td><?php echo $aa->note ;?></td>
                                                        <!-- <td><?php echo $aa->company;  ?></td>-->
                                                        <td><?php echo ($aa->company ) ;?></td>
                                                        <td style="text-align: right"> <?php echo ($aa->quantity<0? '('. abs(round($aa->quantity,2)).')':round($aa->quantity,2)) .'<br>('.($aa->quantity<0? '('. abs(round($aa->quantity,2)).')':round($aa->quantity,2)).'<span style="color:green"> '.$st_gu.'</span>)';  ?></td>
                                                        <td style="text-align: right"><?php echo number_format($aa->unit_cost,2) ;?>&nbsp;</td>
                                                        <td style="text-align: right"><?php echo number_format($price,2) ;?></td>
                                                        <td style="text-align: right"><?php echo number_format($balance,2)  ;?></td>
                                                    </tr>

                                                <?php }
                                                $total_qty_footer += $total_qty;
                                                $total_price_footer += $total_price;
                                                $total_amt_footer += $total_amt;

                                                ?>
                                                <tr class="total-item">
                                                    <td colspan="6"> <b>Total</b></td>
                                                    <td class="line_op">&nbsp;<?php echo $total_qty; ?></td>
                                                    <td class="line_op">&nbsp;<?php echo number_format($total_price,2); ?> </td>
                                                    <td class="line_op">&nbsp;<?php echo number_format($total_amt,2); ?> </td>
                                                    <td class="line_op"><?php echo number_format($total_amt,2); ?>&nbsp;</td>
                                                </tr>
                                            <?php } }
                                    }
                                }
                            }

                        }
                    }

                }
                //$this->erp->print_arrays($getCate);
                ?>

                <?php
                if($count>1){
                    ?>

                    <tr class="total-item2">
                        <td colspan="6"><b>Grand Total</b></td>
                        <td class="line_op1 lp"><?php echo $total_qty_footer; ?></td>
                        <td class="line_op1 lp"><?php echo number_format($total_price_footer,2); ?></td>
                        <td class="line_op1 lp"><?php echo number_format($total_amt_footer,2); ?></td>
                        <td class="line_op1 lp"><?php echo number_format($total_amt_footer,2); ?></td>
                    </tr>
                <?php  } ?>



                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</body>
</html>