<?php //$this->erp->print_arrays($quote_items);?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("invoice_purchase_request") . " " . $inv->reference_no; ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <style type="text/css">
        html, body {
            height: 100%;
            background: #FFF;
        }

        body:before, body:after {
            display: none !important;
        }

        .table th {
            text-align: center;
            padding: 5px;
        }

        .table td {
            padding: 4px;
        }
		hr{
			border-color: #333;
			width:100px;
			margin-top: 70px;
		}
        @media print,screen{
            body {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="print_rec" id="wrap" style="width: 90%; margin: 0 auto;">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) { ?>
				<div class="col-xs-3 text-center" style="margin-bottom:20px;">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                         alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
                <div class="col-xs-6 text-center">
                    <h1><?= $billers->company;?></h1>
                    <p><?= $billers->address ?></p>
                    <p><?= lang("tell"); ?> : <?= $billers->phone?>,<?= lang("email"); ?>: <?= $billers->email?></p>
                </div>
                <div class="col-xs-3">
                    
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            <br>
            <div class="row padding10">
                <div class="col-xs-5" style="float: left;font-size:14px">
                    <h4><b><?= lang("request_by"); ?></b></h4>
                    <table>
                        <tr>
                            <td>
                                <p><?= lang("name");?></p>
                            </td>
                            <td>
                               <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$inv->supplier."</b>"?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("address");?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$supplier->address."</b>" ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("phone");?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$supplier->phone."</b>" ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("email");?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$supplier->email."</b>" ?></p>
                            </td>
                        </tr>
                    </table>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-2">
                    
                </div>
                <div class="col-xs-5"  style="float: right;font-size:14px">
                    <h4><b><?= lang("reference");?></b></h4>
                    <table>
                        <tr>
                            <td>
                                <p><?= lang("pr_no"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$warehouse->reference_no."</b>";?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("pr_date"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$warehouse->date."</b>";?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("delivery"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$warehouse->name."</b>";?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row padding10" style="display:none">
                <div class="col-xs-6" style="float: left;">
                    <span class="bold"><?= $Settings->site_name; ?></span><br>
                    <?= $warehouse->name ?>

                    <?php
                    echo $warehouse->address . "<br>";
                    echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone . "<br>" : '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5" style="float: right;">
                    <div class="bold">
                        <?= lang("date"); ?>: <?= $this->erp->hrld($inv->date); ?><br>
                        <?= lang("ref"); ?>: <?= $inv->reference_no; ?>
                        <div class="clearfix"></div>
                        <?php $this->erp->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 1); ?>
                        <img src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
                             alt="<?= $inv->reference_no ?>" class="pull-right"/>
                        <?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 50, false); ?>
                        <img src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                             alt="<?= $inv->reference_no ?>" class="pull-left"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="clearfix"></div>
			<div><br/></div>
            <div class="-table-responsive">
                <table class="table table-bordered table-hover table-striped" style="width: 100%;">
                    <thead  style="font-size: 13px;">
						<tr>
							<th><?= lang("no"); ?></th>
                            <th><?= lang("description"); ?></th> 
                            <th><?= lang("quantity"); ?></th>
                            <?php
                                if ($inv->status == 'partial') {
                                    echo '<th>'.lang("received").'</th>';
                                }
                            ?> 
                            <?php if($Owner || $Admin || $GP['purchases-cost']) {?>
                                <th><?= lang("unit_cost"); ?></th>
                            <?php } ?>
                            
                            <?php
                            if ($Settings->tax1) {
                                echo '<th>' . lang("tax") . '</th>';
                            }
                            if ($Settings->product_discount) {
                                echo '<th>' . lang("discount") . '</th>';
                            }
                            ?>
                            <th><?= lang("subtotal"); ?></th>
						</tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        <?php $r = 1;
                        $tax_summary = array();
                        foreach ($rows as $row):
                        ?>
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?= $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                    <?= $row->details ? '<br>' . $row->details : ''; ?>
                                    <?= ($row->expiry && $row->expiry != '0000-00-00') ? '<br>' . $this->erp->hrsd($row->expiry) : ''; ?>
                                </td> 
                                <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->erp->formatQuantity($row->quantity); ?></td>
                                <?php
                                if ($inv->status == 'partial') {
                                    echo '<td style="text-align:center;vertical-align:middle;width:80px;">'.$this->erp->formatQuantity($row->quantity_received).'</td>';
                                }
                                ?>
                                <?php if($Owner || $Admin || $GP['purchases-cost']) {?>
                                    <td style="text-align:right; width:100px;"><?= $this->erp->formatMoneyPurchase($row->unit_cost); ?></td>
                                <?php } ?>
                                <?php
                                if ($Settings->tax1) {
                                    echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->erp->formatMoney($row->item_tax) . '</td>';
                                }
                                if ($Settings->product_discount) {
                                    echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->erp->formatMoney($row->item_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px;"><?= $this->erp->formatMoneyPurchase($row->subtotal); ?></td>
                            </tr>
                            <?php
                            $r++;
                        endforeach;
                        ?>
                    </tbody>
                    <tfoot style="font-size: 13px;">
                    <?php
                        $col = 3;
                        if($Owner || $Admin || $GP['purchases-cost']){
                            $col++;
                        }
                        if ($inv->status == 'partial') {
                            $col++;
                        }
                        if ($Settings->product_discount) {
                            $col++;
                        }
                        if ($Settings->tax1) {
                            $col++;
                        }
                        if ($Settings->product_discount && $Settings->tax1) {
                            $tcol = $col - 2;
                        } elseif ($Settings->product_discount) {
                            $tcol = $col - 1;
                        } elseif ($Settings->tax1) {
                            $tcol = $col - 1;
                        } else {
                            $tcol = $col;
                        }
                        ?>
                        <?php if ($inv->grand_total != $inv->total) { ?>
                            <tr>
                                <td colspan="<?= $tcol; ?>"
                                    style="text-align:right; padding-right:10px;"><?= lang("total"); ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <?php
                                if ($Settings->tax1) {
                                    echo '<td style="text-align:right;">' . $this->erp->formatMoneyPurchase($inv->product_tax) . '</td>';
                                }
                                if ($Settings->product_discount) {
                                    echo '<td style="text-align:right;">' . $this->erp->formatMoneyPurchase($inv->product_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; padding-right:10px;"><?= $this->erp->formatMoneyPurchase($inv->total + $inv->product_tax); ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($inv->order_discount != 0) {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoneyPurchase($inv->order_discount) . '</td></tr>';
                        }
                        ?>
                        <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoneyPurchase($inv->order_tax) . '</td></tr>';
                        }
                        ?>
                        <?php if ($inv->shipping != 0) {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->erp->formatMoneyPurchase($inv->shipping) . '</td></tr>';
                        }
                        ?>
                        <tr>
                             <td colspan="5">
                            <div >
                            <?php if ($inv->note || $inv->note != "") { ?>
                                <div>
                                    <p style="text-align:left; font-weight:bold;"><?= lang("note"); ?>:<?= $this->erp->decode_html($inv->note); ?></p>
                            <?php } ?>
                            </div>
                        </td>
                            <td style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->erp->formatMoneyPurchase($inv->grand_total); ?></td>
                        </tr>

                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-lg-2 col-xs-4 pull-left">
                        <p class="bold"><?= lang("request_by"); ?></p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                        <p><?= lang("name"); ?> :  ...................................</p>
                        <p><?= lang("date"); ?> :  ......../........./.................</p>
                    </div>
                    <div class="col-lg-8"> 
                    </div>
                    <div class="col-lg-2 col-xs-4 pull-right">
                        <p class="bold"><?= lang("approve_by"); ?></p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                        <p><?= lang("name"); ?> :  ...................................</p>
                        <p><?= lang("date"); ?> :  ......../........./.................</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="mydiv" style="display:none;">

<div id="wrap" style="width: 90%; margin: 0 auto;">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) { ?>
                <div class="text-center" style="margin-bottom:20px; text-align: center;">
                    <!--<img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>" alt="<?= $Settings->site_name; ?>">-->
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                         alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5" style="float: left;">
                    <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                    <?= $biller->company ? "" : "Attn: " . $biller->name ?>
                    <?php
                    echo $biller->address . "<br />" . $biller->city . " " . $biller->postal_code . " " . $biller->state . "<br />" . $biller->country;
                    echo "<p>";
                    if ($biller->cf1 != "-" && $biller->cf1 != "") {
                        echo "<br>" . lang("bcf1") . ": " . $biller->cf1;
                    }
                    if ($biller->cf2 != "-" && $biller->cf2 != "") {
                        echo "<br>" . lang("bcf2") . ": " . $biller->cf2;
                    }
                    if ($biller->cf3 != "-" && $biller->cf3 != "") {
                        echo "<br>" . lang("bcf3") . ": " . $biller->cf3;
                    }
                    if ($biller->cf4 != "-" && $biller->cf4 != "") {
                        echo "<br>" . lang("bcf4") . ": " . $biller->cf4;
                    }
                    if ($biller->cf5 != "-" && $biller->cf5 != "") {
                        echo "<br>" . lang("bcf5") . ": " . $biller->cf5;
                    }
                    if ($biller->cf6 != "-" && $biller->cf6 != "") {
                        echo "<br>" . lang("bcf6") . ": " . $biller->cf6;
                    }
                    echo "</p>";
                    echo lang("tel") . ": " . $biller->phone . "<br />" . lang("email") . ": " . $biller->email;
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5"  style="float: right;">
                    <h2 class=""><?= $customer->company ? $customer->company : $customer->name; ?></h2>
                    <?= $customer->company ? "" : "Attn: " . $customer->name ?>
                    <?php
                    echo $customer->address . "<br />" . $customer->city . " " . $customer->postal_code . " " . $customer->state . "<br />" . $customer->country;
                    echo "<p>";
                    if ($customer->cf1 != "-" && $customer->cf1 != "") {
                        echo "<br>" . lang("ccf1") . ": " . $customer->cf1;
                    }
                    if ($customer->cf2 != "-" && $customer->cf2 != "") {
                        echo "<br>" . lang("ccf2") . ": " . $customer->cf2;
                    }
                    if ($customer->cf3 != "-" && $customer->cf3 != "") {
                        echo "<br>" . lang("ccf3") . ": " . $customer->cf3;
                    }
                    if ($customer->cf4 != "-" && $customer->cf4 != "") {
                        echo "<br>" . lang("ccf4") . ": " . $customer->cf4;
                    }
                    if ($customer->cf5 != "-" && $customer->cf5 != "") {
                        echo "<br>" . lang("ccf5") . ": " . $customer->cf5;
                    }
                    if ($customer->cf6 != "-" && $customer->cf6 != "") {
                        echo "<br>" . lang("ccf6") . ": " . $customer->cf6;
                    }
                    echo "</p>";
                    echo lang("tel") . ": " . $customer->phone . "<br />" . lang("email") . ": " . $customer->email;
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5" style="float: left;">
                    <span class="bold"><?= $Settings->site_name; ?></span><br>
                    <?= $warehouse->name ?>

                    <?php
                    echo $warehouse->address . "<br>";
                    echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone . "<br>" : '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5" style="float: right;">
                    <div class="bold">
                        <?= lang("date"); ?>: <?= $this->erp->hrld($inv->date); ?><br>
                        <?= lang("ref"); ?>: <?= $inv->reference_no; ?>
                        <div class="clearfix"></div>
                        <?php $this->erp->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 1); ?>
                        <img src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
                             alt="<?= $inv->reference_no ?>" class="pull-right"/>
                        <?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 50, false); ?>
                        <img src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                             alt="<?= $inv->reference_no ?>" class="pull-left"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="-table-responsive">
                <table class="table table-bordered table-hover table-striped" style="width: 100%;">
                    <thead  style="font-size: 13px;">
                    <tr>
                        <th><?= lang("no"); ?></th>
                        <th><?= lang("description"); ?> (<?= lang("code"); ?>)</th>
                        <th><?= lang("quantity"); ?></th>
                        <?php
                        if ($Settings->product_serial) {
                            echo '<th style="text-align:center; vertical-align:middle;">' . lang("serial_no") . '</th>';
                        }
                        ?>
                        <th><?= lang("unit_price"); ?></th>
                        <?php
                        if ($Settings->tax1) {
                            echo '<th>' . lang("tax") . '</th>';
                        }
                        if ($Settings->product_discount) {
                            echo '<th>' . lang("discount") . '</th>';
                        }
                        ?>
                        <th><?= lang("subtotal"); ?></th>
                    </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                    <?php $r = 1;
                    foreach ($rows as $row):
                        ?>
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                            <td style="vertical-align:middle;"><?= $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?>
                            </td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->erp->formatQuantity($row->quantity); ?></td>
                            <?php
                            if ($Settings->product_serial) {
                                echo '<td>' . $row->serial_no . '</td>';
                            }
                            ?>
                            <td style="text-align:right; width:90px;"><?= $this->erp->formatMoney($row->real_unit_price); ?></td>
                            <?php
                            if ($Settings->tax1) {
                                echo '<td style="width: 90px; text-align:right; vertical-align:middle;">' . ($row->taxs != 0 && $row->taxs ? '<small>(' . $row->taxs . ')</small> ' : '') . $this->erp->formatMoney($row->item_tax) . '</td>';
                            }
                            if ($Settings->product_discount) {
                                echo '<td style="width: 90px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->erp->formatMoney($row->item_discount) . '</td>';
                            }
                            ?>
                            <td style="vertical-align:middle; text-align:right; width:110px;"><?= $this->erp->formatMoney($row->subtotal);
                                ?></td>
                        </tr>
                        <?php
                        $r++;
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot style="font-size: 13px;">
                    <?php
                    $col = 4;
                    if ($Settings->product_serial) {
                        $col++;
                    }
                    if ($Settings->product_discount) {
                        $col++;
                    }
                    if ($Settings->tax1) {
                        $col++;
                    }
                    if ($Settings->product_discount && $Settings->tax1) {
                        $tcol = $col - 2;
                    } elseif ($Settings->product_discount) {
                        $tcol = $col - 1;
                    } elseif ($Settings->tax1) {
                        $tcol = $col - 1;
                    } else {
                        $tcol = $col;
                    }
                    ?>
                    <?php if ($inv->grand_total != $inv->total) { ?>
                        <tr>
                            <td colspan="<?= $tcol; ?>" style="text-align:right;"><?= lang("total"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <?php
                            if ($Settings->tax1) {
                                echo '<td style="text-align:right;">' . $this->erp->formatMoney($inv->product_tax) . '</td>';
                            }
                            if ($Settings->product_discount) {
                                echo '<td style="text-align:right;">' . $this->erp->formatMoney($inv->product_discount) . '</td>';
                            }
                            ?>
                            <td style="text-align:right;"><?= $this->erp->formatMoney($inv->total + $inv->product_tax); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($return_sale && $return_sale->surcharge != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("surcharge") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($return_sale->surcharge) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->order_discount != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->order_discount) . '</td></tr>';
                    }
                    ?>
					<?php if ($inv->shipping != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->shipping) . '</td></tr>';
                    }
                    ?>
                    <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->order_tax) . '</td></tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="<?= $col; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->grand_total); ?></td>
                    </tr>

                    <tr>
                        <td colspan="<?= $col; ?>" style="text-align:right; font-weight:bold;"><?= lang("paid"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->paid); ?></td>
                    </tr>
                    <tr>
                        <td colspan="<?= $col; ?>" style="text-align:right; font-weight:bold;"><?= lang("balance"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->grand_total - $inv->paid); ?></td>
                    </tr>

                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php
                    if ($inv->note || $inv->note != "") { ?>
                        <div class="well well-sm">
                            <p class="bold"><?= lang("note"); ?>:</p>
                            <div><?= $this->erp->decode_html($inv->note); ?></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-4  pull-left" style="float: left;">
                    <p style="height: 80px;"><?= lang("request_by"); ?>
                        : <?= $biller->company != '-' ? $biller->company : $biller->name; ?> </p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
                <div class="col-xs-4  pull-right" style="float: right;">
                    <p style="height: 80px;"><?= lang("approve_by"); ?>
                        : <?= $customer->company ? $customer->company : $customer->name; ?> </p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<br/><br/>

<div></div>
<!--<div style="margin-bottom:50px;">
	<div class="col-xs-4" id="hide" >
		<a href="<?= site_url('sales'); ?>"><button class="btn btn-warning " ><?= lang("Back to AddSale"); ?></button></a>&nbsp;&nbsp;&nbsp;
		<button class="btn btn-primary" id="print_receipt"><?= lang("Print"); ?>&nbsp;<i class="fa fa-print"></i></button>
	</div>
</div>-->
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', '#b-add-quote' ,function(event){
    event.preventDefault();
    localStorage.removeItem('slitems');
    window.location.href = "<?= site_url('purchases_request/add'); ?>";
  });
  $(document).on('click', '#b-view-pr' ,function(event){
    event.preventDefault();
    localStorage.removeItem('slitems');
    window.location.href = "<?= site_url('purchases_request/index'); ?>";
  });
});

</script>
</body>
</html>
