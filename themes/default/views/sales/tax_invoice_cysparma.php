<link href="<?= $assets ?>styles/helpers/bootstrap.min.css" rel="stylesheet"/>
<style>
    .btn {
        padding: 0;
        border-radius: 0;
        color: #000;
        width: 22px;
        height: 25px;
        background-color: transparent;
        border: 1px solid #000;
    }

    @media print {
        .container {
            width: 98% !important;
            margin: 10px auto !important;
            padding: 0;
        }
        #footer {
            position: absolute !important;
            bottom: 10px !important;
            width: 100%;
        }
        #footer .col-sm-6 {
            width: 50% !important;
        }
    }

</style>
<?php
$address = '';
$address.=$biller->address;
$address.=($biller->city != '')? ', '.$biller->city : '';
$address.=($biller->postal_code != '')? ', '.$biller->postal_code : '';
$address.=($biller->state != '')? ', '.$biller->state : '';
$address.=($biller->country != '')? ', '.$biller->country : '';
//	$this->erp->print_arrays($rows);
?>
<div class="container">
    <center>
        <br>
        <table class="table-responsive" width="1024px" border="0" cellspacing="0" style="margin:auto;">
            <tr>
                <td width="10%">
                    <img class="img-responsive" src="<?= base_url() ?>assets/uploads/no_image.png" style="width: 100px;margin-bottom: 80px; vertical-align: top;" />
                </td>
                <td width="50%" style="vertical-align: top;">
                    <h2 style=" text-align: left;"><?= $biller->company_kh ?></h2>
                    <h3 style="text-align: left; font-weight: bold"><?= $biller->company ?></h3>
                    <table class="table-responsive" width="100%" border="0" cellspacing="0" style="margin:auto;">
                        <tr>
                            <td style="width: 50px !important"></td>
                            <td>

                            </td>
                        </tr>
                    </table>
                    <table class="table-responsive" width="100%" border="0" cellspacing="0" style="margin:auto;">
                        <tr>
                            <td>
                                <div style="font-family:'Khmer OS'; font-size:12px;"><?= $this->lang->line("អាស័យដ្ឋាន"); ?></div>
                            </td>
                            <td>
                                <div style="font-family:'Khmer OS'; font-size:12px;">: <?= $biller->cf4; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-family:'Arial'; font-size:12px;"><?= $this->lang->line("Address"); ?></div>
                            </td>
                            <td>
                                <div style="font-family:'Arial'; font-size:12px;">: <?= $biller->address; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-family:'Arial'; font-size:12px;"><?= lang("tel"); ?></div>
                            </td>
                            <td style="font-family:'Arial'; font-size:12px;">: <?= $biller->phone;?></td>
                        </tr>
                        <tr>
                            <td >
                                <div style="font-family:'Khmer OS'; font-size:12px;"><?= lang("email"); ?></div>
                            </td>
                            <td style="font-family:'Arial'; font-size:12px;">: <?= $biller->email; ?></td>
                        </tr>
                        <tr style="width: 30%;">
                            <td>
                                <div style="font-family:'Khmer OS'; font-size:12px; width: 200px;"><?= $this->lang->line("លេខអត្តសញ្ញាណកម្ម អតប​ (VATTIN)"); ?></div>
                            </td>
                            <td>
                                <div style="font-family:'Arial'; font-size:12px;">:
                                    <?php for($i=strlen($biller->vat_no);$i>=1 ; $i--) { ?>
                                        <?php
                                        $sign ="";
                                        if ($i == 10) {
                                            $sign = "-";
                                        }
                                        ?>
                                        <button type="button" class="btn"><?= $biller->vat_no[strlen($biller->vat_no)-$i]?></button> <?= $sign ?>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="30%" style="vertical-align: top;">
                    <h2 style=" text-align: right;">វិក័យប័ត្រអាករ</h2>
                    <h3 style="text-align: right; font-weight: bold">TAX INVOICE</h3>
                    <img class="img-responsive" src="<?= base_url() ?>assets/uploads/qrcode1.png" style="margin-left: 246px; width: 100px;" />

                </td>
            </tr>
        </table>
        <table class="table-responsive" width="1024px" border="0" cellspacing="0" style="margin:auto;">
            <tr>
                <td colspan="5" width="65%" align="center" style="padding-top:5px;">
                    <div class="row">
                        <div class="col-sm-7 col-xs-7" style="">

                        </div>
                        <div class="col-sm-5 col-xs-5" >

                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5" width="65%" align="center" style="padding-top:5px;">
                    <table class=" table-hover print-table order-table " width="100%" style="margin-top: 10px; border: 1px solid black">
                        <tr>
                            <th width="50%"></th>
                            <th width="30%"></th>
                            <th width="20%"></th>
                        </tr>
                        <tr>
                            <td>លក់ជូន  / SOLD TO:<br> <br>លេខរៀងអតិថិជន  / CUSTOMER ID: <?= $customer->code; ?></td>
                            <td rowspan="4" style="vertical-align: top;">ដឹកទៅ  / DELIVERY TO:<br>Customer's address<br></td>
                            <td style="vertical-align: top;">លេខរៀងវិក្កយបត្រ  / INVOICE NO:<br><?= $inv->reference_no; ?></td>
                        </tr>
                        <tr>
                            <td>ឈ្មោះអតិថិជន  / CUSTOMER NAME: <b><?= $customer->name ? $customer->name : $customer->company; ?><br><?=$customer->company_kh?></b></td>
                            <td style="border: 1px solid black;">កាលបរិច្ឆេទ  / INVOICE DATE:<br>
                                <?php
                                $date = $this->erp->hrsd($inv->date);
                                echo $date;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>អាស័យដ្ឋាន  / ADDRESS: <?=$customer->address;?></td>
                            <td style="border: 1px solid black;">លេខយកទំនិញ  / PICK SLIP NO:<br></td>
                        </tr>
                        <tr>
                            <td>ទូរស័ព្ទលេខ  / TEL: <?=$customer->phone;?><br><br>លេខអត្តសញ្ញាណកម្ម​ អតប  / CUSTOMER VAT TIN:<br>
                                <?php for($i=strlen($customer->vat_no);$i>=1 ; $i--) { ?>
                                    <?php
                                    $sign ="";
                                    if ($i == 10) {
                                        $sign = "-";
                                    }
                                    ?>
                                    <button type="button" class="btn"><?= $customer->vat_no[strlen($customer->vat_no)-$i]?></button> <?= $sign ?>
                                <?php } ?>
                            </td>
                            <td>ថ្ងៃយកទំនិញ  / PICK SLIP DATE:<br></td>
                        </tr>
                    </table>
                    <table class=" table-hover print-table order-table " width="100%" style="margin-top: 10px !important; margin-bottom: 10px !important; ">
                        <tr style="text-align: center !important; border-bottom: 1px solid black !important;">
                            <td style="border: none;">លេខបញ្ជាទិញ<br>CUSTOMER PO:</td>
                            <td style="border: none;">អ្នកលក់<br>SALES REP:</td>
                            <td style="border: none;">អ្នកចែកចាយ<br>DELIVERED BY:</td>
                            <td style="border: none;">អ្នកប្រមូលលុយ<br>COLLECTOR:</td>
                            <td style="border: none;">លក្ខខណ្ឌទូទាត់<br>PAYMENT TERM:</td>
                            <td style="border: none;">ថ្ងៃទូទាត់<br>DUE DATE:</td>
                        </tr>
                        <tr style="text-align: center !important;">
                            <td style="border: 1px solid black; width: 15%;"></td>
                            <td style="border: 1px solid black; width: 15%;"><?=$inv->saleman_last;?>&nbsp;<?=$inv->saleman_first;?></td>
                            <td style="border: 1px solid black; width: 15%;">
                                <?php
                                    if($inv->delivery_by==0)
                                    {
                                        echo "";
                                    }
                                ?>
                            </td>
                            <td style="border: 1px solid black; width: 15%;"></td>
                            <td style="border: 1px solid black; width: 20%;"><?=$inv->payment_term?></td>
                            <td style="border: 1px solid black; width: 20%;"><?=$inv->due_date;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <style>
                        .order-table td,.order-table th{
                            padding: 5px;
                            border-right: 1px solid black;
                        }
                        .order-table tbody tr.tb_str:nth-child(odd){
                            background: whitesmoke;
                        }
                        @media print {
                            .order-table tbody tr.tb_str:nth-child(odd){
                                background: whitesmoke!important;
                            }
                        }
                        tfoot tr{
                            border-top: 1px solid black;
                        }
                    </style>
                    <div class="table-responsive">
                        <table class=" table-hover print-table order-table " width="100%" style="margin-top: 10px; border: 1px solid black">
                            <thead>
                            <tr style="border-bottom: 1px solid black">

                                <th width="5%" style="text-align:center;"><?= lang("ល-រ <br/> Nº"); ?></th>
                                <th width="5%" style="text-align:center;"><?= lang("បារកូដ<br/> UPC"); ?></th>
                                <th width="5%" style="text-align:center;"><?= lang("កូដ<br/> SKU"); ?></th>
                                <?php
                                $isTax=false;
                                $isDiscount=false;
                                if ($Settings->tax1 && $rows['item_tax'] != 0 && $rows['tax_code'] ) {
                                    $isTax= true;
                                }
                                if ($Settings->product_discount && $rows['discount'] != 0) {
                                    $isDiscount = true;
                                }
                                $dis=0;
                                $tax=0;
                                foreach ($rows as $row1):
                                    $free = lang('free');
                                    $product_unit = '';
                                    $tax+=$row1->item_tax;
                                    $dis+=$row1->item_discount;
                                endforeach;
                                // echo '<h1  >'.$dis.'</h1>';
                                ?>
                                <th style="text-align:center;" ><?= lang("បរិយាយមុខទំនិញ <br/> PRODUCT NAME"); ?></th>
                                <th style="text-align:center;" ><?= lang("លេខឡូត៏<br/> LOT NO"); ?></th>
                                <th style="text-align:center;" ><?= lang("ផុតកំណត់<br/> EXP DATE"); ?></th>
                                <th style="text-align:center;"><?= lang("ចំនួន<br/> QTY"); ?></th>
                                <th style="text-align:center;"><?= lang("ខ្នាត <br/> UOM"); ?></th>
                                <th style="text-align:center;" colspan="2"><?= lang("តម្លៃមុន/ក្រោយបញ្ចុះថ្លៃ<br/> PRICE BEFORE/AFTER DISC"); ?></th>
                                <?php
                                if ($tax>0) {
                                    echo '<th style="text-align:center;">' . lang("អាករឯកតា <br/> TAX") . '</th>';

                                }
                                if ($dis>0) {
                                    echo '<th style="text-align:center;">'.lang("បញ្ចុះតម្លៃឯកតា​ <br/> DISCOUNT").'</th>';
                                }
                                ?>
                                <th style="text-align:center;" colspan="<?=($isTax && $isDiscount)? 2:1 ?>"><?= lang("ថ្លៃទំនិញ<br/> AMOUNT"); ?></th>
                            </tr>

                            </thead>

                            <tbody>
                            <?php $r = 1;
                            $tax_summary = array();
                            foreach ($rows as $row):
                                $priceB = 0;
                                $priceA = 0;
                                $priceS = 0;
                                $free = lang('free');
                                $product_unit = '';
                                $total+=$row->subtotal;
                                $priceB = $row->net_unit_price * $row->quantity;
                                $priceA = $priceB - $row->item_discount;
                                $priceS = $row->quantity * $priceA;

//						if($row->variant){
//							$product_unit = $row->variant;
//						}else{
//							$product_unit = $row->unit;
//						}

                                $product_name_setting;
                                if($pos->show_product_code == 0) {
                                    $product_name_setting = $row->product_name;
                                }else{
                                    $product_name_setting = $row->product_name;
                                }
                                ?>
                                <tr class="tb_str">
                                    <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                    <td style="vertical-align:middle;"></td>
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->product_code ?></td>
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->product_name ?></td>
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"></td>
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->expiry ?></td>
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->quantity ?></td>
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->uname ?></td>
                                    <td style="width: 100px; text-align:center; vertical-align:middle;"><?= $this->erp->formatNumber($priceB); ?></td>
                                    <!-- <td style="text-align:right; width:100px;"><?= $this->erp->formatNumber($row->net_unit_price); ?></td> -->
                                    <td style="text-align:center; vertical-align:middle; width:100px;"><?= $row->subtotal!=0?$this->erp->formatNumber($priceA):$free; ?></td>
                                    <?php
                                    if ($tax>0) {
                                        echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->erp->formatNumber($row->item_tax) . '</td>';
                                    }
                                    if ($dis>0) {
                                        echo '<td style="width: 100px; text-align:right; vertical-align:middle;">'. $this->erp->formatNumber($row->item_discount).'</td>';
                                    }
                                    ?>
                                    <td style="text-align:right; vertical-align:middle; width:120px;" colspan="<?=($isTax && $isDiscount)? 2:1 ?>"><?= $row->subtotal!=0?$this->erp->formatNumber($row->subtotal):$free; ?></td>
                                </tr>
                                <?php
                                $r++;
                            endforeach;
                            ?>
                            <?php
                            if($r<11){
                                $k=11 - $r;
                                for($j=1;$j<=$k;$j++){
                                    if( $dis >0){
                                        if($tax>0){
                                            echo  '<tr>
											<td >&nbsp;</td>
											<td ></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>

										</tr>';
                                        }else{
                                            echo  '<tr>
											<td>&nbsp;</td>
											<td ></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>

										</tr>';
                                        }


                                    }else{
                                        if($tax>0){
                                            echo  '<tr>
											<td>&nbsp;</td>
											<td ></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>
											<td ></td>

										</tr>';

                                        }
                                        else{
                                            echo  '<tr>
											<td>&nbsp;</td>
											<td ></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>

										</tr>';
                                        }
                                    }
                                    $r++;
                                }
                            }
                            ?>
                            <?php
                            //echo $dis.'__Tax = '.$tax;
                            ?>

                            </tbody>
                            <tfoot>
                            <?php
                            $col = 2;
                            $rol = 1;
                            $tcol = 3;

                            if ($Settings->product_discount) {
                                $col++;
                                $tcol++;
                            }
                            if ($Settings->tax1) {
                                $col++;
                                $tcol++;
                            }
                            if ($inv->grand_total != $inv->total) {
                                $rol++;
                            }
                            if ($inv->order_discount != 0) {
                                $rol++;
                            }
                            if ($inv->shipping != 0) {
                                $rol++;
                            }
                            //						if ($Settings->tax2 && $inv->order_tax != 0) {
                            //							$rol++;
                            //						}
                            //						if($invs->paid != 0 && $invs->deposit != 0) {
                            //							$rol += 3;
                            //						}elseif ($invs->paid != 0 && $invs->deposit == 0) {
                            //							$rol += 2;
                            //						}elseif ($invs->paid == 0 && $invs->deposit != 0) {
                            //							$rol += 2;
                            //						}
                            $rol++;
                            $tcol++;
                            //						 echo '<h1>'.$col.'_'.$tcol.'</h1>';
                            if($dis>0){
                                $col+=1;
                                $tcol-=1;
                            }
                            if($tax>0){
                                $col+=1;
                                $tcol-=1;
                            }
                            if($tax>0&& $dis>0){
                                $col+=1;
                            }
                            if($dis<=0&&$tax<=0){
                                $tcol-=1;
                            }
                            if($inv->paid>0){
                                $rol+=2;
                            }
                            ?>
                            <!--<h1>--><?//= $col.'_----'.$rol; ?><!--</h1>-->
                            <tr style="border-bottom: 1px solid black">
                                <td rowspan="<?= $rol; ?>" colspan="<?= $col; ?>" style="vertical-align: top"><b>សំគាល់  / REMARKS:</b><br><?= $this->erp->decode_html($customer->invoice_footer);  ?></td>
                                <td style="text-align:right; padding-right:10px;font-weight:bold;" colspan="<?= $tcol; ?>"><?= lang("សរុប  / Sub Total"); ?></td>
                                <?php
                                if ($Settings->tax1 && $rows['item_tax'] != 0 && $rows['tax_code']) {
                                    echo '<td style="text-align:right; padding-top:20px; font-weight:bold;">' . $this->erp->formatNumber($inv->product_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $rows['discount'] != 0) {
                                    echo '<td style="text-align:right; vertical-align:middle; font-weight:bold;">' . $this->erp->formatNumber($inv->product_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; padding-right:10px; vertical-align:middle; font-weight:bold;" colspan="2"><?= $this->erp->formatNumber($total); ?></td>
                            </tr>
                            <?php if ($inv->order_discount > 0) {
                                echo '<tr><td colspan="' . $tcol . '" style="text-align:right; padding-right:10px; font-weight:bold;">' . lang("បញ្ចុះតម្លៃ​  / Order_Discount") . '</td><td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:20px; font-weight:bold;" colspan="2">' . $this->erp->formatNumber($inv->order_discount) . '</td></tr>';
                            }
                            ?>
                            <?php if ($inv->shipping > 0) {
                                echo '<tr><td colspan="' . $tcol . '" style="text-align:right; vertical-align:middle !important; padding-right:10px; font-weight:bold;" >' . lang("​ដឹក​ជញ្ជូន​   / Shipping") . ' </td><td style="text-align:right; vertical-align:middle; padding-right:10px;font-weight:bold;"colspan="2">' . $this->erp->formatNumber($inv->shipping) . '</td></tr>';
                            }

                            ?>
                            <?php if ($inv->order_tax > 0) {
                                $vat = str_replace('@', '', (strstr($inv->vat, '@', false)));
                                if ($vat == '10%') {
                                    $vat_kh = '១០%';
                                }
                                echo '<tr><td colspan="' . $tcol . '" style="text-align:right; vertical-align:middle !important; padding-right:10px; font-weight: bold;">' . lang("អាករលើតម្លែបន្ថែម <span>". $vat_kh ."</span><br/><span style='font-size:12px'>". $inv->vat ."</span>") . '</td><td style="text-align:right; vertical-align:middle; padding-right:10px;font-weight:bold;" colspan="2">' . $this->erp->formatNumber($inv->order_tax) . '</td></tr>';
                            }
                            ?>
                            <?php
                            if($inv->order_tax>0||$inv->shipping>0||$inv->order_discount>0){
                                ?>
                                <tr>
                                    <td colspan="<?= $tcol ?>"
                                        style="text-align:right; font-weight:bold;border: 1px solid black;"><?= lang("សរុប   / Grand_Total"); ?>
                                    </td>
                                    <td style="text-align:right; padding-right:10px; font-weight:bold; vertical-align:middle!important;border: 1px solid black;" colspan="2"><?= $this->erp->formatNumber(($total +  $inv->order_tax+$inv->shipping)-$inv->order_discount);?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if($inv->paid>0){
                                ?>
                                <tr>
                                    <td colspan="<?= $tcol ?>" style="text-align:right; font-weight:bold;">ប្រាក់កក់  / Deposite</td>
                                    <td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:20px;" colspan="2" ><?= $this->erp->formatNumber($inv->paid) ?></td>
                                </tr>
                                <tr>
                                    <td  colspan="<?= $tcol ?>" style="text-align:right; font-weight:bold;">ប្រាក់នៅសល់  / Balance</td>
                                    <td style="text-align:right; padding-right:10px; font-weight:bold; padding-top:20px;" colspan="2"><?= $this->erp->formatNumber($inv->grand_total-$inv->paid) ?></td>
                                </tr>
                                <?php
                            }
                            ?>

                            </tfoot>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <?php
        //$this->erp->print_arrays($inv);
        ?>
    </center>
    <div  style="font-size:12px; font-family:'Khmer OS'; padding-top:20px; margin-left:60px;"><?=$inv->invoice_footer?>
        អតិថិជនត្រូវពិនិត្យ និិងផ្ទៀងផ្ទាត់ចំនួន និងគុណភាពទំនិញ។ ទំនិញដែលបានទទួលហើយមិនអាចដូរ ឫត្រលប់វិញបានទេ។  <br/>
    </div>
    <div id="footer" class="row">
        <div style="height: 50px;"></div>
        <div class="col-sm-4 col-xs-4">
            <center>
                <p style="margin-top: 20px !important"><b style="font-size:14px; text-align: left;"><?= lang('CUSTOMER SIGNATURE'); ?></b></p>
            </center>
        </div>
        <div class="col-sm-4 col-xs-4">
            <center>
                <p style="margin-top: 20px !important"><b style="font-size:14px;"><?= lang('WAREHOUSE'); ?></b></p>
            </center>
        </div>
        <div class="col-sm-4 col-xs-4">
            <center>
                <img class="img-responsive" src="<?= base_url() ?>assets/uploads/barcode1.png" style="margin-left: 60px; width: 200px; alignment: center" />
            </center>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>