

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
        .table tbody td{
            /*border: 1px solid #a4b0be;*/
            /*padding: 0px 0px 0px 10px !important;*/
            /*padding-left: 5px;*/
        }

        .header tr{
            width: 100%;
            text-align: center;

        }
        .btn1{
            color: #0e90d2;
        }

        .line_op{
            position: relative;
            text-align: right;
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
            /*height: 0%;*/
        }
        .btn{
            padding: 2px 20px;
        }
        @media print  {
            .print-date-time {
                display: block !important;
            }
            thead tr td:last-child,
            tr td:last-child{
                display: none;
            }
        }
    </style>
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

</head>
<body>

    <div class="box">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('Sale_By_Item_Summary'); ?></h2>
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

                        <?php echo form_open("reports/sale_by_item_summary"); ?>
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

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang("category", "category") ?>
                                    <?php
                                    $categ[''] = "ALL";
                                    foreach ($categories as $category) {
                                        //
                                        $categ[$category->id] = $category->name;

                                    }
                                    echo form_dropdown('category', $categ, (isset($_POST['category']) ? $_POST['category'] : $category2), 'class="form-control select" id="" placeholder="' . lang("select") . " " . lang("category") . '" style="width:100%"')
                                    ?>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                    <?php
                                    $wh["0"] = lang('all');
                                    foreach ($warefull as $warehouse) {
                                        $wh[$warehouse->id] =  $warehouse->name;


                                    }
                                    echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                    ?>
                                </div>
                            </div>

                            <!--
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="reference_no"><?= lang("reference_no"); ?></label>
                                    <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="form-control tip" id="reference_no"'); ?>

                                </div>
                            </div>
                            -->
                            <!--
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
                            -->
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
    <table class="table table-bordered table-striped table-hover" >
        <thead>
        <tr>

            <td>Product Code</td>
            <td>Qty</td>
            <td>Amount</td>
            <td>Action</td>

        </tr>
        </thead>
        <?php
        $total_amt=0;
        $gtotal_amt=0;
        foreach ($products_code_w as $aa){

            ?>
        <tr>
            <td colspan="11" class="text-left" style="font-weight:bold; font-size:19px !important; color:green;">
                <?= lang("warehouse"); ?>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                &nbsp;&nbsp;<?=$aa->name?>
            </td>
        </tr>
            <?php
            $category = $this->reports_model->getCatId($aa->warehouse_id,$cate);
            $total_cat=0;
            $gtotal_cat=0;
            foreach($category as $cat){
                //$this->erp->print_arrays($category);
            ?>
                <tr>
                    <td colspan="9" style="color:orange;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:13px;"><b>Category
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;<?= $cat->name; ?></b></span>
                </td>
                </tr>
           <?php

            $p_code= $this->reports_model->getProductCodeSummary($aa->warehouse_id,$cat->category_id,$pr_code,$start1,$end1,$reference_no);

            $total_qty_footer = 0;
            $total_amt_footer =0 ;
            $total_qty =0 ;
            foreach ($p_code as $cu){

            ?>
                <?php
                $wh = '';
                if($ware_house){
                    $wh= $ware_house;
                }else{
                    $wh= $aa->warehouse_id;
                }
                $product_detail = $this->reports_model->getAllProductCodeSummary($cu->product_code,$wh,$cat->category_id);

                foreach ($product_detail as $item){
                    //$this->erp->print_arrays($product_detail);
                    if($item->qty_return != null){
                        $total_qty=$item->qty-$item->qty_return;
                    }else{
                        $total_qty=$item->qty;
                    }

                    if($aa->warehouse_id){ ?>
                        <tr>
                            <td><?php echo $item->product_code;?></td>
                            <td style="text-align: right"> <?php echo round($total_qty,2);?>&nbsp;(<span style="color:#008000;"><?= $item->name ?></span>)</td>

                            <td style="text-align: right"><?php echo number_format( $item->amt-$item->amt_return, 2);?>&nbsp;</td>
                            <td class="text-center" style="padding: 2px"> <a href="reports/sale_by_item_detail?p_c=<?= $item->product_code ?>" class="btn btn-primary">View</a></td>

                        </tr>

                        <?php
                    }
                ?>


                <?php  }
                $total_qty_footer += $total_qty;
                $total_amt_footer +=$item->amt-$item->amt_return;
                ?>


            <?php }
                $total_cat+=$total_qty_footer;
                $gtotal_cat+=$total_amt_footer;

            }
            $total_amt+=$total_cat;
            $gtotal_amt+=$gtotal_cat;
        }?>
            <tr class="total-item2">

                <td><b>Total</b></td>
                <td class="line_op1 lp"><?php echo $total_amt;?></td>
                <td class="line_op1 lp"><?php echo number_format($gtotal_amt,2) ;?> &nbsp;</td>
                <td></td>

            </tr>

        </tbody>
    </table>
    </div>
</div>

</body>
</html>