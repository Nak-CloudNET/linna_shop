<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KNK Invoice</title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/custome.css" rel="stylesheet">
</head>
<style>
    body {
        font-size: 12px;
    }
    .container {
        width: 29.7cm;
        margin: 20px auto;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    }
    .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
        border: 1px solid #000 !important;
    }

    .table-bordered {
        margin-top: 5px;
    }
    .table-bordered th {
        text-align: center;
        vertical-align: middle !important;
    }

    .table-bordered td:nth-child(1) {
        text-align: center;
        vertical-align: middle;
    }

    .table-bordered td:nth-child(n+3) {
        text-align: right;
    }
    .footer .panel {
        border: none;
    }
    .footer .panel-heading, .panel-body, .panel-footer {
        padding: 0;
        border: none;
        background-color: transparent;
    }
    .footer hr {
        margin-top: 5px;
        margin-bottom: 5px;

    }
    .logo .col-sm-4 {
        padding-left: 0;
        padding-right: 0;
    }


    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 4px !important;
    }

    @media print {
        body {
            font-size: 10px;
        }
        .container {
            width: 95% !important;
            height: 780px !important;
            margin: 0 auto !important;
        }
        .container h4 {
            font-size: 16px !important
        }
        .logo {
            padding-top: 15px !important
        }

        .img-responsive {
            width: 120px !important;
        }

        #footer {
            position: absolute;
            bottom: 0;
        }

        #footer .col-sm-4 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #footer hr {
            width: 70% !important;
            margin-left: 0 !important;
        }

    }


</style>
<body>
<div class="container" style="width: 625px;">
    <div class="row logo" style="padding: 15px">
        <?php if($biller->address){?>
            <div class="col-sm-4 col-xs-4">
                <p>អាស័យដ្ឋាន: <?= $biller->address; ?></p>
            </div>
        <?php }  ?>
        <div class="col-sm-4 col-xs-4 text-center">
            <?php if (!empty($biller->logo)) { ?>
                <img class="img-responsive myhide" src="<?= base_url() ?>assets/uploads/logos/<?= $biller->logo; ?>"
                     id="hidedlo" style="width: 140px; margin-left: 25px;margin-top: -10px;"/>
            <?php } ?>
        </div>
        <div class="col-sm-4 col-xs-4">
            <p class="text-right">លេខ: <strong><?= $invs->reference_no; ?></strong></p>
            <p class="text-right">កាលបរិច្ឆេទ: <strong><?= $this->erp->hrsd($invs->date); ?></strong></p>
            <p class="text-right">អតិថិជន: <strong><?= $invs->customer; ?></strong></p>
            <p class="text-right">កូដអតិថិជន: <strong><?= $invs->code; ?></strong></p>
            <p class="text-right">អ្នកលក់: <strong><?= $invs->first_name; ?>&nbsp;<?=$invs->last_name;?></strong></p>
            <p class="text-right"><strong><?= $invs->areas_group; ?></strong></p>

            <?php //$this->erp->print_arrays($invs); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-xs-4">
            <img height="45px"
                 src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                 alt="<?= $invs->reference_no ?>" style="height: 40px"/>
        </div>
        <div class="col-sm-4 col-xs-4">
            <h4 class="text-center">វិក្ក័យប័ត្រ</h4>
        </div>
        <div class="col-sm-4 col-xs-4"></div>
    </div>
    <?php
    $totalDisc = 0;
    $totalItemTax = 0;
    foreach ($rows as $row) {
        $totalDisc += $row->item_discount;
        $totalItemTax += $row->item_tax;
    }
    ?>
    <table class="table table-bordered">
        <thead>
        <?php
        $total_discount=0;
        $total_tax=0;
        foreach ($rows as $row) {
            $total_discount +=  $row->item_discount;
            $total_tax +=  $row->item_tax;
        }



        ?>
        <tr>
            <th>ល.រ</th>
            <th style="width: 30%">បរិយាយទំនិញ</th>
            <th>ចំនួនកេស</th>
            <th>ចំនួនរាយ</th>
            <th>តម្លៃឯកតា</th>
            <?php if ($total_discount) { ?>
                <th>បញ្ចុះតម្លៃ</th>
            <?php } ?>
            <?php if ($total_tax) { ?>
                <th style="width: 10%">ពន្ធទំនិញ</th>
            <?php } ?>
            <th style="width: 20%">ចំនួនទឹកប្រាក់</th>
        </tr>
        </thead>
        <tbody>
        <?php
                 //$this->erp->print_arrays($rows);
        $no = 1;
        $erow = 1;
        foreach ($rows as $row) {
            $free = lang('free');
            $product_unit = '';
            $total = 0;

            if ($row->variant) {
                $product_unit = $row->variant;
            } else {
                $product_unit = $row->uname;
            }
            $product_name_setting;
            if ($setting->show_code == 0) {
                $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
            } else {
                if ($setting->separate_code == 0) {
                    $product_name_setting = $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : '');
                } else {
                    $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                }
            }
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $row->product_name; ?></td>
                <td>
                    <?php
                    if ($row->option_id && $this->erp->formatQuantity($row->quantity) < $row->quantity_balance) {
                        echo $this->erp->formatQuantity($row->quantity) . ' ' . $row->variant;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($row->option_id || $this->erp->formatQuantity($row->quantity) == $row->quantity_balance) {
                        echo $this->erp->formatQuantity($row->quantity_balance) . ' ' . $row->uname;
                    }
                    ?>
                </td>
                <td><?= $this->erp->formatMoney($row->unit_price); ?></td>
                <?php if ($row->item_discount) {?>
                    <td style="vertical-align: middle; text-align: center">
                        <?php
                            if(strpos($row->discount,"%")===false){
                                echo "<small style='font-size: 10px;'>(".$row->discount."%)</small>" ;

                            }
                            echo $this->erp->formatMoney($row->item_discount);
                        ?>
                    </td>
                <?php } ?>
                <?php if ($total_tax) { ?>
                    <td><?= $this->erp->formatMoney($row->item_tax); ?></td>
                <?php } ?>
                <td>
                    <div style="text-align: left !important; position: absolute"><?= $default_currency->code ?></div><?= $this->erp->formatMoney($row->subtotal); ?>
                </td>
            </tr>

            <?php
            $no++;
            $erow++;

        }

        if ($erow < 11) {
            $k = 11 - $erow;
            for ($j = 1; $j <= $k; $j++) {
                if($total_discount && $total_tax) {
                    echo  '<tr class="border" >
                                   <td height="34px" style="text-align: center; vertical-align: middle;border-left: 1px solid black !important;border-right: 1px solid black;border-top: 1px solid white;  "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    
                                </tr>';

                } else {
                    if ($total_tax || $total_discount){

                        echo '<tr class="border" >
                                   <td height="34px" style="text-align: center; vertical-align: middle;border-left: 1px solid black !important;border-right: 1px solid black;border-top: 1px solid white;  "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    
                                    
                                </tr>';
                    }else {
                        echo  '<tr class="border" >
                                    <td height="34px" style="text-align: center; vertical-align: middle;border-left: 1px solid black !important;border-right: 1px solid black;border-top: 1px solid white;  "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                    <td style="border-right: 1px solid black;border-top: 1px solid white; "></td>
                                   
                                    
                                </tr>';
                    }
                }
                $no++;
            }
        }
        ?>
        </tbody>
        <tfoot>
        <?php
        $row = 1;
        $col =2;

        if ($total_discount> 0) {
            $col +=1;
        }

        if ($invs->grand_total != $invs->total) {
            $row++;
        }
        if ($invs->order_discount > 0) {
            $row++;
        }
        if ($invs->shipping> 0) {
            $row++;
        }

        if ($total_tax> 0) {
            $col +=1;
        }
        if ($invs->order_tax > 0){
            $row++;
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
            <tr class="border-foot">
                <td rowspan="<?= $row; ?>" colspan="3"
                    style="vertical-align: top; border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
                    <?php if (!empty($invs->invoice_footer)) { ?>
                        <p style="text-align: left;line-height: 80%;"><?= nl2br($invs->invoice_footer); ?></p>
                    <?php } ?>
                </td>
                <td colspan="<?= $col; ?>" style="text-align: right;">សរុប​</td>
                <td align="right">
                    <strong><?= $default_currency->code . ' ' . $this->erp->formatMoney($invs->total); ?></strong></td>
            </tr>
        <?php } ?>

        <?php if ($invs->order_discount != 0) : ?>
            <tr class="border-foot">
                <td colspan="<?= $col; ?>" style="text-align: right">បញ្ចុះតម្លៃ</td>
                <td align="right">
                    <strong><?php echo $default_currency->code . ' ' . $this->erp->formatQuantity($invs->order_discount); ?></strong>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ($invs->shipping != 0) : ?>
            <tr class="border-foot">
                <td colspan="<?= $col; ?>" style="text-align: right">ដឹកជញ្ជូន</td>
                <td align="right">
                    <strong><?php echo $default_currency->code . ' ' . $this->erp->formatQuantity($invs->shipping); ?></strong>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ($invs->order_tax != 0) : ?>
            <tr class="border-foot">
                <td colspan="<?= $col; ?>" style="text-align: right">ពន្ធអាករ</td>
                <td align="right">
                    <strong><?= $default_currency->code . ' ' . $this->erp->formatQuantity($invs->order_tax); ?></strong>
                </td>
            </tr>
        <?php endif; ?>

        <tr class="border-foot">
            <?php if ($invs->grand_total == $invs->total) { ?>
                <td rowspan="<?= $row; ?>" colspan="3"
                    style="border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
                    <?php if (!empty($invs->invoice_footer)) { ?>
                        <p style="margin-top: 10px; text-align: left;line-height: 80%;"><?= nl2br($invs->invoice_footer); ?></p>
                    <?php } ?>
                </td>
            <?php } ?>
            <td colspan="<?= $col; ?>" style="text-align: right">ទឹកប្រាក់ត្រូវទូទាត់</td>
            <td align="right">
                <strong><?= $default_currency->code . ' ' . $this->erp->formatMoney($invs->grand_total); ?></strong>
            </td>
        </tr>
        <?php if ($invs->paid != 0 || $invs->deposit != 0) { ?>
            <?php if ($invs->deposit != 0) { ?>
                <tr class="border-foot">
                    <td colspan="<?= $col; ?>" style="text-align: right">បានកក់</td>
                    <td align="right">
                        <strong><?php echo $default_currency->code . ' ' . $this->erp->formatMoney($invs->deposit); ?></strong>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($invs->paid != 0) { ?>
                <tr class="border-foot">
                    <td colspan="<?= $col; ?>" style="text-align: right">បានបង់</td>
                    <td align="right">
                        <strong><?php echo $default_currency->code . ' ' . $this->erp->formatMoney($invs->paid - $invs->deposit); ?></strong>
                    </td>
                </tr>
            <?php } ?>

            <tr class="border-foot">
                <td colspan="<?= $col; ?>" style="text-align: right">នៅខ្វះ</td>
                <td align="right">
                    <strong><?= $default_currency->code . ' ' . $this->erp->formatMoney($invs->grand_total - (($invs->paid - $invs->deposit) + $invs->deposit)); ?></strong>
                </td>
            </tr>
        <?php } ?>
        </tfoot>
    </table>
    <br>
    <div class="row" id="footer">
        <div class="col-sm-4 col-xs-4 footer">
            <p style="margin-bottom: 80px">ហត្ថលេខាអ្នកត្រួតពិនិត្យ</p>
            <div class="panel panel-default">
                <div class="panel-heading">ឈ្មោះ:</div>
                <div class="panel-body">
                    <hr style="border: 1px dotted #000">
                </div>
                <div class="panel-footer">ថ្ងៃបោះពុម្ភ:</div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-4 footer">
            <p style="margin-bottom: 80px">ហត្ថលេខាអ្នកដឹកជញ្ជូន</p>
            <div class="panel panel-default">
                <div class="panel-heading">ឈ្មោះ:</div>
                <div class="panel-body">
                    <hr style="border: 1px dotted #000">
                </div>
                <div class="panel-footer">ម៉ោងចេញ:</div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-4 footer">
            <p style="margin-bottom: 80px">ហត្ថលេខាអ្នកអតិថិជន</p>
            <div class="panel panel-default">
                <div class="panel-heading">ឈ្មោះ:</div>
                <div class="panel-body">
                    <hr style="border: 1px dotted #000">
                </div>
                <div class="panel-footer">ម៉ោងទទួល:</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>