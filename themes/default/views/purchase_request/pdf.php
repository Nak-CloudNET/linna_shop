<?php if ($logo) { ?>
    <div class="text-center" style="margin-bottom:20px;">
        <!--<img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>"
             alt="<?= $Settings->site_name; ?>">-->
            <p><b>PURCHASES REQUEST</b></p>
    </div>
<?php } ?>
<div class="well well-sm">
    <div class="row bold">
        <div class="col-xs-4">
        <p class="bold">
            <?= lang("ref"); ?>: <?= $inv->reference_no; ?><br>
            <?= lang("date"); ?>: <?= $this->erp->hrld($inv->date); ?><br>
            <?= lang("status"); ?>:
                <?php if ($inv->status == 'requested') { ?>
                    <span class="label label-default"><?= ucfirst($inv->status); ?></span>
                <?php } else if ($inv->status == 'reject') { ?>
                    <span class="label label-danger"><?= ucfirst($inv->status); ?></span>
                <?php } else { ?>
                    <span class="label label-success"><?= ucfirst($inv->status); ?></span>
                <?php } ?>
                <br>
        </p>
        </div>
        <div class="col-xs-7 text-right">
            <p>Purchases Request</p>
            <?php $br = $this->erp->save_barcode($inv->reference_no, 'code39', 70, false); ?>
            <img src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                 alt="<?= $inv->reference_no ?>"/>
            <?php $this->erp->qrcode('link', urlencode(site_url('purchases/view/' . $inv->id)), 2); ?>
            <img src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
                 alt="<?= $inv->reference_no ?>"/>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row" style="margin-bottom:15px;">
    <div class="col-xs-6">
        <?php echo $this->lang->line("from"); ?>:<br/>     
        <h3 style="margin-top:10px;"><?= $supplier->company ? $supplier->company : $supplier->name; ?></h3>
        <?= $supplier->company ? "" : "Attn: " . $supplier->name ?>

        <?php
        echo $supplier->address . "<br />" . $supplier->city . " " . $supplier->postal_code . " " . $supplier->state . "<br />" . $supplier->country;
        echo lang("tel") . ": " . $supplier->phone . "<br />" . lang("email") . ": " . $supplier->email;
        ?>
    </div>
    <div class="col-xs-5">
        <?php echo $this->lang->line("to"); ?>:<br/>
        <h3 style="margin-top:10px;"><?= $Settings->site_name; ?></h3>
        <?= $warehouse->name ?>

        <?php
        echo $warehouse->address;
        echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone . "<br>" : '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
        ?>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped print-table order-table">

        <thead>

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

        <tbody>

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
        <tfoot>
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
            <td colspan="<?= $col; ?>"
                style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                (<?= $default_currency->code; ?>)
            </td>
            <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->erp->formatMoneyPurchase($inv->grand_total); ?></td>
        </tr>
       <!-- <tr>
            <td colspan="<?= $col; ?>"
                style="text-align:right; font-weight:bold;"><?= lang("paid"); ?>
                (<?= $default_currency->code; ?>)
            </td>
            <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoneyPurchase($inv->paid); ?></td>
        </tr>
        <tr>
            <td colspan="<?= $col; ?>"
                style="text-align:right; font-weight:bold;"><?= lang("balance"); ?>
                (<?= $default_currency->code; ?>)
            </td>
            <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoneyPurchase($inv->grand_total - $inv->paid); ?></td>
        </tr>-->

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

    <div class="col-xs-5 pull-right">
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