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
    td{
        border: none;
    }
    .container {
        width: 100%;
        margin: 18px auto;
        padding: 10px;
        font-size: 12px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        position:relative;
    }

    .title-header tr{
        border: 1px solid #000 !important;
    }
    .border th{
        border: 1px solid #000 !important;
        border-top: 1px solid #000 !important;
    }
    .tbody tr td{
        border-right: 1px solid black;
    }
    .tbody tr td{
        border-left: 1px solid black;
    }

    @media print {

        .pageBreak {
            page-break-after: always;
            -webkit-page-break-after: always;
        }

        .customer_label {
            padding-left: 0 !important;
        }
        tbody{
            display:table-row-group;
            -webkit-print-color-adjust: exact;
        }

        tfoot {
            display: table-footer-group;
            -webkit-display: table-footer-group;
            page-break-after: always;
        }
        .invoice_label {
            padding-left: 0 !important;
        }
        #footer {
            bottom: 10px !important;
        }
        #note{
            max-width: 95% !important;
            margin: 0 auto !important;
            border-radius: 5px 5px 5px 5px !important;
            margin-left: 26px !important;
        }
        .col-xs-12, .col-sm-12{
            padding-left:30px;
            padding-right:30px;
            margin-left:0px;
            margin-right:0px;
        }
        table {border-collapse: collapse;}

        .move-left{
            margin-left: 95px;
        }
        .move-right{
            width: 40%;
        }


    }

    body{
        font-size: 14px !important;
        font-family: "Khmer OS System";
        -moz-font-family: "Khmer OS System";
    }
    .header{
        font-family:"Khmer OS Muol Light";
        -moz-font-family: "Khmer OS System";
        font-size: 18px;
    }

    .table > thead > tr > th,.table > thead > tr > td, tbody > tr > th, .table > tfoot > tr > th, .table > tbody > tr > td, .table > tfoot > tr > td{
        padding:5px;
    }
    .title{
        font-family:"Khmer OS Muol Light";
        -mox-font-family:"Khmer OS Muol Light";
        font-size: 15px;
    }
    h4{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .noPadding tr{
        padding: 0px 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        border: none;
    }
    .noPadding tr td{
        padding: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        border:1px solid white;
    }
    .border-foot td{
        border: 1px solid #000 !important;
    }
    thead tr th{
        font-weight: normal;
        text-align: center;
    }
    .box{
        border: 1px solid black;
        border-radius: 7px;
        padding: 10px;
    }
    @media print {
        .box{

            padding: 10px!important;
        }
        .b1{
            height: 150px!important;
        }

        .prak_kok{
            background: white!important;
        }
        tr.tb_strip:nth-child(odd){
            background:whitesmoke!important;);
        }
    }

    body{

        font-family: "Khmer OS System","Times New Roman";
        -moz-font-family: "Khmer OS System";
    }
    .header1{
        font-family:"Khmer OS Muol Light";
        -moz-font-family: "Khmer OS System";

    }
    .header2{
        font-family:"Times New Roman";
        -moz-font-family: "Times New Roman";
        font-weight: bolder;

    }
    .tb_cus thead td{
        padding: 3px 0px;
    }
    .tfoot_ch td{
        padding: 3px 5px;
        text-align: center;

    }
    .tfoot td{
        width: 283px;
        font-size: 12px;

    }
    .tb_height td{
        padding-left:5px;
    }
    .tfoot td table{
        border: 1px solid black;
        font-size: 13px;
    }
    .tfoot td p{
        line-height: 0px!important;

    }
    .tb_cus td{
        border-right: 1px solid black;
    }

    tbody tr.tb_strip:nth-child(odd){
        background:whitesmoke;
    }
    .container{

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
        <div class="col-md-7" style="font-size: 30px;font-family: Time New Roman;">
            <b>BK</b>
            <hr style="border: 1px solid black; width: 100%; margin-left: -16px;">
        </div>
        <div class="col-md-4">
            <strong style="margin-left: 40px; font-size: 22px;font-family: Time New Roman;">ប័ណ្ណទទួលទំនិញ</strong>
            <br>
            <b style="margin-left: 27px;font-size: 30px;font-family: Time New Roman;">Received Items</b
        </div>

    </div>
    <div class="row">
        <div class="col-md-7" style="border: 1px solid black; border-radius: 10px; height: 105px; width: 419px; margin-left: 16px;font-size: 13px;">
            <br>
            ចួលមកពី​ / Receiveed From : BK.Lim Srun & Chheiv Ly
            <br>
            បញ្ជូនទៅ​ / Ship To : Depo Chheiv Ly (St.271)
        </div>
        <div class="col-md-5" style="border-radius:10px; height: 80px; margin-left: -5px; border: 1px solid black;margin-top: 26px;margin-left: 2px;font-size: 13px;width: 344px;">
            <br>
            កាលបរិច្ឆេទ​ / Date :9/3/2018
            <br>
            លេខយោង​ / REF No. :16BK, 1/9
            br
            លេខប័ណ្ណទទួលទំនិញ / RI No. :08M
            <br>

        </div>
    </div>
    <br>
    <div class="body">
        <table  width="100%" class="tb_cus" style="overflow: hidden;border: 1px solid black;width: 762px;margin-left: 5px;">
            <thead class="text-center"​ style="border-bottom: 1px solid black">
            <td>ល.រ <br>No.</td>
            <td>បរិយាយមុខទំនិញ<br>​Item Description</td>
            <td>បរិមាណចូល<br>Qty In</td>
            <td>ឃ្លំាង<br>Site</td>
            <td>ឯកតា<br>Unit</td>
            <td>ថ្លៃឯកតា<br>Price</td>
            <td>ថ្លៃទំនិញ<br>Amount</td>
            </thead>
            <tbody class="text-center">
            <?php $r = 1;
            $tax_summary = array();
//           $this->erp->print_arrays($rows);
            foreach ($rows as $row):
                $free = lang('free');
                $product_unit = '';


                if($row->variant){
                    $product_unit = $row->variant;
                }else{
                    $product_unit = $row->product_unit;
                }

                $product_name_setting;
                if($setting->show_code == 0) {
                    $product_name_setting = $row->product_name;
                }else {
                    if($setting->separate_code == 0) {
                        $product_name_setting = $row->product_name;
                    }else {
                        $product_name_setting = $row->product_name;
                    }
                }


                ?>
                <tr class="tb_strip">
                    <td style="width:40px; "><?= $r; ?></td>

                    <td class="text-left" style="padding-left: 5px">
                        <?= $product_name_setting ?>
                        <?= $row->details ? '<br>' . $row->details : ''; ?>
                        <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                    </td>
                    <td><?= $this->erp->formatQuantity($row->quantity); ?></td>
                    <td></td>
                    <td ><?php echo $product_unit ?></td>

                    <!-- <td style="text-align:right; width:100px;"><?= $this->erp->formatNumber($row->net_unit_price); ?></td> -->
                    <td ><?= $row->subtotal!=0?$this->erp->formatNumber($row->unit_price):$free; ?></td>
                    <td><?= $row->subtotal!=0?$this->erp->formatNumber($row->subtotal):$free; ?></td>
                </tr>
                <?php
                $total += $row->subtotal;
                $r++;
            endforeach;
            //            $this->erp->print_arrays($invs);
            $minus_row=12;
            if($invs->order_discount<=0){
                $minus_row+=2;
            }
            if($invs->order_tax<=0){
                $minus_row+=2;
            }
            if($invs->paid<=0){
                $minus_row+=4;
            }
            if($invs->shipping<=0){
                $minus_row+=2;
            }
            if($invs->order_discount<=0 && $invs->order_tax<=0 && $invs->shipping<=0){
                $minus_row+=2;
            }
            for($i=1;$i<($minus_row-$r);$i++){
                ?>
                <tr style="border-bottom: transparent;background: transparent!important;">
                    <td></td>
                    <td class="text-left" style="padding-left: 5px;">&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
            <?php //$this->erp->print_arrays($invs); ?>
            <tfoot >
            <tr style="border-top: 1px solid black">
                <td rowspan="1" colspan="5"​ style="vertical-align: top; padding: 25px 18px">
                    <p>សម្គាល់ / Message : </p>
                    <div><?= $this->erp->decode_html($customer->invoice_footer); ?></div>
                </td>
                <td colspan="3" style="padding: 0px;overflow: hidden">
                    <table width="100%" style="" class="tfoot_ch">
                        <?php
                        $txt_gr='';
                        $showgr='';
                        if($invs->order_discount>0 || $invs->total_tax>0 || $invs->shipping>0){
                            ?>
                            <tr style="border-bottom: 1px solid black">
                                <td style="border-right: 1px solid black">សរុប<br>Subtotal</td>
                                <td style="border-right: none"><?= $this->erp->formatNumber($total); ?></td>
                            </tr>
                            <?php
                        }
                        else{
                            $txt_gr='Total';
                            $showgr=false;
                        }
                        ?>

                        <?php
                        if($invs->order_discount>0){
                            ?>
                            <tr style="border-bottom: 1px solid black">
                                <td style="border-right: 1px solid black">បញ្ចុះតម្លៃ<br> Discount</td>
                                <td style="border-right: none"><small>(<?= $invs->order_discount_id ?>%)</small><?= $this->erp->formatNumber($invs->order_discount); ?></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <?php
                        if($invs->shipping>0){
                            ?>
                            <tr style="border-bottom: 1px solid black">
                                <td style="border-right: 1px solid black">ដឹកជញ្ជូន<br>Shipping</td>
                                <td style="border-right: none"><?= $this->erp->formatNumber($invs->shipping); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        //$this->erp->print_arrays($invs);
                        if($invs->total_tax>0){
                            ?>
                            <tr style="border-bottom: 1px solid black">
                                <td style="border-right: 1px solid black">ពន្ធអាករ<br><?= $invs->tax_name ?></td>
                                <td style="border-right: none"><?= $this->erp->formatNumber($invs->total_tax); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr style="">
                            <style>
                                .t_cus_line{
                                    border-right: 1px solid black;
                                    position: relative;
                                }
                                .t_cus_line:after{
                                    border-left: 1px solid black;
                                    position: absolute;
                                    content: '';
                                    height: 113%;
                                    top:-3px;
                                    left:100%;
                                    background:black;
                                }
                            </style>
                            <td style="border-right: none">Sub Total: <?= $this->erp->formatNumber($invs->grand_total); ?></td>
                        </tr>
                    </table>
                </td>

            </tr>

            </tfoot>
        </table>
    </div>
    <br>
    <?php
    //                $this->erp->print_arrays($invs);
    ?>
    <?php
    $sql=$this->db->query('select erp_users.first_name,erp_users.last_name from erp_users where id="'.$invs->created_by.'"')->result();
    foreach ($sql as $cname){
        $fn=$cname->first_name;
        $ln=$cname->last_name;
    }
    //          $this->erp->print_arrays($sql);
    ?>
    <style>

        .foot div{
            width: 146px;
            margin-right: 8px;
        }
        @media print {
            .foot div{
                width: 138px;
                margin-right: 3px!important;
            }
        }
    </style>

    <div class="row" style="">
        <div class="col-sm-12 foot" style="margin-left: 5px;">
            <div style="float: left; font-size: 11px;border: 1px solid black;​​" >
                <p style="text-align: center">អ្នកប្រគល់ទំនិញ<br>Received by</p>&nbsp;ឈ្មោះ​៖<span></span>​<br>&nbsp;Name<br>&nbsp;ទូរស័ព្ទ៖<span></span><br>&nbsp;Phone<br>&nbsp;ហត្ថលេខា៖<br>&nbsp;Sign
            </div>
            <div  style=" float: left; font-size: 11px;border: 1px solid black;​​" >
                <p style="text-align: center"> ដឹកជញ្ជូនដោយ<br>Delivered by</p>
                &nbsp;ឈ្មោះ​៖  ​D.Thoeun<span></span>​<br>&nbsp;Name<br>&nbsp;លេខឡាន៖  4787<span></span><br>&nbsp;Truck No<br>&nbsp;ហត្ថលេខា៖<br>&nbsp;Sign
            </div>
            <div  style="float: left; font-size: 11px;border: 1px solid black;​​" >
                <p style="text-align: center"> នាយឃ្លាំង<br>WH Controller</p>&nbsp;ឈ្មោះ​៖<span></span>​<br>&nbsp;Name<br><br>&nbsp;ហត្ថលេខា៖<br>&nbsp;Sign<br><br>
            </div>
            <div  style="float: left; font-size: 11px;border: 1px solid black;​​" >
                <p style="text-align: center"> គណនេយ្យករ<br>Accountant</p>
                &nbsp;ឈ្មោះ​៖​  LAKANA<span></span><br>&nbsp;Name<br>&nbsp;ទូរស័ព្ទ៖  070721158<span></span><br>&nbsp;Phone<br>&nbsp;ហត្ថលេខា៖<br>&nbsp;Sign
            </div>
            <div  style="float: left;width: 146px; font-size: 11px;border: 1px solid black;​​" >
                <p style="text-align: center"> តំណាងផ្នែកលក់<br>Sales Rep</p>
                &nbsp;ឈ្មោះ​៖  C.T<span></span>​<br>&nbsp;Name<br>&nbsp;ទូរស័ព្ទ៖  012 721158<span></span><br>&nbsp;Phone<br>&nbsp;ហត្ថលេខា៖<br>&nbsp;Sign
            </div>
        </div>
    </div>
    <div class="row">
        <div style="margin-left: 20px;margin-top: 20px;" class="col-md-2">
            <a class="btn btn-warning no-print" href="<?= site_url('sales'); ?>" style="border-radius: 0">
                <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("back"); ?>
            </a>
        </div>

    </div>
</div>
</body>
</html>