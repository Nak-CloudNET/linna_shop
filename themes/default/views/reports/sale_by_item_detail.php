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
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Sale_By_Item_Detail'); ?></h2>

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

                    <?php echo form_open("reports/sale_by_item_detail"); ?>
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

<!--                        <div class="col-sm-4">-->
<!--                            <div class="form-group">-->
<!--                                <label class="control-label" for="type">--><?//= lang("type"); ?><!--</label>-->
<!--                                <select name="type" id="" class="form-control">-->
<!--                                    <option value="0">All</option>-->
<!--                                    <option value="Invoice">Invoice</option>-->
<!--                                    <option value="Return">Return</option>-->
<!--                                </select>-->
<!---->
<!--                            </div>-->
<!---->
<!--                        </div>-->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="category"><?= lang("category"); ?></label>
                                <?php
                                $cate["0"] = lang('all');
                                foreach ($categories as $cat) {
                                    $cate[$cat->id] =  $cat->name;
                                }
                                echo form_dropdown('category', $cate, (isset($_POST['category']) ? $_POST['category'] : ""), 'class="form-control" id="category" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("category") . '"');
                                ?>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $ware["0"] = lang('all');
                                foreach ($warefull as $wh) {
                                    $ware[$wh->id] =  $wh->name;


                                }
                                echo form_dropdown('warehouse', $ware, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                ?>
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("customer"); ?></label>
                                <?php
                                $cus["0"] = lang('all');
                                foreach ($customers as $customer) {
                                    $cus[$customer->id] =  $customer->name;


                                }
                                echo form_dropdown('customers', $cus, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("customer") . '"');
                                ?>
                            </div>

                        </div>


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
                <div class="head-report">
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
                            <!-- get company name -->
                            <h3 class="com-name text-center" style="font-size: 22px;">
                                <?= $billers->company; ?>
                            </h3>     <!-- display company name from database -->
                            <h3 class="text-center" style="font-size: 25px">Collections Report</h3>
                            <p class="text-center">As of <?php echo date("F d, Y"); ?></p> <!--get date from local-->
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover"  >
                    <thead>
                    <tr>
                        <td>Type</td>
                        <td>Date</td>
                        <td>Num</td>
                        <td>Memo</td>
                        <td>Name</td>
                        <td>Project</td>
                        <td>Qty</td>
                        <td>Sales Price</td>
                        <td>Amount</td>
                        <td>Balance</td>
                    </tr>
                    </thead>

                    <tbody>
<?php

foreach ($products_code_w as $aa){
    if($aa->name){
    $products_code_c= $this->reports_model->getProductCodeByIdC($aa->warehouse_id);
    ?>
    <tr>
        <td colspan="10" class="text-left" style="font-weight:bold; font-size:19px !important; color:green;">
            <?= lang("warehouse"); ?>
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            &nbsp;&nbsp;<?=$aa->name?>
        </td>
    </tr>

              <?php
    $products = $this->site->getProducts();
    if ($this->input->post('products')) {
        $product_id = $this->input->post('products');
    }
    else {
        $product_id = NULL;
    }
    if ($this->input->post('reference_no')) {
        $reference_no = $this->input->post('reference_no');
    } else {
        $reference_no = NULL;
    }

                    $count=0;

        $procat = $this->reports_model->getProCatsD($aa->warehouse_id,$category2,$product2,$start,$end);

        foreach($procat as $rc) {
            $products_code= $this->reports_model->getProductCodeById($aa->warehouse_id,$rc->category_id,$customer_id,$product_id,$reference_no,$biller_id,$start,$end,$pro_code1);
            ?>
            <tr>
                <td colspan="9" style="color:orange;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                            style="font-size:13px;"><b>Category <i
                                    class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;<?= $rc->name; ?></b></span>
                </td>
            </tr>
            <?php

                    foreach ($products_code as $cu){

                        $count++;
                        ?>
                        <tr style=""><td colspan="10" style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $cu->product_code;?>>><?php echo $cu->name?></b></td></tr>
                        <?php
                        $w='';
                        if($wid){
                            $w=$wid;
                        }else{
                            $w=$aa->warehouse_id;
                        }

                        $product_detail = $this->reports_model->getProductDataAll($w,$cu->product_code,$customer_id, $reference_no, $biller_id,$start,$end,$pro_code1);

                        $total_qty = 0;
                        $total_price = 0;
                        $total_amt = 0;
                        $balance = 0;
                        $total_bal=0;
                        $re_uprice = 0;
                        $reference_no='';
                        $total_amt_s = 0;
                        foreach ($product_detail as $aa) {


                            if($aa->type=='Return'){
                                $total_qty +=(-1)*$aa->quantity;
                            }else{
                                $total_qty += $aa->quantity;
                            }
                            if($aa->type=='Return'){
                                $re_uprice=(-1)*$aa->unit_price;
                            }else{
                                $re_uprice=$aa->unit_price;
                            }
                            if($aa->type=='Return'){
                                $price = (-1)*($aa->unit_price *$aa->quantity);
                            }else{
                                $price = $aa->unit_price * $aa->quantity;
                            }
                            $total_price += $re_uprice;
                            $total_amt = $re_uprice * $aa->quantity;
                            $balance += $re_uprice *$aa->quantity;
                            $ref_no = str_replace('/', '_', $aa->reference_no);
                            $type='';
                            if($aa->type=='Invoice'){
                                $type=' href="'.site_url("reports/r_modal/". $aa->sale_id).'" data-toggle="modal" data-target="#myModal2" ';
                            }elseif($aa->type=='Return'){
                                $type=' href="'.site_url('sales/modal_return/' . $aa->sale_id) .'" data-toggle="modal" data-target="#myModal2"';
                            }
                            ?>

                                    <tr <?= $type ?> style="cursor: pointer">
                                        <td style="border-left: none"><?php echo $aa->type ;?></td>
                                        <td><?php echo $aa->dd ;?></td>
                                        <td><?php echo $aa->reference_no ;?></td>
                                        <td><?php echo $aa->description ;?></td>
                                        <td><?php echo $aa->customer;  ;?></td>
                                        <td><?php echo ($aa->biller ) ;?></td>
                                        <td style="text-align: right"> <?php echo round($aa->quantity,2) ;?>(<span style="color:#008000;"><?= $aa->name ?></span>)</td>
                                        <td style="text-align: right">
                                            <?php
                                            if($re_uprice<0){
                                                echo '('.number_format($re_uprice*(-1),2).')';
                                            }else{
                                                echo number_format($re_uprice,2);
                                            } ?>&nbsp;</td>
                                        <td style="text-align: right">
                                            <?php
                                            if($total_amt<0){
                                                echo '('.number_format($total_amt,2).')';
                                            }else{
                                                echo number_format($total_amt,2);
                                            } ?>&nbsp;</td>
                                        <?php $total_amt_s +=$total_amt; ?>
                                        <!--<td style="text-align: right"><?php echo '('.number_format($total_amt ,2).')'; //$total_amt_s +=$total_amt ?>&nbsp;</td>-->
                                        <td style="text-align: right"><?php echo number_format($balance,2)  ;$total_bal+=$balance;?></td>

                                    </tr>

                                    <?php }
                                    $total_qty_footer += $total_qty;
                                    $total_price_footer += $total_price;
                                    $total_amt_footer += $total_amt_s;
                                    $total_balance_footer += $total_bal;


                                ?>
                                <tr class="total-item">
                                    <td colspan="6"> <b>Total</b></td>
                                    <td class="line_op">&nbsp;<?php echo $total_qty; ?></td>
                                    <td class="line_op">&nbsp;<?php echo number_format($total_price,2); ?> </td>
                                    <td class="line_op">&nbsp;<?php echo number_format($total_amt_s,2); ?> </td>
                                    <td class="line_op"><?php echo number_format($total_bal,2); ?>&nbsp;</td>


                                </tr>
                                    <?php }}}}?>
                                <?php
                                    if($total_bal!= ""){
                                        ?>

                                        <tr class="total-item2">
                                        <td colspan="6"><b>Grand Total</b></td>
                                        <td class="line_op1 lp"><?php echo $total_qty_footer; ?></td>
                                        <td class="line_op1 lp"><?php echo number_format($total_price_footer,2); ?></td>
                                        <td class="line_op1 lp"><?php echo number_format($total_amt_footer,2); ?></td>
                                        <td class="line_op1 lp"><?php echo number_format($total_balance_footer,2); ?></td>
                                        </tr>
                                  <?php } ?>



                                </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</body>
</html>