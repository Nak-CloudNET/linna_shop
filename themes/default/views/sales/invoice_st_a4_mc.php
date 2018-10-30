
<?php //$this->erp->print_arrays($discount['discount']) ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice&nbsp;<?= $invs->reference_no ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/custome.css" rel="stylesheet">

</head>

<style>
    .container {
        width: 100%;
        min-height: 27.7cm;
        margin: 20px auto;

        font-size: 12px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        position:relative;
    }

    .border td,.border th, .col{
        border: 1px solid #9D192B !important;
        padding: 3px;

    }

    @media print {

        .pageBreak {
            page-break-after: always;
            -webkit-page-break-after: always;
        }
        .container {
            width: 95% !important;
            height:auto !important;
            font-size: 11px !important;
            margin: 0 auto !important;

        }
        .customer_label {
            padding-left: 0 !important;
        }
        tbody{
            display:table-row-group;
            -webkit-print-color-adjust: exact;
        }
        .print th{
            color:white !important;
            background: #444 !important;
        }

        .noPadding tr td{
            font-size: 12px !important;
            margin: 0 auto !important;
        }
        .tt{
            color: #9D192B  !important;
        }
        .table > thead > tr > th,.table > thead > tr > td, tbody > tr > th, .table > tfoot > tr > th, .table > tbody > tr > td, .table > tfoot > tr > td{
            padding:5px;
            border-color: #9D192B !important;
        }
        .invoice_label {
            padding-left: 0 !important;
        }

        .col-xs-12, .col-sm-12{
            padding-left:1px;
            padding-right:1px;
            margin-left:0px;
            margin-right:0px;
        }
        #note{
            max-width: 100% !important;
            margin: 0 auto !important;
            font-size: 14px !important;
            border-radius: 5px 5px 5px 5px !important;
        }

        table {border-collapse: collapse;}




    }

    body{
        font-size: 12px !important;
        font-family: "Khmer OS System";
        -moz-font-family: "Khmer OS System";
    }

    .table > thead > tr > th,.table > thead > tr > td, tbody > tr > th, .table > tfoot > tr > th, .table > tbody > tr > td, .table > tfoot > tr > td{
        padding:5px;
        border-color: #9D192B !important;
    }
    .title{
        font-family:"Khmer OS Muol Light";
        -mox-font-family:"Khmer OS Muol Light";
        color: #9D192B  !important;
    }
    h4{
        margin-top: 0px;
        margin-bottom: 0px;
    }

    #note h4{
        padding: 10px;
        font-size: 16px ;
        color: maroon !important;
    }
    .noPadding tr td{
        padding: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        border:1px solid white;
    }
    .border-foot td{
        border: 1px solid #9D192B !important;
    }
    thead tr th{
        font-weight: normal;
        text-align: center;
    }
    @media print {
        #print{
            display: none !important;

        }
        .tfoot{
            background-color:#ffb3b3 !important;

        }

    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#hide").click(function(){
            $(".myhide").toggle();
        });
    });
</script>
<body>
<div class="container" style="width: 821px;margin: 0 auto;">
    <div class="col-xs-12"
    <?php
    $cols = 6;
    if ($discount != 0) {
        $cols = 7;
    }
    ?>
    <div class="row">
        <table class="table">
            <thead>
            <tr class="thead" style="border-left:none;border-right: none;border-top:none;">
                <th colspan="12" style="border-left:none;border-right: none;border-top:none;border-bottom: 1px solid #9D192B !important;">
                    <div class="row" style="margin-top: 0px !important;">
                        <div class="col-sm-4 col-xs-4 " style="margin-top: 0px !important;">

                        </div>
                        <div class="col-sm-4 col-xs-4 " style="margin-top: 0px !important;">
                            <?php if(!empty($biller->logo)) { ?>
                                <!--<center><img class="img-responsive myhide" src="<?= base_url() ?>assets/uploads/logos/<?= $biller->logo; ?>"id="hidedlo" style="width: 140px;" /></center>-->
                            <?php } ?>
                        </div>
                        <div class="col-sm-4 col-xs-4 " >
                            <button  id="print" onclick="window.print()" class="btn btn-success ">
                                Print
                            </button>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 0px !important;">
                        <div class="col-sm-4 col-xs-4 " style="margin-top: 0px !important;">
                            <h3 class="title">វិក្កយបត្រ</h3>
                        </div>
                        <div class="col-sm-4 col-xs-4 " style="margin-top: 0px !important;">
                            <?php if(!empty($biller->logo)) { ?>
                                <!--<center><img class="img-responsive myhide" src="<?= base_url() ?>assets/uploads/logos/<?= $biller->logo; ?>"id="hidedlo" style="width: 140px;" /></center>-->
                            <?php } ?>
                        </div>
                        <div class="col-sm-4 col-xs-4 " >
                            <h3 class="title">INVOICE</h3>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12 col-xs-12" style="margin-bottom: -42px !important;">
                            <hr style="border-top:3px solid #9D192B !important;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 ">
                            <h3 style="font-size: 16px !important; color: #9D192B !important;" align="left">INVOICE# : <?= $invs->reference_no ?></h3>
                        </div>
                        <div class="col-sm-6 col-xs-6 " style="color: #9D192B !important;">
                            <h3 style="font-size: 16px !important; color: #9D192B !important;" align="right">DATE : <?= $this->erp->hrld($invs->date); ?></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12" style="margin-top: -30px !important;">
                            <hr style="border-top:2px solid #9D192B !important;">
                        </div>
                    </div>

                    <?php //$this->erp->print_arrays($Settings); ?>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12 ">
                            <table class="noPadding" border="none" style="margin-bottom: -19px !important;margin-top: -31px !important;">
                                <tr>
                                    <td style="padding:10px;text-align: left;border-right: 3px solid #9D192B !important;color: #9D192B !important; " rowspan="2">Address </td>&nbsp;&nbsp;&nbsp;
                                    <?php if(!empty($biller->address_kh)) { ?>
                                        <td style="width: 63%; text-align: left;color: #9D192B !important;" align="left"><?= $biller->address_kh?></td>
                                    <?php }else { ?>
                                        <td style="width: 63%; text-align: left;color: #9D192B !important;" align="left"><?= $biller->address ?></td>
                                    <?php } ?>
                                    <td style="padding:10px;width: 5%; text-align: left;border-right: 3px solid #9D192B !important;color: #9D192B !important; ">BILL</td>
                                    <td style="width: 63%; text-align: left;color: #9D192B !important;" align="right">Name : <?= $customer->name; ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;color: #9D192B !important;">លេខទូរស័ព្ទ : (+855)&nbsp;&nbsp;<?= $biller->phone?></td>
                                    <td style="padding:10px;text-align: left;border-right: 3px solid #9D192B !important;color: #9D192B !important; ">TO</td>
                                    <td style="text-align: left;padding:5px;color: #9D192B !important;" align="right">phone : <?= $customer->phone; ?></td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    </br>

                </th>
            </tr>
            <table style="width: 100%">
                <thead>
                <tr class="border">
                    <th style="color: #9D192B !important;">ល.រ<br /><?= strtoupper(lang('no')) ?></th>
                    <th style="color: #9D192B !important;">បរិយាយមុខទំនិញ<br /><?= strtoupper(lang('description')) ?></th>
                    <th style="color: #9D192B !important;">ខ្នាត<br /><?= strtoupper(lang('unit')) ?></th>
                    <th style="color: #9D192B !important;">ចំនួន<br /><?= strtoupper(lang('qty')) ?></th>
                    <th style="color: #9D192B !important;">តម្លៃ<br /><?= strtoupper(lang('price')) ?></th>

                    <?php if ($Settings->product_discount>0) { ?>
                        <th style="color: #9D192B !important;">បញ្ចុះតម្លៃ<br /><?= strtoupper(lang('discount')) ?></th>
                    <?php } ?>
                    <?php if ($Settings->tax1>0) { ?>
                        <th style="color: #9D192B !important;width: 10%">ពន្ធទំនិញ<br /><?= strtoupper(lang('tax')) ?></th>
                    <?php } ?>
                    <th style="color: #9D192B !important;">តម្លៃសរុប<br /><?= strtoupper(lang('subtotal')) ?></th>
                </tr>
                </thead>
                <tbody>

                <?php

                $no = 1;
                $erow = 1;
                $totalRow = 0;
                foreach ($rows as $row) {
                    //$this->erp->print_arrays($invs);
                    $free = lang('free');
                    $product_unit = '';
                    $total = 0;

                    if($row->variant){
                        $product_unit = $row->variant;
                    }else{
                        $product_unit = $row->uname;
                    }
                    $product_name_setting;
                    if($setting->show_code == 0) {
                        $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                    }else {
                        if($setting->separate_code == 0) {
                            $product_name_setting = $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : '');
                        }else {
                            $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                        }
                    }
                    ?>
                    <tr class="border">
                        <td style="width: 5%;color: #9D192B !important;vertical-align: middle; text-align: center"><?php echo $no ?></td>
                        <td style="width: 50%; color: #9D192B !important;vertical-align: middle;">
                            <?=$row->product_name;?>
                        </td>
                        <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center">
                            <?= $product_unit ?>
                        </td>
                        <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center">
                            <?=$this->erp->formatQuantity($row->quantity);?>
                        </td>
                        <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center;">
                            <?php
                            if($row->real_unit_price==0){echo "";}
                            else{
                                echo $this->erp->formatMoney($row->real_unit_price);
                            }
                            ?>
                        </td>
                        <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center;">
                            <?php
                            if($row->item_discount==0){echo "";}
                            else{
                                echo $this->erp->formatMoney($row->item_discount);
                            }
                            ?>
                        </td>
                        <!--                        --><?php //if ($row->item_discount>0) {?>
                        <!--                            <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center">-->
                        <!---->
                        <!--                                --><?php
                        //                                if(strpos($row->discount,"%")){
                        //                                    echo "<small style='font-size:10px;'>(".$row->discount.")</small>" ;
                        //                                }
                        //                                echo $this->erp->formatMoney($row->item_discount);
                        //                                ?>
                        <!--                            </td>-->
                        <!--                        --><?php //} ?>
                        <?php if ($row->item_tax>0) {?>
                            <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center">
                                <?=$this->erp->formatMoney($row->item_tax);?></td>
                        <?php } ?>
                        <?php if ($row->item_tax ==0) {?>
                            <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center">
                            </td>
                        <?php } ?>

                        <td style="width: 8%;color: #9D192B !important;vertical-align: middle; text-align: center;">
                            <?php
                            if($row->subtotal==0){echo "Free";}
                            else{
                                echo $this->erp->formatMoney($row->subtotal);
                            }
                            ?>
                        </td>
                    </tr>

                    <?php
                    $no++;
                    $erow++;
                    $totalRow++;
//                    if ($totalRow % 25 == 0) {
//                        echo '<tr class="pageBreak"></tr>';
//                    }

                }
                ?>
                <?php
                if($erow<11){
                    $k=11 - $erow;
                    for($j=1;$j<=$k;$j++) {
                        if($discount < 0) {
                            echo  '<tr class="border">
                                    <td style="color:#9D192B !important; text-align: center; vertical-align: middle">'.$no.'</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    </tr>';
                        }else {
                            echo  '<tr class="border">
                                    <td style="color:#9D192B !important;text-align: center; vertical-align: middle">'.$no.'</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>';
                        }
                        $no++;
                    }
                }
                ?>
                <?php
                $row = 1;
                $col =3;
                $col2=3;
                if($invs->total_discount){$col=4;$col2=2;}
                if($invs->product_tax){$col=4;$col2=2;}
                if($invs->total_discount>0 && $invs->product_tax>0 ){$col=3;$col2=3;}
                if($invs->total_discount==0 && $invs->product_tax==0 ){$col=3;$col2=2;}
                if ($discount != 0) {
                    $col = 2;
                }
                if ($invs->grand_total != $invs->total) {
                    $row++;


                }
                if ($invs->order_discount != 0) {
                    $row++;
                    $col =4;
                }
                if ($invs->shipping != 0) {
                    $row++;
                    $col =4;
                }
                if ($invs->order_tax != 0) {
                    $row++;
                    $col =4;
                }
                if($invs->paid != 0 && $invs->deposit != 0) {
                    $row += 3;
                }elseif ($invs->paid != 0 && $invs->deposit == 0) {
                    $row += 2;
                }elseif ($invs->paid == 0 && $invs->deposit != 0) {
                    $row += 2;
                }
                ?>

                <?php
                if ($invs->grand_total != $invs->total) { ?>
                    <tr class="border-foot" style="">
                        <td rowspan = "<?= $row; ?>" colspan="<?= $col2; ?>" style="color:#9D192B !important;border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
                            <?php if (!empty($invs->invoice_footer)) { ?>
                                <p ><strong><u style="color:#9D192B !important;">Note:</u></strong></p>
                                <p style="color:#9D192B !important;margin-top:-5px !important; line-height: 2"><?= $invs->invoice_footer ?></p>
                            <?php } ?>
                        </td>
                        <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold;background-color:#ffb3b3 !important;">សរុប​ / <?= strtoupper(lang('total')) ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td align="right" style="color:#9D192B !important;background-color:#ffb3b3 !important;"><?=$this->erp->formatMoney($invs->total); ?></td>
                    </tr>
                <?php } ?>

                <?php if ($invs->order_discount != 0) : ?>
                    <tr class="border-foot">
                        <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold;background-color:#ffb3b3 !important;">បញ្ចុះតម្លៃ / <?= strtoupper(lang('order_discount')) ?></td>
                        <td align="right" style="color:#9D192B !important;background-color:#ffb3b3 !important;"><small style='color:#9D192B !important;font-size:10px;'>(<?php echo $invs->order_discount_id; ?>%)</small>&nbsp;<?php echo $this->erp->formatMoney($invs->order_discount); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ($invs->shipping != 0) : ?>
                    <tr class="border-foot">
                        <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold;">ដឹកជញ្ជូន / <?= strtoupper(lang('shipping')) ?></td>
                        <td align="right" style="color:#9D192B !important;"><?php echo $this->erp->formatMoney($invs->shipping); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ($invs->order_tax != 0) : ?>
                    <tr class="border-foot">
                        <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold;">ពន្ធអាករ / <?= strtoupper(lang('order_tax')) ?></td>
                        <td align="right" style="color:#9D192B !important;"><?= $this->erp->formatMoney($invs->order_tax); ?></td>
                    </tr>
                <?php endif; ?>

                <tr class="border-foot">
                    <?php if ($invs->grand_total == $invs->total) { ?>
                        <td rowspan="<?= $row; ?>" colspan="<?= $col2; ?>" style="border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
                            <?php if (!empty($invs->invoice_footer)) { ?>
                                <p><strong><u style="color:#9D192B !important;">Note:</u></strong></p>
                                <p style="color:#9D192B !important;"><?= $invs->invoice_footer ?></p>
                            <?php } ?>
                        </td>
                    <?php } ?>
                    <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold; background-color:#ffb3b3;" class="tfoot">សរុបរួម / <?= strtoupper(lang('total_amount')) ?>
                        (<?= $default_currency->code; ?>)
                    </td>
                    <td align="right" style="color:#9D192B !important; text-align: center; background-color:#ffb3b3;" class="tfoot">
                        <?php
                        if($invs->grand_total==0){echo "Free";}
                        else{
                            echo $this->erp->formatMoney($invs->grand_total);
                        }
                        ?>
                    </td>
                </tr>
                <?php if($invs->paid != 0 || $invs->deposit != 0){ ?>
                    <?php if($invs->deposit != 0) { ?>
                        <tr class="border-foot">
                            <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold;">បានកក់ / <?= strtoupper(lang('deposit')) ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td align="right" style="color:#9D192B !important;"><?php echo $this->erp->formatMoney($invs->deposit); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if($invs->paid != 0) { ?>
                        <tr class="border-foot" style="background-color:#ffb3b3;
">
                            <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold; background-color:#ffb3b3;" class="tfoot">បានបង់ / <?= strtoupper(lang('paid')) ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td align="right" style="color:#9D192B !important; text-align: center; background-color:#ffb3b3;" class="tfoot"><?php echo $this->erp->formatMoney($invs->paid-$invs->deposit); ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="border-foot">
                        <td colspan="<?= $col; ?>" style="color:#9D192B !important;text-align: right; font-weight: bold; background-color:#ffb3b3;" class="tfoot">នៅខ្វះ / <?= strtoupper(lang('balance')) ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td align="right" style="color:#9D192B !important;text-align: center; background-color:#ffb3b3;" class="tfoot"><?= $this->erp->formatMoney($invs->grand_total - (($invs->paid-$invs->deposit) + $invs->deposit)); ?></td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <?php if(trim(htmlspecialchars_decode($invs->note))){ ?>
                <div style="border-radius: 5px 5px 5px 5px;border:1px solid #9D192B !important;height: auto;" id="note" class="col-md-12 col-xs-12">
                    <h4><?= strip_tags($invs->note) ?></h4>
                </div>
            <?php } ?>
            <?php if ($invs->order_tax != 0 || $invs->order_discount != 0) { ?>
                <div class="clear-both">
                    <div style="width:100%;height:150px"></div>
                </div>
            <?php }else{ ?>
                <div class="clear-both">
                    <div style="width:100%;height:150px"></div>
                </div>
            <?php } ?>
            <div id="footer" class="row" >
                <div class="col-sm-6 col-xs-6">
                    <center>
                        <hr style="margin:0; border:1px solid #9D192B !important; width: 50%">
                        <p style="color:#9D192B !important; margin-top: 4px !important">ហត្ថលេខា និងឈ្មោះអ្នកទទូល</p>
                        <p style="color:#9D192B !important;margin-top:-10px;">Prepared's Signature & Name</p>
                    </center>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <center>
                        <hr style="margin:0; border:1px solid #9D192B !important; width: 50%">
                        <p style="color:#9D192B !important; margin-top: 4px !important">ហត្ថលេខា និងឈ្មោះអ្នកលក់</p>
                        <p style="color:#9D192B !important;margin-top:-10px; ">Customer's Signature & Name</p>
                    </center>
                </div>
            </div>


    </div>


    <!--jtjflsjdf-->

    <div style="width: 821px;margin: 20px">
        <a class="btn btn-warning no-print" href="<?= site_url('sales'); ?>" style="border-radius: 0">
            <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("back"); ?>
        </a>
    </div>
</div>

</body>

<script type="text/javascript">
    //put 6 hide discount,put 7 show discount
    if(!<?=$invs->total_discount?$invs->total_discount:0; ?>){
        $('td:nth-child(6),th:nth-child(6)').hide();
    }
    // put 7hide tax show discount,put 6 hid discount show tax
    if(!<?=$invs->product_tax?$invs->product_tax:0; ?>){
        $('td:nth-child(7),th:nth-child(7)').hide();
    }


</script>
</html>