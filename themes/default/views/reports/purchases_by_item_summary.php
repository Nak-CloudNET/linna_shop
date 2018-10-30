<?php

$v = "";
if ($this->input->post('product')) {
    $v .= "&product=" . $this->input->post('product');
}
if ($this->input->post('reference_no')) {
    $v .= "&reference_no=" . $this->input->post('reference_no');
}
if ($this->input->post('customer')) {
    $v .= "&customer=" . $this->input->post('customer');
}
if ($this->input->post('biller')) {
    $v .= "&biller=" . $this->input->post('biller');
}
if ($this->input->post('supplier')) {
    $v .= "&supplier=" . $this->input->post('supplier');
}
if ($this->input->post('warehouse')) {
    $v .= "&warehouse=" . $this->input->post('warehouse');
}
if ($this->input->post('user')) {
    $v .= "&user=" . $this->input->post('user');
}
if ($this->input->post('serial')) {
    $v .= "&serial=" . $this->input->post('serial');
}

if (isset($biller_id)) {
    $v .= "&biller_id=" . $biller_id;
}
$pro_code1='';
if($_GET['p_c']){
    $pro_code1=$_GET['p_c'];
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
    <title>Sale by item Detail</title>

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

    </style>
</head>
<body>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Purchases_By_Item_Summary'); ?></h2>

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
            </ul>
        </div>
    </div>
        <div class="box-content">
            <div class="row">
                <div class="col-lg-12">
                    <p class="introtext"><?= lang('list_results'); ?></p>
                    <div id="form">

                    <?php echo form_open("reports/purchases_by_item_summary"); ?>
                    <div class="row">
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
                    </div>10
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
                <table class="table table-bordered table-striped table-hover"  >
                    <thead>
                    <tr>
                        <td></td>

                        <td>Quantity</td>
                        <td>Amount</td>
                        <td>Action</td>

                    </tr>
                    </thead>

                    <tbody>

                    <tr><td colspan="11">Inventory</td></tr>
                    <?php

                    //$this->erp->print_arrays($biller_id);
                    $total_qty_footer = 0;
                    $total_amt_footer =0 ;
                    $count=0;
                    foreach ($products_code as $cu){
                        $count++;
                        ?>
                        <?php

                        $product_detail = $this->reports_model->getPurchaseSummaryDataAll($cu->product_code,$customer_id, $reference_no, $biller_id,$start,$end,$pro_code1);

                        $total_qty = 0;
                        $total_price = 0;
                        $total_amt = 0;
                        $balance = 0;

                        foreach ($product_detail as $aa) {
                            $total_qty += $aa->quantity;
                            $total_price += $aa->unit_cost;
                            $total_amt += $aa->unit_cost *$aa->quantity;
                            $balance += $aa->unit_cost *$aa->quantity;
                            $price = $aa->unit_cost *$aa->quantity;
                            ?>
                                    <tr >
                                        <td style="border-left: none" class="bold"><?php echo $aa->product_code ;?></td>
                                        <td style="text-align: right"> <?php echo ($aa->quantity<0? '('. abs(round($aa->quantity,2)).')':round($aa->quantity,2)) ;?></td>
                                        <td style="text-align: right"><?php echo number_format($price,2) ;?></td>
                                        <td style=" padding: 1px !important;"  class="text-center" >
                                            <a href="reports/purchases_by_item_detail?p_c=<?php echo $aa->product_code; ?>" class="tip btn btn-primary" style="padding: 2px 10px" title="View Detail">

                                                <span class="hidden-sm hidden-xs">View Detail</span>
                                            </a>
                                            </td>
                                    </tr>
                                    <?php }
                                    $total_qty_footer += $total_qty;
                                    $total_price_footer += $total_price;
                                    $total_amt_footer += $total_amt;
                                ?>
                                <!--<tr class="total-item">
                                    <td colspan="1"> <b>Total</b></td>
                                    <td class="line_op">&nbsp;<?php echo $total_qty; ?></td>
                                    <td class="line_op">&nbsp;<?php echo number_format($total_amt,2); ?> </td>
                                    <td></td>
                                </tr>-->
                                    <?php }?>
                                <?php
                                    if($count>1){
                                        ?>
                                        <tr class="total-item2">
                                        <td colspan="1"><b>Grand Total</b></td>
                                        <td class="line_op1 lp"><?php echo $total_qty_footer; ?></td>
                                        <td class="line_op1 lp"><?php echo number_format($total_amt_footer,2); ?></td>


                                        <td></td>
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