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
        padding: 10px;
        font-size: 14px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        position:relative;
    }

    .border td,.border th{
        border: 1px solid #9D192B !important;

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
        .contact div,p{
            color: #9D192B !important;
            font-size: 12px !important;
        }

        .trfoot{
            height: 20px !important;
            font-size: 12px !important;
        }
        #print{
            display: none;
        }


        .str{
            font-size: 16px !important;
        }

        .dtt{
            font-size: 13px !important;
        }
        .sups{
            font-size: 10px !important;
        }

    }
    .dtt{
        color: #9D192B !important;
        font-size: 17px;
    }
    .sups{
        font-size: 14px;
    }
    .str{
        color: #9D192B !important;
    }
    .trfoot{
        height: 10px;
    }
    .contact div,p{
        color: #9D192B !important;
        font-size: 15px;
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

    .noPadding tr{
        padding: 0px 0px;
        margin-top: 0px;
        font-size: 13px !important;
        margin-bottom: 0px;
        border: none;
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
                <th colspan="9" style="border-left:none;border-right: none;border-top:none;border-bottom: 1px solid #9D192B !important;">
                    <div class="row" style="margin-top: 0px !important;">
                        <div class="col-sm-12 col-xs-12 " style="margin-top: 0px !important;">
                            <?php if(!empty($biller->logo)) { ?>
                                <!--<center><img class="img-responsive myhide" src="<?= base_url() ?>assets/uploads/logos/<?= $biller->logo; ?>"id="hidedlo" style="width: 200px;height: 100px;" /></center>-->
                            <?php } ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-4"></div>

                        <div class="col-sm-4 col-xs-4"></div>
                        <div class="col-sm-4 col-xs-4 " >
                            <button  id="print" onclick="window.print()" class="btn btn-success ">
                                Print
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12 " style="margin-top: 0px !important;">
                            <div class="col-sm-3 col-xs-3 ">
                                <h2>&nbsp;</h2>
                            </div>
                            <div class="col-sm-9 col-xs-9 ">
                                <h3><b class="str">Stock Transfer Request &nbsp;&nbsp; N<sup class="str sups">0</sup> :</b><span class="str"><?= $inv->transfer_no ?></span></h3>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12" style="margin-top: 0px !important;">
                            <div class="col-sm-12 col-xs-12 " align="left" >
                                <p  class="dtt">
                                    Date: <span class="dtt"><?= $this->erp->hrld($inv->date) ?></span>
                                    &nbsp;&nbsp;
                                    Transfer From: <span class="dtt"><?= $inv->from_warehouse_name ?></span>
                                    &nbsp;&nbsp;
                                    Transfer To:&nbsp; <span class="dtt"><?= $inv->to_warehouse_name ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
            <tr class="border">
                <th colspan="4"><b class="dtt">DESCRIPTION</b></th>
            </tr>
            <tr class="border">
                <th><b class="dtt">No</b></th>
                <th><b class="dtt">Product</b></th>
                <th><b class="dtt">Unit</b></th>
                <th><b class="dtt">QTY</b></th>

            </tr>
            </thead>
            <tbody>
            <?php //$this->erp->print_arrays($inv); ?>
            <?php

            $no = 1;
            $erow = 1;
            $totalRow = 0;
            foreach ($rows as $row) {
                //$this->erp->print_arrays($row);
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
                    <td style="color: #9D192B !important;vertical-align: middle; text-align: center"><?php echo $no ?></td>
                    <td style="color: #9D192B !important;vertical-align: middle;">
                        <?=$row->product_name;?>
                    </td>
                    <td style="color: #9D192B !important;vertical-align: middle; text-align: center">
                        <?= $row->unit ?>
                    </td>
                    <td style="color: #9D192B !important;vertical-align: middle; text-align: center">
                        <?=$this->erp->formatQuantity($row->quantity);?>
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
            if($erow<13){
                $k=13 - $erow;
                for($j=1;$j<=$k;$j++) {
                    echo  '<tr class="border">
                                <td style="color:#9D192B !important; text-align: center; vertical-align: middle">'.$no.'</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>';
                    $no++;
                }
            }
            ?>

            </tbody>
        </table>
        <br>
        <br>
        <br>
        <table style="width: 100%;font-size: 13px;">
            <tr class="trfoot">
                <td style="width: 20%;color: #9D192B !important;"></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important; font-weight: bold;">Requested By</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important; font-weight: bold;">Hand Over By</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important; font-weight: bold;">Received By</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important; font-weight: bold;">Ferified By</td>
            </tr>
            <tr class="trfoot">
                <td style="width: 20%;color: #9D192B !important;">Signature&nbsp;&nbsp;&nbsp;&nbsp; :</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 5px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 5px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 5px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 5px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
            </tr>
            <tr class="trfoot">
                <td  style="width: 20%;color: #9D192B !important;">Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
            </tr>
            <tr class="trfoot">
                <td style="width: 20%;color: #9D192B !important;">Phone No&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
            </tr>
            <tr class="trfoot">
                <td style="width: 20%;color: #9D192B !important;">Date/Time&nbsp;&nbsp;&nbsp; :</td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
                <td style="padding: 2px; width: 20%;color: #9D192B !important;"><p style="margin-top: 10px; width: 100%; height: 1px;background-color:#9D192B !important; "></p></td>
            </tr>
        </table>
        <br>
        <div class="row contact" >
            <div class="col-sm-2 col-xs-2">
                <p><b style="color: #9D192B !important;">Contact &nbsp;&nbsp;&nbsp;:</b></p>
            </div>
            <div class="col-sm-5 col-xs-5">
                <p><b style="color: #9D192B !important;">MCP Intercon</b> : 095 91 36 36</p>
            </div>
            <div class="col-sm-5 col-xs-5">
                <p><b style="color: #9D192B !important;">MCP Phsar Depo</b> : 076 691 36 36</p>
            </div>
        </div>
        <div class="row contact" >
            <div class="col-sm-2 col-xs-2">
                <p>&nbsp;</p>
            </div>
            <div class="col-sm-10 col-xs-10">
                <p><b style="color: #9D192B !important;">Facebook</b> : https://www.facebook.com/mCarPartsServices/</p>
            </div>

        </div>
    </div>




    <div style="width: 821px;margin: 20px;">
        <a class="btn btn-warning no-print" href="<?= site_url('transfers'); ?>"  style="margin-top: 20px !important;border-radius: 0 ;" >
            <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("back"); ?>
        </a>
    </div>
</div>

</body>
<script type="text/javascript">
    if(!<?=$invs->total_discount?$invs->total_discount:0; ?>){
        $('td:nth-child(6),th:nth-child(6)').hide();
    }
    if(!<?=$invs->product_tax?$invs->product_tax:0; ?>){
        $('td:nth-child(7),th:nth-child(7)').hide();
    }
</script>
</html>