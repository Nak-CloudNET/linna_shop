
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
    body{
        font-size:12px;
    }
    table tbody tr th{
        font-size:12px;
    }
    .tbodyStyle td{
        padding-left:5px !important;
    }
    @media print{
        .bd{
            width:100% !important;
        }
        .md{
            margin:5px 0px;
        }
        .mdg{
            margin-right: 20px !important;
            margin-bottom:0px !important;
        }
        .com b{
            font-size:14px !important;
        }
        .modal-content, .modal-body{
            border:none !important;
        }

    }
</style>
<div class="modal-dialog modal-lg no-modal-header bd">
    <div class="modal-content mdg">
        <div class="modal-body ">

            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>

            <div class="col-md-12">
                <div class="col-md-4 col-sm-4 col-xs-3 col-md-offset-1a col-sm-offset-1a"style="padding:0px;">
                    <?php if ($logo) { ?>
                        <div class="logo-text"style="margin-top:15px;margin-right:10px !important;">
                            <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-9 " style="padding-top:10px;">
                    <div style="font-family:Khmer OS Muol Light;font-size:16px !important;" class="com"><b><?= $biller->cf1;?></b></div>
                    <div style="font-size:16px !important; font-weight:bold;"><?= $biller->company;?></div>
                    <div style="font-size:10px;"><?= $biller->cf4;?></div>
                    <div style="font-size:10px;">ទូរស័ព្ទលេខ : <?= $biller->phone;?></div>
                    <br/>
                </div>
            </div>

            <div class="col-md-12 text-center md com"style="font-size:15px !important;"> <b>ប័ណ្ណប្រគល់ និង ទទួលទំនិញ</b></div>
            <div class="clearfix"></div>
            <br/>
            <div class="table-responsive">
                <table border="1px" width="100%" class="text-left">
                    <tbody>
                    <tr height="40px" class="tbodyStyle">
                        <td width="30%"id="print"><strong><?php echo $this->lang->line("date"); ?></strong></td>
                        <td width="70%"><?php echo $this->erp->hrld($delivery->date); ?></td>
                    </tr>
                    <tr height="40px" class="tbodyStyle">
                        <td width="30%"id="print"><strong><?php echo $this->lang->line("do_reference_no"); ?></strong></td>
                        <td><?php echo $delivery->do_reference_no; ?></td>
                    </tr>
                    <tr height="40px" class="tbodyStyle">
                        <td width="30%"id="print"><strong><?php echo $this->lang->line("sale_reference_no"); ?></strong></td>
                        <td><?php echo $delivery->sale_reference_no; ?></td>
                    </tr>
                    <tr height="40px" class="tbodyStyle">
                        <td width="30%"id="print"><strong><?php echo $this->lang->line("customer"); ?></strong></td>
                        <td><?php echo $delivery->customer; ?></td>
                    </tr>
                    <tr height="40px" class="tbodyStyle">
                        <td width="30%"id="print"><strong><?php echo $this->lang->line("address"); ?></strong></td>
                        <td><?php echo $delivery->address; ?></td>
                    </tr>
                    <?php if ($delivery->note) { ?>
                        <tr height="40px" class="tbodyStyle">
                            <td width="30%"id="print"><?php echo $this->lang->line("note"); ?></td>
                            <td><?php echo $this->erp->decode_html($delivery->note); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <table border="1px" width="100%"  style="margin-bottom:20px">

                    <h4><strong><?php echo $this->lang->line("items"); ?></strong></h4>
                    <thead>
                    <tr height="40px" style="background-color: #5dbaf7;">
                        <th  style="text-align:center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("no"); ?></th>

                        <?php if($setting->show_code == 0){ ?>
                            <th style="text-align:left; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("product_name"); ?></th>
                        <?php }else if($setting->separate_code == 0){ ?>
                            <th style="text-align:left; text-align: center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("product_name"). ' || ' .$this->lang->line("product_code"); ?></th>
                        <?php }else{ ?>
                            <th style="text-align:center;vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("product_code"); ?></th>
                            <th style=" text-align:center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("product_name"); ?></th>
                        <?php } ?>
                        <th style="text-align:center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("quantity_sale_order"); ?></th>
                        <th style="text-align:center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("quantity"); ?></th>
                        <th style="text-align:center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("quantity_delivered"); ?></th>
                        <th style="text-align:center; vertical-align:middle;font-size:12px !important;"><?php echo $this->lang->line("balance_delivered"); ?></th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $r = 1;
                    foreach ($rows as $row): ?>

                        <tr height="40px" class="tbodyStyle">
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $r; ?></td>
                            <?php if($setting->show_code==0){ ?>
                                <td style="vertical-align:middle;"><?php echo $row->product_name; ?></td>
                            <?php }else if($setting->separate_code==0){ ?>
                                <td style="vertical-align:middle; padding-left : 10px !important;"><?php echo $row->product_name . " (" . $row->code . ")"; ?></td>
                            <?php }else{ ?>
                                <td style="vertical-align:middle;"><?php echo $row->code; ?></td>
                                <td style="vertical-align:middle;"><?php echo $row->product_name; ?></td>
                            <?php } ?>
                            <td style="width: 70px; text-align:center; vertical-align:middle;">
                                <?= $this->erp->formatQuantity($row->ord_qty);?>
                            </td>
                            <td style="width: 70px; text-align:center; vertical-align:middle;">
                                <?= $this->erp->formatQuantity($row->begining_balance);?>
                            </td>
                            <td style="width: 70px; text-align:center; vertical-align:middle;"><?php echo $this->erp->formatQuantity($row->quantity_received); ?></td>
                            <td style="width: 70px; text-align:center; vertical-align:middle;">
                                <?php
                                echo $this->erp->formatQuantity($row->ending_balance);
                                ?>
                            </td>
                        </tr>
                        <?php
                        $totalQtyOrder += $row->ord_qty;
                        $totalQty += $row->begining_balance;
                        $totalrecceivedQty += $row->quantity_received;
                        $totalQtyEnding += $row->ending_balance;
                        $r++;
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot class="text-center">
                    <tr height="40px">
                        <?php
                        $col = 3;
                        if($setting->separate_code == 0){
                            $col = 2;
                        }
                        ?>
                        <td colspan="<?= $col;?>" class="text-right" style="padding-right: 5px !important;">
                            <strong><?php echo $this->lang->line("total"); ?></strong>
                        </td>
                        <td><?= $this->erp->formatQuantity($totalQtyOrder);?></td>
                        <td><?= $this->erp->formatQuantity($totalQty);?></td>
                        <td><?= $this->erp->formatQuantity($totalrecceivedQty);?></td>
                        <td><?= $this->erp->formatQuantity($totalQtyEnding);?></td>
                    </tr>
                    </tfoot>

                </table>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <p style="margin-bottom:30px;"><b>*កំណត់សំគាល់ :</b> រាល់ការទទួលទំនិញ សូមមេត្តាពិនិត្យអោយបានត្រឹមត្រូវ</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p style="height:50px;"><?= lang("prepared_by"); ?>
                        : <?= $user->first_name . ' ' . $user->last_name; ?> </p>
                    <hr>
                    <p><?= lang("ហត្ថលេខា & ស្នាមមេដៃ"); ?></p>
                </div>
                <div class="col-xs-4">
                    <p style="height:50px;text-align:center;"><?= lang("delivered_by"); ?>:
                        <span><?php echo $row->name; ?></span> </p>
                    <hr>
                    <p style="text-align:center;"><?= lang("ហត្ថលេខា & ស្នាមមេដៃ"); ?></p>
                </div>
                <div class="col-xs-4">
                    <p style="height:50px;text-align:center;"><?= lang("received_by"); ?>: </p>
                    <hr>
                    <p style="text-align:center;"><?= lang("ហត្ថលេខា & ស្នាមមេដៃ"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

