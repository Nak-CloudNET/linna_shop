<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("purchase") . " " . $inv->reference_no; ?></title>
    <link href="<?php echo $assets ?>styles/style.css" rel="stylesheet">
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
    </style>
</head>

<body>
<div id="wrap">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) {?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?=base_url() . 'assets/uploads/logos/' . $Settings->logo;?>"
                         alt="<?=$Settings->site_name;?>">
                </div>
            <?php }
            ?>
            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-xs-4">
                        <?=lang("date");?>: <?=$this->erp->hrld($inv->date);?>
                        <br><?=lang("ref");?>: <?=$inv->reference_no;?><br>
                        <?= lang("status"); ?>:
                        <?php if ($inv->status == 'received') { ?>
                            <span class="label label-success" ><?= lang($inv->status); ?></span>
                        <?php } else { ?>
                            <span class="label label-warning" ><?= lang($inv->status); ?></span>
                        <?php } ?>
                        <br>

                        <?= lang("payment_status"); ?>:
                        <?php if ($inv->payment_status == 'paid') { ?>
                            <span class="label label-success" ><?= lang($inv->payment_status); ?></span>
                        <?php } elseif ($inv->payment_status == 'partial') { ?>
                            <span class="label label-info" ><?= lang($inv->payment_status); ?></span>
                        <?php } else { ?>
                            <span class="label label-danger" ><?= lang($inv->payment_status); ?></span>
                        <?php } ?>
                    </div>
                    <div class="col-xs-7 pull-right text-right">
                        <?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 35, false, $inv->id);?>
                        <img src="<?=base_url()?>assets/uploads/barcode<?=$this->session->userdata('user_id') . $inv->id;?>.png"
                             alt="<?=$inv->reference_no?>"/>
                        <?php $this->erp->qrcode('link', urlencode(site_url('purchases/view/' . $inv->id)), 1, false, $inv->id);?>
                        <img src="<?=base_url()?>assets/uploads/qrcode<?=$this->session->userdata('user_id') . $inv->id;?>.png"
                             alt="<?=$inv->reference_no?>"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5">
                    <?php echo $this->lang->line("from"); ?>:
                    <h2 class=""><?=$supplier->company ? $supplier->company : $supplier->name;?></h2>
                    <?=$supplier->company ? "" : "Attn: " . $supplier->name?>
                    <?php
                        echo $supplier->address . "<br />" . $supplier->city . " " . $supplier->postal_code . " " . $supplier->state . "<br />" . $supplier->country;
                        
                        echo lang("tel") . ": " . $supplier->phone . "<br />" . lang("email") . ": " . $supplier->email;
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5 col-xs-offset-1">
                    <?php echo $this->lang->line("to"); ?>:
                    <h2 class=""><?=$Settings->site_name;?></h2>
                    <?=$warehouse->name?>
                    <?php
                        echo $warehouse->address . "<br>";
                        echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone . "<br>" : '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <p>&nbsp;</p>

            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr class="active">
                        <th><?=lang("no");?></th>
                        <th><?=lang("description");?> (<?=lang("code");?>)</th>
                        <th><?=lang("quantity");?></th>
                        <?php
                            if ($inv->status == 'partial') {
                                echo '<th>'.lang("received").'</th>';
                            }
                        ?>
                        <th><?=lang("unit_cost");?></th>
                        <?php
                            if ($Settings->tax1) {
                                echo '<th>' . lang("tax") . '</th>';
                            }
                        ?>
                        <!--<?php
                            if ($row->item_discount != 0) {
                                echo '<th>' . lang("discount") . '</th>';
                            }
                        ?>-->
                        <th><?=lang("subtotal");?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $r = 1;
                        foreach ($rows as $row):
                            ?>
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?=$r;?></td>
                                <td style="vertical-align:middle;"><?=$row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : '');?>
                                    <?=$row->details ? '<br>' . $row->details : '';?>
                                    <?= ($row->expiry && $row->expiry != '0000-00-00') ? '<br>' . $this->erp->hrsd($row->expiry) : ''; ?>
                                </td>
                                <td style="width: 80px; text-align:center; vertical-align:middle;"><?=$this->erp->formatQuantity($row->quantity);?></td>
                                <?php
                                    if ($inv->status == 'partial') {
                                        echo '<td style="text-align:center;vertical-align:middle;width:120px;">'.$this->erp->formatQuantity($row->quantity_received).'</td>';
                                    }
                                ?>
                                <td style="text-align:right; width:100px;"><?=$this->erp->formatMoneyPurchase($row->net_unit_cost);?></td>
                                <?php
                                    if ($Settings->tax1) {
                                        echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small> ' : '') . $this->erp->formatMoney($row->item_tax) . '</td>';
                                    }
                                ?>
                                <?php
                                    /*if ($Settings->product_discount != 0) {
                                    echo '<td style="width: 80px; text-align:right; vertical-align:middle;"><small>(' . $row->discount . ')</small> ' . $row->item_discount . '</td>';
                                }*/
                                ?>
                                <td style="text-align:right; width:120px;"><?=$this->erp->formatMoney($row->subtotal);?></td>
                            </tr>
                            <?php
                            $r++;
                        endforeach;
                    ?>
                    </tbody>
                    <tfoot>
                    <?php
                        $col = 4;
                        //if ($Settings->product_discount) { $col++; }
                        if ($inv->status == 'partial') {
                            $col++;
                        }
                        if ($Settings->tax1) {
                            $col++;
                        }
                        //if ($Settings->product_discount && $Settings->tax1) { $tcol = $col-2; }
                        //elseif($Settings->product_discount) { $tcol = $col-1; }
                        if ($Settings->tax1) {
                            $tcol = $col - 1;
                        } else {
                            $tcol = $col;
                        }
                    ?>

                    <tr>
                        <td colspan="<?=$tcol;?>" style="text-align:right;"><?=lang("total");?>
                            (<?=$default_currency->code;?>)
                        </td>
                        <?php
                            if ($Settings->tax1) {
                                echo '<td style="text-align:right;">' . $this->erp->formatMoney($inv->product_tax) . '</td>';
                            }
                            /*if ($Settings->product_discount) {
                            echo '<td style="text-align:right;">'.$this->erp->formatMoney($inv->product_discount).'</td>';
                        } */
                        ?>
                        <td style="text-align:right;"><?=$this->erp->formatMoney($inv->total + $inv->product_tax);?></td>
                    </tr>
                    <?php
                        if ($inv->order_discount != 0) {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->order_discount) . '</td></tr>';
                        }
                        if ($Settings->tax2 && $inv->order_tax != 0) {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->order_tax) . '</td></tr>';
                        }
                        if ($inv->shipping != 0) {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->shipping) . '</td></tr>';
                        }
                    ?>
                    <tr>
                        <td colspan="<?=$col;?>"
                            style="text-align:right; font-weight:bold;"><?=lang("total_amount");?>
                            (<?=$default_currency->code;?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?=$this->erp->formatMoney($inv->grand_total);?></td>
                    </tr>
                    <tr>
                        <td colspan="<?=$col;?>" style="text-align:right; font-weight:bold;"><?=lang("paid");?>
                            (<?=$default_currency->code;?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?=$this->erp->formatMoney($inv->paid);?></td>
                    </tr>
                    <tr>
                        <td colspan="<?=$col;?>" style="text-align:right; font-weight:bold;"><?=lang("balance");?>
                            (<?=$default_currency->code;?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?=$this->erp->formatMoney($inv->grand_total - $inv->paid);?></td>
                    </tr>

                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-4" style="text-align:center">
                        <hr/>
                        <p><?= lang("seller"); ?>
                    </div>
                    <div class="col-xs-4 col-xs-offset-3" style="text-align:center">
                        <hr/>
                        <p><?= lang("Ware House"); ?>
                    </div>
                </div>
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

                <div class="col-xs-5 pull-right no-print">
                    <div class="well well-sm">
                        <p>
                            <?= lang("created_by"); ?>: <?= $created_by->first_name . ' ' . $created_by->last_name; ?> <br>
                            <?= lang("date"); ?>: <?= $this->erp->hrld($inv->date); ?>
                        </p>
                        <?php if ($inv->updated_by) { ?>
                        <p>
                            <?= lang("updated_by"); ?>: <?= $updated_by->first_name . ' ' . $updated_by->last_name;; ?><br>
                            <?= lang("update_at"); ?>: <?= $this->erp->hrld($inv->updated_at); ?>
                        </p>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>