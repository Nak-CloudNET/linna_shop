
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice&nbsp;<?= $invs->reference_no ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/custome.css" rel="stylesheet">

</head>
<head>
    <style>
        body {
            height: 100%;
            background: #FFF;
        }

        th {
            text-align: center;

            border: 1px solid #000;

        }
        td {
            border: 1px solid #000;
            padding-left:4px;
            padding-top:5px;
        }

        hr{
            border-color: #000;
            width:100px;
            margin-top: 70px;
        }
        p,h5,h4,h6{
            font-family :"Arial";
        }
        .no_bd_b td{
            border-bottom:0px;
            border-top:0px;
            font-size:12px;
        }
        .no-bor td{
            border-top:0px;
            border-bottom:0px;
        }

        @media print
        {
            body{

                font-size:12px;
            }
            .sbody{
                font-size:15.5px !important;
            }
            .print_invoice
            {
                display: none !important;
            }
            #cn{
                background-color: #8DC73F !important;
            }
            #st{
                background-color: #8DC73F !important;
            }
            .itm{
                background-color: #8DC73F !important;
            }
            #com{
                font-size:11px !important;
                font-family:font-family:Khmer OS Muol Light !important;
            }
            .bd{
                width : 100% !important;
            }
            .modal-content, .modal-body{
                border-bottom: none !important;
                border-top: none !important;
                border-right: none !important;
                border-left: none !important;
            }
            #customer_group{
                margin-top: 4% !important;
            }
            .bd, #madal_content, #madal_body{
                margin-left:-6px !important;
                margin-right: -30px !important;
            }
            .logo{
                margin-left:-0px !important;
            }
        }
    </style>
</head>
<body>
<div class="modal-dialog modal-lg no-modal-header bd">
    <div class="modal-content"  style="width : 100% !important;" id="madal_content">
        <div class="modal-body" id="madal_body">
            <button type="button" class="btn btn-xs btn-default no-print pull-right" id="print_invoice" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>

            <div class="invoice" id="wrap" style="width: 90%; margin: 0 auto;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-8 col-xs-8" style="padding: 0 !important; margin-bottom:10px; width:70%;">
                            <?php if ($logo) { ?>
                                <div class="logo" style="margin-top:10px;float:left;margin-right: 10px;margin-left:-25px;">
                                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                                         alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                                </div>
                            <?php } ?>
                            <div style="line-height: 1.5;">
                                <div style="font-family:Khmer OS Muol Light;" id="com"><?= $biller->cf1;?></div>
                                <div style="font-weight:bold;"><?= $biller->company;?></div>
                                <div style="font-size:11px;"><?= $biller->cf4;?></div>
                                <div style="font-size:11px;">ទូរស័ព្ទលេខ : <?= $biller->phone;?></div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-4" style="width:30%;">
                            <div style="font-weight:bold;padding-left:10px;">
                                <div style="font-size:18px;">វិក័យបត្រ</div>
                                <div style="font-size:20px;">INVOICE</div>
                            </div>
                            <div style="font-size:12px;">Invoice : <?= $inv->reference_no; ?></div>
                            <div style="font-size:12px;">Invoice Date : <?= date('M d, Y', strtotime($inv->date)); ?></div>
                            <div style="font-size:12px;">User : <?= $created_by->username?></div>
                        </div>
                        <div class="row padding10 test" id="body_style" style = "margin-left: -25px; margin-right: -25px;">
                            <div class="col-sm-7 col-xs-7" style="padding : 0 !important; float: left;margin-top:20px">
                                <table width="80%">
                                    <thead>
                                    <tr style="background:#8DC73F;">
                                        <td style="text-align:left;font-weight:bold;" id="cn">ឈ្មោះអតិថិជន / Customer :</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="border-bottom:0px;">
                                            <?= $customer->name_kh ? $customer->name_kh.'/' : $customer->company_kh; ?>
                                            <?= $customer->name ? $customer->name : $customer->company; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0px;border-bottom:0px;"><?= $customer->address;?></td>
                                    </tr>
                                    <?php
                                    if($customer->cf1){
                                        ?>
                                        <tr>
                                            <td style="border-top:0px;border-bottom:0px;"><?= $customer->cf1;?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <td style="border-top:0px;">Customer Group: <?=$customer->customer_group_name;?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-5"  style="float: right;margin-top:20px;text-align:right;margin-right: -15px;">

                                <?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 70, false); ?>
                                <img height="45px" src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                                     alt="<?= $inv->reference_no ?>"/>
                                <?php $this->erp->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
                                <img height="45px" src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
                                     alt="<?= $inv->reference_no ?>"/>
                            </div>
                            <div style="padding-top : 29% !important;" id="customer_group">
                                <table style="width: 100%;">
                                    <thead>
                                    <tr style="background:#8DC73F;text-align:center;font-weight:bold;" class="itm">
                                        <td colspan="2" style="text-align:left;padding-left:4px;">Customer ID</td>
                                        <td>Sale Order ID</td>
                                        <td colspan="2">Payment Terms</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align:center;"><?= $customer->code; ?></td>
                                        <td style="text-align:center;"><?= $inv->reference_no; ?></td>
                                        <td colspan="2" style="text-align:center;"><?= $pt->description;?></td>
                                    </tr>
                                    <tr style="background:#8DC73F;text-align:center; font-weight:bold;" class="itm">
                                        <td style="text-align:left;padding-left:4px;">Saleman</td>
                                        <td>Driver</td>
                                        <td>Ship Date</td>
                                        <td>Due Date</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            <?= $sale_by->first_name. ' '. $sale_by->last_name;?>
                                        </td>
                                        <td style="text-align:center;"><?= $deliver_by->name;?></td>
                                        <td style="text-align:center;"><?= date('d/m/Y', strtotime($inv->date))?></td>
                                        <td style="text-align:center;"><?= $inv->due_date == 0 ? '': date('d/m/Y', strtotime($inv->due_date)) ;?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div><br/></div>
                            <div style="text-align:left !important; padding-left:0 px !important;">
                                <table style="width: 100%;" id = "main_table">
                                    <thead style="font-size: 13px;">
                                    <tr style="background:#8DC73F;text-align:center;font-weight:bold;" class="itm">
                                        <td style="width:8%;">លេខកូដ<br/>Code</td>
                                        <td style="width:38%;">បរិយាយមុខទំនិញ <br/>Description</td>
                                        <td style="width:8%;">បរិមាណ<br/>Quantity</td>
                                        <td style="width:5%;">ខ្នាត<br/>U/M</td>
                                        <td style="width:13%;">ថ្លៃ​ឯកតា<br/>Unit Price ($)</td>
                                        <td style="width:10%;">បញ្ចុះតម្លៃ<br/>Discount</td>
                                        <td style="width:15%;">ថ្លៃ​ទំនិញ<br/>Amount($)</td>
                                    </tr>
                                    </thead>
                                    <tbody class="sbody" style="font-size: 15.5px;">
                                    <?php
                                    $total=0;
                                    $shipping = 0;
                                    $tax_summary = array();
                                    $i = 0;
                                    $total_quantity = 0;
                                    foreach ($rows as $row):
                                        $i++;
                                        $total_quantity += $row->quantity;
                                        $free = lang('free');
                                        $product_unit = '';
                                        if($row->variant){
                                            $product_unit = $row->variant;
                                        }else{
                                            $product_unit = $row->uname;
                                        }
                                        $rates = $inv->other_cur_paid_rate;

                                        $product_name_setting;
                                        if($pos->show_product_code == 0) {
                                            $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                                        }else{
                                            $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                                        }
                                        $discount_percentage = '';
                                        if (strpos($inv->order_discount_id, '%') !== false) {
                                            $discount_percentage = $inv->order_discount_id;
                                        }
                                        ?>
                                        <tr class="no_bd_b">
                                            <td style="text-align:left; vertical-align:middle;">
                                                <?= $row->product_code?>
                                            </td>
                                            <td style="vertical-align:middle;">
                                                <?= $row->product_name?>
                                            </td>
                                            <td style="text-align:center; vertical-align:middle;">
                                                <?= $this->erp->formatQuantity($row->quantity); ?>
                                            </td>
                                            <td style="text-align:center; vertical-align:middle;">
                                                <?php echo $product_unit; ?>
                                            </td>
                                            <td style="text-align:center; vertical-align:middle;">
                                                <?=$this->erp->formatMoney($row->unit_price); ?>
                                            </td>
                                            <td style="text-align:center; vertical-align:middle;">
                                                <?= ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->erp->formatMoney($row->item_discount); ?>
                                            </td>
                                            <td style="text-align:center; vertical-align:middle;">
                                                <?= $this->erp->formatMoney($row->subtotal); ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php
                                    if($i <= 15){
                                        $n = 15 - $i;
                                        for($a = 1; $a < $n; $a++){
                                            ?>
                                            <tr class="no-bor">
                                                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td>
                                            </tr>
                                            <?php
                                        }
                                    }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <table style="width:100%">
                                <tr valign="top">
                                    <td rowspan="6" style="border-left:0px;border-bottom:0px;width:20%">
                                        <p>សមតុល្យសរុប ​​: <?= $this->erp->formatMoney($due_amount->bal);?></p>
                                        <div style="padding-bottom: 5px; float:left;"><?= lang("rate"); ?>= (<?=$this->erp->formatQuantity($rates)?>)&nbsp;&nbsp;<?= lang("qty"); ?>= (<?=$this->erp->formatQuantity($total_quantity)?>)</div>
                                        <br/>
                                        <span style="float:left !important; font-size:13px;"><b>* កំណត់សំគាល់ :</b></span>
                                        </br/>
                                        <ul style="float:left; margin-left: 10px !important">
                                            <li>ទំនិញ​ទិញ​ហើយ មិន​អាច​ដូរ​វិញ​បានទេ</li>
                                            <li>សំរាប់ការទូទាត់ប្រាក់តាម លី ហួរ វេរលុយ</li>
                                        </ul>
                                        <br/>
                                        <span style="font-size:13px !important;"><b>Biller Name :</b> ចំនី​សត្វ​សានណា​ហ្គ្រោ</span><br/>
                                        <span style="font-size:13px !important;"><b>Biller Code  : </b>  59008</span>
                                    </td>
                                    <td style="width:26%">សរុបថ្លៃទំនិញ  / Sub Total (USD/KHR)</td>
                                    <td style="width:16%">
                                        <?= $this->erp->formatMoney($inv->total); ?>
                                        (<?=$this->erp->formatNumber(($inv->total)*$khCur->rate); ?>​​​ ៛)
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:26%">ថ្លៃដឹកជញ្ញូន / Freight (USD/KHR)</td>
                                    <td style="width:16%">
                                        <?= $this->erp->formatMoney($inv->shipping);?>
                                        (<?= $this->erp->formatNumber(($inv->shipping)*$khCur->rate);?>  ៛)
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:26%">បញ្ចុះតម្លៃ / Discounts</td>
                                    <td style="width:16%">
                                        <?= ($discount_percentage?"(" . $discount_percentage . ")" : '').'</span>' . $this->erp->formatMoney($inv->order_discount);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:26%">Payment (USD/KHR)</td>
                                    <td style="width:16%">
                                        <?= $this->erp->formatMoney($inv->paid); ?>
                                        (<?= $this->erp->formatNumber(($inv->paid)*$khCur->rate); ?> ៛)
                                    </td>
                                </tr>

                                <tr style="background:#8DC73F;font-weight:bold; height: 28px !important;" class="itm">
                                    <td style="width:26%"><?= lang("សមតុល្យ​ជាប្រាក់រៀល / Balance​​ in KHR"); ?></td>
                                    <td style="width:16%">
                                        <?php
                                        echo $this->erp->formatNumber(abs(($inv->grand_total - $inv->paid)*$khCur->rate)).' ៛';
                                        ?>
                                    </td>
                                </tr>
                                <tr style="background:#8DC73F;font-weight:bold; height: 28px !important;" class="itm">
                                    <td style="width:26%"><?= lang("សមតុល្យជាប្រាក់ដុល្លា / Balance in USD"); ?></td>
                                    <td style="width:16%">
                                        <?= $this->erp->formatMoney(abs($inv->grand_total - $inv->paid)) ; ?> $
                                    </td>
                                </tr>

                            </table>
                            <div class="row">
                                <div class="col-xs-3" style="text-align:left !important; padding-left:0px !important;text-align:center">
                                    <hr style="border:dotted 1px; width:100%; vertical-align:bottom !important; ">
                                    <p style="margin-left: 54px;">អតិថិជន</p>
                                    <p style="margin-left: 50px;">Customer</p>
                                </div>
                                <div class="col-xs-2" style="text-align:center">
                                    <hr style="border:dotted 1px; width:100%; vertical-align:bottom !important; ">
                                    <p>អ្នកដឹកជញ្ជូន</p>
                                    <p>Deliverer</p>
                                </div>
                                <div class="col-xs-2" style="text-align:center">
                                    <hr style="border:dotted 1px; width:100%; vertical-align:bottom !important; ">
                                    <p>អ្នកវេចខ្ចប់ទំនិញ</p>
                                    <p>Store Keeper</p>
                                </div>
                                <div class="col-xs-2" style="text-align:center">
                                    <hr style="border:dotted 1px; width:100%; vertical-align:bottom !important; ">
                                    <p>អ្នកលក់</p>
                                    <p>Seller</p>
                                </div>
                                <div class="col-xs-3" style="text-align:center">
                                    <hr style="border:dotted 1px; width:100%; vertical-align:bottom !important; ">
                                    <p>ប្រធានចាត់ការទូទៅ</p>
                                    <p>General Manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                window.onload = function() { window.print(); }
            </script>
        </div>
    </div>
</div>
</body>
