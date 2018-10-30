<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('click', '#excel1', function(e) {
            e.preventDefault();
            var k = false;
            $.each($("input[name='val[]']:checked"), function(){
                k = true;
            });
            $('#form_action').val($('#excel1').attr('data-action'));
            $('#action-form-submit').trigger('click');
        });
        $('body').on('click', '#pdf1', function(e) {
            e.preventDefault();
            var k = false;
            $.each($("input[name='val[]']:checked"), function(){

                k = true;
            });
            $('#form_action').val($('#pdf1').attr('data-action'));
            $('#action-form-submit').trigger('click');
        });
    });
</script>
<style>
    #tbstock .shead th{
        background-color: #428BCA;border-color: #357EBD;color:white;text-align:center;
    }

</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('Product_Movement_Summary') ; ?>
        </h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="pdf" data-action="export_pdf"  class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="excel" data-action="export_excel"  class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>
                <!--============= Search Area ===============-->
                <div id="form">
                    <?php echo form_open('reports/product_movement_summary', 'id="action-form"'); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="cat"><?= lang("products"); ?></label>
                                <?php
                                $pro[""] = "ALL";
                                foreach ($products as $product) {
                                    $pro[$product->id] = $product->code.' / '.$product->name;
                                }
                                echo form_dropdown('product', $pro, (isset($_POST['product']) ? $_POST['product'] : $product2), 'class="form-control" id="product" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("producte") . '"');
                                ?>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("warehouse", "warehouse") ?>
                                <?php
                                $waee[''] = "ALL";
                                foreach ($warefull as $wa) {
                                    $waee[$wa->id] = $wa->code.' / '.$wa->name;
                                }
                                echo form_dropdown('warehouse', $waee, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ''), 'class="form-control select" id="warehouse" placeholder="' . lang("select") . " " . lang("warehouse") . '" style="width:100%"')

                                ?>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("category", "category") ?>
                                <?php
                                $cat[''] = "ALL";
                                foreach ($categories as $category) {
                                    $cat[$category->id] = $category->name;
                                }
                                echo form_dropdown('category', $cat, (isset($_POST['category']) ? $_POST['category'] : $category2), 'class="form-control select" id="category" placeholder="' . lang("select") . " " . lang("category") . '" style="width:100%"')
                                ?>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("from_date", "from_date"); ?>
                                <?php echo form_input('from_date', (isset($_POST['from_date']) ? $_POST['from_date'] : $this->erp->hrsd($from_date2)), 'class="form-control date" id="from_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("to_date", "to_date"); ?>
                                <?php echo form_input('to_date', (isset($_POST['to_date']) ? $_POST['to_date'] : $this->erp->hrsd($to_date2)), 'class="form-control date" id="to_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary sub"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <!--============= Search Area ===============-->

                <div class="clearfix"></div>
                <div class="table-responsive" style="width:100%;">
                    <table id="tbstock" class="table table-condensed table-bordered table-hover table-striped" >
                        <thead>
                        <tr>
                            <th><?= lang("ID") ?></th>
                            <th><?= lang("Product Name") ?></th>
                            <th><?= lang("Begin_Balance") ?></th>
                            <th colspan="2" width="20%"><?= lang("in") ?></th>
                            <th colspan="2" width="20%"><?= lang("out") ?></th>
                            <th><?= lang("Ending") ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $wid = $this->reports_model->getWareByUserID();

                        if(!$warehouse2){
                            $warehouse2 = $wid;
                        }
                        $num = $this->reports_model->getTransuctionsPurIN($product2,$warehouse2,$from_date2,$to_date2,$biller2);

                        $num2 = $this->reports_model->getTransuctionsPurOUT($product2,$warehouse2,$from_date2,$to_date2,$biller2);

                        if(is_array($ware)){
                           //$this->erp->print_arrays($ware);
                            $gtotal_bqty=0;
                            $gtotal_in=0;
                            $gtotal_out=0;
                            $gtotal_ending=0;
                            foreach($ware as $rw){
                                ?>
                                <tr>
                                    <td colspan="<?= $k + $k2 + 9 ?>" style="color:green;"><span
                                                style="font-size:19px;"><b>Warehouse <i class="fa fa-angle-double-right"
                                                                                        aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?= $rw->name; ?></b></span>
                                    </td>
                                </tr>
                                <?php

                                $procat = $this->reports_model->getProCats($rw->warehouse_id,$category2,$product2,$from_date2, $to_date2);

                                $total_in_cate_w = array();
                                $total_out_cate_w = array();
                                //$this->erp->print_arrays($procat);
                                $ctotal_bqty=0;
                                $ctotal_in=0;
                                $ctotal_out=0;
                                $ctotal_ending=0;
                                foreach($procat as $rc) {

                                    $propur = $this->reports_model->getProPursName($rw->warehouse_id,$rc->category_id, $product2, $biller2, $from_date2, $to_date2);
                                ?>
                                        <tr>
                                            <td colspan="<?= $k + $k2 + 9 ?>" style="color:orange;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                        style="font-size:13px;"><b>Category <i
                                                                class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;<?= $rc->name; ?></b></span>
                                            </td>
                                        </tr>
                                    <?php

                                    $i = 1;
                                    $total_bqty = 0;
                                    $total_out = 0;
                                    $total_in = 0;
                                    $total_ending = 0;

                                    foreach ($propur as $rp) {
                                        $beginINqty = $this->reports_model->getBeginQtyINALLS($rp->id, $from_date2, $to_date2, $biller2);
                                        $beginOUTqty = $this->reports_model->getBeginQtyOUTALLS($rp->id, $from_date2, $to_date2, $biller2);
                                        //echo $beginOUTqty->bqty;exit;
                                        $btotal_qty = $beginINqty->bqty - $beginOUTqty->bqty;
                                        $allqty = $this->reports_model->getQtyINALL($rp->id, $rw->warehouse_id, $tr->tran_type, $from_date2, $to_date2, $biller2);

                                        if($rp){?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $rp->name ?></td>
                                                <td style='text-align:right;'><?= $btotal_qty ?></td>
                                                <td style='text-align:right;'>
                                                    <?php
                                                    if (is_array($num)) {
                                                        foreach ($num as $tr) {
                                                            $allqty = $this->reports_model->getQtyINALLS($rp->id,$rw->warehouse_id, $tr->tran_type, $from_date2, $to_date2, $biller2);
                                                        }
                                                        ?>
                                                        <?php if ($tr->tran_type == 'PURCHASE' || $tr->tran_type == 'SALE RETURN' || $tr->tran_type == "ADJUSTMENT" || $tr->tran_type == "TRANSFER") { ?>

                                                            <?php

                                                            $t_qty = 0;
                                                            $test = '+';
                                                            $len = count($allqty);
                                                            $ii = 0;
                                                            foreach ($allqty as $newal) {
                                                                if ($ii == $len - 1) {
                                                                    echo round($newal->bqty, 2);
                                                                } else {
                                                                    echo round($newal->bqty, 2) . $test;
                                                                }
                                                                $ii++;
                                                                $t_qty += $newal->bqty;
                                                            } ?>


                                                        <?php }
                                                    } ?>
                                                <td style='text-align:right;' width="5%">
                                                    <?php echo round($t_qty, 2); ?>
                                                </td>
                                                </td>
                                                <td width="15%" style='text-align:right;'>
                                                    <?php
                                                    if (is_array($num2)) {
                                                        foreach ($num2 as $tr2) {

                                                            $allqty2 = $this->reports_model->getQtyOUTALLS($rp->id,$rw->warehouse_id, $tr2->tran_type, $from_date2, $to_date2, $biller2);

                                                        } ?>
                                                        <?php if ($tr2->tran_type == 'SALE' || $tr2->tran_type == 'USING STOCK' || $tr2->tran_type == "ADJUSTMENT" || $tr2->tran_type == "TRANSFER" || $tr2->tran_type == "CONVERT") { ?>
                                                            <?php
                                                            $t_qty2 = 0;
                                                            $test = '+';
                                                            $len = count($allqty2);
                                                            $iiii = 0;
                                                            foreach ($allqty2 as $newal2) {
                                                                //echo 'hello';
                                                                if ($iiii == $len - 1) {
                                                                    echo round($newal2->bqty, 2);
                                                                } else {
                                                                    echo round($newal2->bqty, 2) . $test;
                                                                }
                                                                $iiii++;
                                                                $t_qty2 += $newal2->bqty;
                                                            }
                                                            ?>
                                                        <?php }

                                                    } ?>
                                                </td>
                                                <td style='text-align:right;' width="5%">
                                                    <?php echo round($t_qty2, 2); ?>
                                                </td>
                                                <td style='text-align:right;'><?= $btotal_qty + $t_qty - $t_qty2 ?></td>
                                            </tr>

                                       <?php }
                                        ?>

                                        <?php

                                        $total_bqty += $btotal_qty;
                                        $total_out += $t_qty2;
                                        $total_in += $t_qty;
                                        $total_ending += ($btotal_qty + $t_qty) - $t_qty2;
                                        $i++;
                                    }

                                    ?>

                                    <tr>
                                        <td colspan="2">Total</td>
                                        <td style='text-align:right;'><?= $total_bqty ?></td>
                                        <td></td>
                                        <td style='text-align:right;'><?= $total_in ?></td>
                                        <td></td>
                                        <td style='text-align:right;'><?= $total_out ?></td>
                                        <td style='text-align:right;'><?= $total_ending ?></td>
                                    </tr>
                                    <?php
                                    $ctotal_bqty+=$total_bqty;
                                    $ctotal_in+=$total_in;
                                    $ctotal_out+=$total_out;
                                   $ctotal_ending+=$total_ending;
                                }
                                $gtotal_bqty+=$ctotal_bqty;
                                $gtotal_in+=$ctotal_in;
                                $gtotal_out+=$ctotal_out;
                                $gtotal_ending+=$ctotal_ending;

                            }

                        }
                        ?>

                        <tr>
                            <td colspan="2">Grand Total</td>
                            <td style='text-align:right;'><?=$gtotal_bqty?></td>
                            <td></td>
                            <td style='text-align:right;'><?=$gtotal_in?></td>
                            <td></td>
                            <td style='text-align:right;'><?=$gtotal_out?></td>
                            <td style='text-align:right;'><?=$gtotal_ending?></td>
                        </tr>


                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('focus','.date-year', function(t) {
            $(this).datetimepicker({
                format: "yyyy",
                startView: 'decade',
                minView: 'decade',
                viewSelect: 'decade',
                autoclose: true,
            });
        });
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
        $('#excel').on('click', function (e) {
            e.preventDefault();
            if ($('.checkbox:checked').length <= 0) {
                window.location.href = "<?= site_url('reports/inventoryInoutReport2/0/xls/'.$product1.'/'.$category1.'/'.$warehouse1.'/'.$from_date2.'/'.$to_date2) ?>";
                return false;
            }
        });
        $('#pdf').on('click', function (e) {
            e.preventDefault();
            if ($('.checkbox:checked').length <= 0) {
                window.location.href = "<?= site_url('reports/inventoryInoutReport2/pdf/0/'.$product1.'/'.$category1.'/'.$warehouse1.'/'.$from_date2.'/'.$to_date2) ?>";
                return false;
            }
        });
    });



</script>