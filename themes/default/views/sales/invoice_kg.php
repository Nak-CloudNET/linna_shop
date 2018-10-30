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
        font-size: 12px !important;
    }

    @media print {

        .container {
            height: 21cm !important;
            margin-top: 0px !important;
            font-size: 12px !important;
        }
        .customer_label {
            padding-left: 0 !important;
        }

        .invoice_label {
            padding-left: 0 !important;
        }

        .row table tr td {
            font-size: 12px !important;
        }

        .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th {
            background-color: #444 !important;
        }

        .row .col-xs-7 table tr td, .col-sm-5 table tr td{
            font-size: 12px !important;
        }
        #note{
            max-width: 95% !important;
            margin: 0 auto !important;
            border-radius: 5px 5px 5px 5px !important;
            margin-left: 26px !important;
        }
    }
    .thead th {
        text-align: center !important;
    }

    .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
        border: 1px solid #000 !important;
    }

    .company_addr h3 {
        font-family: Khmer Mool1 !important;
    }

    .company_addr h4 {
        font-weight: bold;
        font-family: Times New Roman !important;
    }

    .company_addr p {
        font-size: 12px !important;
        margin-top:-10px !important;
        padding-left: 20px !important;
    }

    .inv h4:first-child {
        font-family: Khmer Mool1 !important;
        font-size: 12px !important;
    }

    .inv h4:last-child {
        margin-top:5px !important;
        font-size: 12px !important;
        font-weight: bold;
        font-family: Times New Roman !important;
    }

    button {
        border-radius: 0 !important;
    }

</style>

<body>
<br>
<div class="container" style="width: 821px;margin: 0 auto;">
    <div class="col-sm-12 col-xs-12 text-right">
        <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
            <i class="fa fa-print"></i> <?= lang('print'); ?>
        </button>
    </div>
    <div class="col-sm-12 col-xs-12" style="width: 794px;">

        <div class="row" style="margin-top: 20px;">

            <div class="col-sm-3 col-xs-3">

            </div>

            <div class="col-sm-6 col-xs-6 company_addr" style="margin-top:15px !important;">
                <center>
                    <h4 style="font-family: Khmer OS Muol Light !important;">វិក្កយបត្រ</h4>
                    <h4 style="margin-top:-10px !important;">INVOICE</h4>
                </center>
            </div>
            <div class="col-sm-3 col-xs-3 text-right" style="font-size: 18px;line-height: 20px !important;">
                <p><b>011 781 552</b></p>
                <p><b>015 213 677</b></p>
                <p><b>023 425 667</b></p>
            </div>
        </div>
        <br>
        <?php //$this->erp->print_arrays($customer); ?>
        <div class="row">
            <div class="col-sm-7 col-xs-7" style="margin-top: -20px !important">
                <table style="font-size: 12px !important;">

                    <tr>
                        <td style="width: 50%">ឈ្មោះអតិថិជន <br>Customer Name</td>
                        <td>&nbsp; :</td>
                        <td>&nbsp;<?= $customer->name_kh;?></td>
                        <!--<?php if(!empty($customer->name_kh)) { ?>
							<td>&nbsp;<?= $customer->name_kh;?></td>
							<?php }else { ?>
							<td>&nbsp;<?= $customer->name; ?></td>
							<?php } ?>-->
                    </tr>

                    <tr>
                        <td>ទូរស័ព្ទលេខ <br>Tel</td>
                        <td>&nbsp; :</td>
                        <td>&nbsp;<?= $customer->phone ?></td>
                    </tr>

                    <tr>
                        <td>អាសយដ្ឋាន <br>Address</td>
                        <td>:</td>
                        <?php if(!empty($customer->address_kh)) { ?>
                            <td>&nbsp;<?= $customer->address_kh?></td>
                        <?php }else { ?>
                            <td>&nbsp;<?= $customer->address ?></td>
                        <?php } ?>
                    </tr>



                </table>
            </div>
            <div class="col-sm-5 col-xs-5" style="margin-top: -20px !important">
                <table style="font-size: 12px !important;">
                    <tr>
                        <td>លេខរៀងវិក្កយបត្រ <br>Invoice No</td>
                        <td>&nbsp; : &nbsp; </td>
                        <td><span style="font-size: 12px; "><?= $invs->reference_no ?></span></td>
                    </tr>
                    <tr>
                        <td>កាលបរិច្ឆេទ <br>Date</td>
                        <td>&nbsp; : &nbsp; </td>
                        <td><?= $this->erp->hrld($invs->date); ?></td>
                    </tr>
                    <tr>
                        <td>អ្នកលក់ <br>Sale Rep</td>
                        <td>&nbsp; : &nbsp; </td>
                        <td><?= $user->username; ?></td>
                    </tr>
                </table>
            </div>
        </div>


        <?php
        $cols = 6;
        if ($discount != 0) {
            $cols = 7;
        }
        ?>
        <?php //$this->erp->print_arrays($invs); ?>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <table class="table table-bordered" style="margin-top: 10px;">
                    <tbody style="font-size: 14px;">
                    <tr class="thead" style="">
                        <th>ល.រ<br /><span style="font-size: 12px;"><?= strtoupper(lang('no')) ?></span></th>
                        <th>បរិយាយមុខទំនិញ<br /><span style="font-size: 12px;"><?= strtoupper(lang('description')) ?></span></th>
                        <th>បរិមាណ<br /><span style="font-size: 12px;"><?= strtoupper(lang('Quantity')) ?></span></th>
                        <th>ថ្លៃឯកតា<br /><span style="font-size: 12px;"><?= strtoupper(lang('unit_price')) ?></span></th>
                        <th>ថ្លៃទំនិញ<br /><span style="font-size: 12px;"><?= strtoupper(lang('amount')) ?></span></th>
                    </tr>
                    <?php
                    $no = 1;
                    $erow = 1;
                    foreach ($rows as $row) {
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
                        <tr style="font-size: 12px !important;">
                            <td style="border-bottom: 1px solid #FFF !important;vertical-align: middle; text-align: center;font-family: 'Khmer OS' !important;"><?php echo $no ?></td>

                            <td style="border-bottom: 1px solid #FFF !important;vertical-align: middle;">
                                <?=$row->product_name;?>
                            </td>
                            <td style="border-bottom: 1px solid #FFF !important;vertical-align: middle; text-align: center">
                                <?= $this->erp->formatQuantity($row->quantity);?>
                            </td>
                            <td style="border-bottom: 1px solid #FFF !important;vertical-align: middle; text-align: right">
                                <?= $row->real_unit_price != 0 ? $this->erp->formatMoney($row->real_unit_price) : 'Free' ?>
                            </td>

                            <td style="border-bottom: 1px solid #FFF !important;vertical-align: middle; text-align: right">
                                <?= $row->subtotal != 0 ? $this->erp->formatMoney($row->subtotal) : 'Free' ?>
                            </td>
                        </tr>


                        <?php
                        $no++;
                        $erow++;
                    }
                    ?>

                    <?php
                    if($erow < 11){
                        $k=10 - $erow;
                        for($j = 1; $j <= $k; $j++){
                            if($Settings->product_discount) {
                                echo  '<tr>
													<td style="border-bottom: 1px solid #FFF !important;" height="30px" class="text-center"></td>
													<td style="border-bottom: 1px solid #FFF !important;"></td>
													<td style="border-bottom: 1px solid #FFF !important;"></td>
													<td style="border-bottom: 1px solid #FFF !important;"></td>
													<td style="border-bottom: 1px solid #FFF !important;"></td>
												</tr>';
                            }else {
                                echo  '<tr>
													<td height="30px" class="text-center"></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>';
                            }
                            $no++;
                        }
                        echo  '<tr>
                                                <td style="border-top: 1px solid #FFF !important;" height="30px" class="text-center"></td>
                                                <td style="border-top: 1px solid #FFF !important;"></td>
                                                <td style="border-top: 1px solid #FFF !important;"></td>
                                                <td style="border-top: 1px solid #FFF !important;"></td>
                                                <td style="border-top: 1px solid #FFF !important;"></td>
                                            </tr>';
                    }else{
                        echo  ' <tr>
                                                <td style="border-top: 1px solid #FFF !important;vertical-align: middle; text-align: center"></td>
                
                                                <td style="border-top: 1px solid #FFF !important;vertical-align: middle;">
                
                                                </td>
                                                <td style="border-top: 1px solid #FFF !important;vertical-align: middle; text-align: center">
                
                                                </td>
                                                <td style="border-top: 1px solid #FFF !important;vertical-align: middle; text-align: right">
                
                                                </td>
                
                                                <td style="border-top: 1px solid #FFF !important;vertical-align: middle; text-align: right">
                
                                                </td>
                                            </tr>';
                    }
                    ?>
                    <?php
                    $row = 4;
                    $col =2;
                    if ($discount != 0) {
                        $col = 3;
                    }

                    if ($invs->order_discount != 0) {
                        $row++;
                        $col =2;
                    }
                    if ($invs->shipping != 0) {
                        $row++;
                        $col =2;
                    }
                    if ($invs->order_tax != 0) {
                        $row++;
                        $col =2;
                    }


                    ?>

                    <!--<?php if ($invs->grand_total != $invs->total) { ?>
							<tr>
								<td rowspan = "<?= $row; ?>" colspan="3" style="border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;">
									<?php if (!empty($invs->invoice_footer)) { ?>
									<p style="font-size:14px !important;"><strong><u>Note:</u></strong></p>
										<p><?= nl2br($invs->invoice_footer); ?></p>
									<?php } ?>
								</td>
								<td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">សរុប​ / <?= strtoupper(lang('total')) ?>
									(<?= $default_currency->code; ?>)
								</td>
								<td align="right">$<?=$this->erp->formatMoney($invs->total); ?></td>
							</tr>
							<?php } ?>

							<?php if ($invs->order_discount != 0) : ?>
							<tr>
								<td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">បញ្ចុះតម្លៃលើការបញ្ជាទិញ / <?= strtoupper(lang('order_discount')) ?></td>
								<td align="right">$<?php echo $this->erp->formatQuantity($invs->order_discount).' $'; ?></td>
							</tr>
							<?php endif; ?>

							<?php if ($invs->shipping != 0) : ?>
							<tr>
								<td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">ដឹកជញ្ជូន / <?= strtoupper(lang('shipping')) ?></td>
								<td align="right">$<?php echo $this->erp->formatQuantity($invs->shipping); ?></td>
							</tr>
							<?php endif; ?>

							<?php if ($invs->order_tax != 0) : ?>
							<tr>
								<td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">ពន្ធអាករ / <?= strtoupper(lang('order_tax')) ?></td>
								<td align="right">$<?= $this->erp->formatQuantity($invs->order_tax); ?></td>
							</tr>
							<?php endif; ?>-->




                    <tr style="font-size: 12px !important;">
                        <td rowspan = "<?= $row; ?>" colspan="2" style="border-left: 1px solid #FFF !important; border-bottom: 1px solid #FFF !important;border-right: 1px solid #FFF !important;">
                            <?php if (!empty($invs->invoice_footer)) { ?>
                                <p><?= nl2br($invs->invoice_footer); ?></p>
                            <?php } ?>
                        </td>
                        <td colspan="<?= $col; ?>" style="border-bottom: 1px solid #FFF !important;text-align: right; font-weight: bold;">សរុប​ <br> <?= strtoupper(lang('Sub Total')) ?>

                        </td>
                        <td align="right"><?=$this->erp->formatMoney($invs->total); ?></td>
                    </tr>
                    <?php if ($invs->order_discount != 0) : ?>
                        <tr style="font-size: 12px !important;">
                            <td colspan="<?= $col; ?>" style="border-bottom: 1px solid #FFF !important;text-align: right; font-weight: bold;">បញ្ចុះតម្លៃ/ Discount</td>
                            <td align="right">(<?= $this->erp->formatQuantity($invs->order_discount_id); ?>%) <?= $this->erp->formatMoney($invs->order_discount); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($invs->order_tax != 0) : ?>
                        <tr style="font-size: 12px !important;">
                            <td colspan="<?= $col; ?>" style="border-bottom: 1px solid #FFF !important;text-align: right; font-weight: bold;">អតប ១០% / VAT 10%</td>
                            <td align="right"><?= $this->erp->formatMoney($invs->order_tax); ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr style="font-size: 12px !important;">

                        <td colspan="<?= $col; ?>" style="border-bottom: 1px solid #FFF !important;text-align: right; font-weight: bold;">សរុប <br>Grand Total

                        </td>
                        <td align="right"><?= $this->erp->formatMoney($invs->grand_total); ?></td>
                    </tr>






                    <!--<?php if($invs->paid != 0 || $invs->deposit != 0){ ?>
							<?php if($invs->deposit != 0) { ?>
							<tr>
								<td colspan="2" style="text-align: right; font-weight: bold;">បានកក់ / <?= strtoupper(lang('deposit')) ?>
									(<?= $default_currency->code; ?>)
								</td>
								<td align="right"><?php echo $this->erp->formatMoney($invs->deposit); ?></td>
							</tr>
							<?php } ?>
							<?php if($invs->paid != 0) { ?>
							<tr>
								<td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">បានបង់ / <?= strtoupper(lang('paid')) ?>
									(<?= $default_currency->code; ?>)
								</td>
								<td align="right"><?php echo $this->erp->formatMoney($invs->paid-$invs->deposit); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="<?= $col; ?>" style="text-align: right; font-weight: bold;">នៅខ្វះ / <?= strtoupper(lang('balance')) ?>
									(<?= $default_currency->code; ?>)
								</td>
								<td align="right"><?= $this->erp->formatMoney($invs->grand_total - (($invs->paid-$invs->deposit) + $invs->deposit)); ?></td>
							</tr>
						<?php } ?>-->

                    </tbody>

                </table>
            </div>
        </div>

        <?php if($invs->note){ ?>
            <div style="border-radius: 5px 5px 5px 5px;border:1px solid black;font-size: 10px !important;margin-top: 10px !important;margin-bottom: 20px !important;height: auto;" id="note" id="note" class="col-md-12 col-xs-12">
                <p style="margin-top:10px;"><strong><?php echo strip_tags($invs->note); ?></strong></p>
            </div>
        <?php } ?>
    </div>
    <div id="footer"  class="row" style="font-size: 12px !important;">

        <div class="col-sm-2 col-xs-2">

            <center>
                <p>ហត្ថលេខាគណនេយ្យ</p>
                <p style="margin-top:-12px;">ACCOUNTANT</p>
            </center>
        </div>
        <div class="col-sm-3 col-xs-3">

            <center>
                <p>ហត្ថលេខាប្រធានឃ្លាំង</p>
                <p style="margin-top:-10px;">STOCK CONTROLLER</p>
            </center>
        </div>
        <div class="col-sm-2 col-xs-2">

            <center>
                <p>ហត្ថលេខាអ្នកពិនិត្យ</p>
                <p style="margin-top:-10px;">CHECKED BY</p>
            </center>
        </div>
        <div class="col-sm-2 col-xs-2">

            <center>
                <p>ហត្ថលេខាអ្នកប្រគល់</p>
                <p style="margin-top:-10px;">DELIVERED BY</p>
            </center>
        </div>
        <div class="col-sm-3 col-xs-3">

            <center>
                <p>ហត្ថលេខាអតិថិជន</p>
                <p style="margin-top:-10px;">CUSTOMER'S SIGNATURE</p>
            </center>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<div style="width: 821px;margin: 0 auto;">
    <a class="btn btn-warning no-print" href="<?= site_url('sales'); ?>" style="border-radius: 0">
        <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("back"); ?>
    </a>
    <a class="btn btn-primary no-print" href="<?= site_url('sales/add'); ?>" style="border-radius: 0">
        <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("Back To Add Sale"); ?>
    </a>
    <a class="btn btn-success no-print" href="<?= site_url("sales/invoice_kg_no_tax/". $invs->id); ?>" style="border-radius: 0">
        <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("Back To No Tax Invoice"); ?>
    </a>
    <a class="btn btn-info no-print" href="<?= site_url('sales/invoice_kg_tax/' . $invs->id) ?>" style="border-radius: 0">
        <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("Back To Tax Invoice"); ?>
    </a>
</div>
<br>
<br>
</body>
</html>