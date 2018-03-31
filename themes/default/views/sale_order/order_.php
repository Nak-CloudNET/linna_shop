<?php //$this->erp->print_arrays($quote_items);?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("list_sale_order") . " " . $inv->reference_no; ?></title>
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
                    <h1><?php echo $biller->company;?></h1>
                    <?php 
                        if($biller->address){echo $biller->address."<br>";}
                        if($biller->phone){echo "&nbsp &nbsp".lang("tel") . " : ".$biller->phone;}
                        if($biller->email){echo "&nbsp &nbsp".lang("email")." : ". $biller->email;}
                    ?>           
                </div>
                <div class="col-xs-3">
                    
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            <br>
            <div class="row padding10">                
                <div class="col-xs-12 text-center" style="text-align:center;margin-top:-20px">
                    <h3><b><?= lang("list_sale_order"); ?></b></h3>
                </div>                
            </div>
            <div class="row padding10">
                <div class="col-xs-5" style="float: left;font-size:14px">
                    <h4><b><?= lang("customer"); ?></b></h4>
                    <table>
                        <tr>
                            <td>
                                <p><?= lang("name");?></p>
                            </td>
                            <td>
                               <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$inv->customer."</b>"; ?></p>
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
                                <p><?= "<b>".$customer->address."</b>"; ?></p>
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
                                <p><?= "<b>".$customer->phone."</b>"; ?></p>
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
                                <p><?= "<b>".$customer->email."</b>"; ?></p>
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
                                <p><?= lang("sales_no"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$inv->reference_no."</b>";?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("sale_date"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$inv->date."</b>";?></p>
                            </td>
                        </tr>
                        <?php if($quote->reference_no){?>
                        <tr>
                            <td>
                                <p><?= lang("quote_no"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$quote->reference_no."</b>";?></p>
                            </td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td>
                                <p><?= lang("location"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$warehouse->name."</b>";?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><?= lang("sales_person"); ?></p>
                            </td>
                            <td>
                                <p>&nbsp;:&nbsp;</p>
                            </td>
                            <td>
                                <p><?= "<b>".$seller->username."</b>";?></p>
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
                    echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone: '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
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
                        <?php if($setting->show_code == 1 && $setting->separate_code == 1) { ?>
                        <th><?= lang('product_code'); ?></th>
                        <?php } ?>
                        <th><?= lang("description"); ?></th>
                        <th><?= lang("unit"); ?></th>
                        <th><?= lang("quantity"); ?></th>
                        <th><?= lang("unit_price"); ?></th>
                        <?php
                        if ($Settings->tax1) {
                            echo '<th>' . lang("tax") . '</th>';
                        }
                        if ($Settings->product_discount && $inv->product_discount != 0) {
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
                    $free = lang('free');
                    $total = 0;
                    $product_unit = '';
                    
                    
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
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                            <?php if($setting->show_code == 1 && $setting->separate_code == 1) { ?>
                            <td style="vertical-align:middle;">
                                <?= $row->product_code ?>
                            </td>
                            <?php } ?>
                            <td style="vertical-align:middle;">
                                <?= $product_name_setting ?>
                                <?= $row->details ? '(' .strip_tags($row->details) .')': ''; ?>
                                <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                            </td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo $product_unit?></td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->erp->formatQuantity($row->quantity); ?></td>
                           <td style="text-align:right; width:100px;"><?= $this->erp->formatMoney($row->unit_price); ?></td>
                            <?php
                            if ($Settings->tax1) {
                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->erp->formatMoney($row->item_tax) . '</td>';
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->erp->formatMoney($row->item_discount) . '</td>';
                            }
                            ?>
                            <td style="text-align:right; width:120px;"><?= $row->subtotal!=0?$this->erp->formatMoney($row->subtotal):$free; 
                                ?></td>
                        </tr>
                        <?php
                        $r++;
                        $total += $row->subtotal;
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot style="font-size: 13px;">
                    <?php
                        $discount_percentage = '';
                        if (strpos($inv->order_discount_id, '%') !== false) {
                            $discount_percentage = $inv->order_discount_id;
                        }
                    ?>
                    <?php 
                        $col=4;
                        $row=2;
                        if($inv->shipping != 0){
                            $row++;
                        }
                        if($inv->order_tax != 0){
                            $row++;
                        }
                        if($inv->grand_total != 0){
                            $row++;
                        }
                        if($inv->paid != 0){
                            $row++;
                        }
                    ?>
                        <tr>
                            <td colspan="<?=$col;?>" rowspan="<?=$row;?>">
                                <b><p class="bold"><?= lang("note"); ?>:</p></b>
                                <?= $this->erp->decode_html($inv->note); ?>
                            </td> 
                            <td colspan="2" style="text-align:right;"><?= lang("total"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right;"><?= $this->erp->formatMoney($total); ?></td>
                        </tr>
                   
                    <?php if ($return_sale && $return_sale->surcharge != 0) {
                        echo '<tr><td colspan="2" style="text-align:right;">' . lang("surcharge") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($return_sale->surcharge) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->order_discount != 0) {
                        echo '<tr><td colspan="2" style="text-align:right;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right;"><span class="pull-left">'.($discount_percentage?"(" . $discount_percentage . ")" : '').'</span>' . $this->erp->formatMoney($inv->order_discount) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->shipping != 0) {
                        echo '<tr><td colspan="2" style="text-align:right;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->shipping) . '</td></tr>';
                    }
                    ?>
                    <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                        echo '<tr><td colspan="2" style="text-align:right;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->erp->formatMoney($inv->order_tax) . '</td></tr>';
                    }
                    ?>
                    
                    <tr>
                        <td colspan="2" style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->grand_total); ?></td>
                    </tr>
                    <?php if($inv->paid > 0) { ?>
                    <tr>
                        <td  colspan="2" style="text-align:right; font-weight:bold;"><?= lang("paid"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->paid); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right; font-weight:bold;"><?= lang("balance"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->erp->formatMoney($inv->grand_total - $inv->paid); ?></td>
                    </tr>
                    <?php } ?>
                    </tfoot>
                </table>
            </div>
            <?php if($this->erp->decode_html($inv->staff_note)){?>
            <div class="row">
                <div class="col-xs-6">
                    <?= "<b>Staff Note :</b>".$this->erp->decode_html($inv->staff_note); ?>
                </div>
                <div class="col-xs-3">
                    
                </div>
                <div class="col-xs-3">
                    
                </div>
            </div>
            <?}?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-lg-3 col-xs-6 text-center">
                        <p class="bold"><?= lang("customer"); ?></p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                        <p><?= lang("name"); ?> :  .....................................................................</p>
                        <p><?= lang("date"); ?> :  ..................../....................../.........................</p>
                    </div>
                    <div class="col-lg-6">
                        
                    </div>
                    <div class="col-lg-3 col-xs-6 text-center">
                        <p class="bold"><?= lang("authorized_by"); ?></p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                        <p><?= lang("name"); ?> :  .....................................................................</p>
                        <p><?= lang("date"); ?> :  ..................../....................../.........................</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/><br/>
<div id="wrap" style="width: 90%; margin:0px auto;">
</div>
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', '#b-add-quote' ,function(event){
    event.preventDefault();
    localStorage.removeItem('slitems');
    window.location.href = "<?= site_url('quotes/add'); ?>";
  });
});

</script>
</body>
</html>