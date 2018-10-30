<style type="text/css">
    @media print {
        .total hr {
            border: 1px solid black !important;
        }
        .modal-dialog {
            width: 98% !important;
            height: 842px !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        #myModal .payment {
            display: none !important;
        }
        .modal-content{
            border: none !important;
        }

        .modal-body {
            height: 515px !important;
            padding: 0 !important;
            line-height: 95% !important;
        }
        .table tr td {
            height: 5px !important;
        }
    }
</style>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">

        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <div class="row" style="margin-top: 30px !important;">
                <div class="col-sm-3 col-xs-3 " style="margin-top: 0px !important;">
                    <?php if(empty($biller->logo)) { ?>
                        <img class="img-responsive myhide" src="<?= base_url() ?>assets/uploads/logos/sela_logo_clean.png"id="hidedlo" style="width: 140px; margin-left: 25px;margin-top: -10px;" />
                    <?php } ?>
                </div>
                <div  class="col-sm-9 col-xs-9 company_addr "  style="margin-top: -10px !important;margin-left:-20px !important;">
                    <div class="myhide">
                        <?php if($biller->company_kh) { ?>
                            <h3 class="header" style="color: green !important;font-size: 16px !important;font-family: 'Khmer OS Moul'"><?= $biller->company_kh ?></h3>
                        <?php } ?>
                        <?php if($biller->company) { ?>
                            <h3 class="header" style="color: green !important;font-size: 16px !important;font-family: 'Myriad Pro'"><?= $biller->company ?></h3>
                        <?php } ?>
                        <div style="margin-top: 15px;">
                            <?php if(!empty($biller->cf4)) { ?>
                                <p style="margin-top:-10px !important;white-space: nowrap;font-size: 12px !important;font-family: 'Myriad Pro'">No.<?= $biller->address; ?></p>
                            <?php } ?>

                            <?php if(!empty($biller->email)) { ?>
                                <p style="margin-top:-10px !important;white-space: nowrap;font-size: 12px !important;">E-mail :&nbsp;<?= $biller->email; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border: 1px solid green !important; width: 100% !important;">
            <div class="invoice" style="margin-top:10px;">
                <center>
                    <h4 class="title">បង្កាន់ដៃទទួលប្រាក់</h4>
                    <h4 class="title" style="margin-top: 3px;">OFFICIAL RECIPT</h4>
                </center>

            </div>

                <div class="clearfix"></div>


                <div class="row" style="width: 90%; margin-left: 3%;">
                    <div class="col-sm-5 col-xs-5" style="float:left;">


                        <p><?= lang("កាលវរិច្ឆេទ/ Date"); ?>: <?=$this->erp->hrsd($payment->date); ?></p>
                        <p><?= lang("Seller Name"); ?>: <?= $inv->saleman; ?></p>

                    </div>
                    <div class="col-sm-5 col-xs-5 text-left" style="float:right;">
                        <div class="pull-right">

                            <p><?= lang("លេខបង្កាន់ដៃទទូលប្រាក់ No"); ?>: <?= $payment->reference_no; ?></p>
                            <p><?= lang("យោងលេខវិក័យប័ត្រ INVNo"); ?>: <?= $inv->reference_no; ?></p>

                        </div>
                    </div>
                </div>

            <div class="clear-both">
                <div style="width:100%;height: 200px"></div>
            </div>
            <hr style="border: 1px solid transparent;">
            <hr style="border: 1px solid transparent;">
            <div class="row">
                <div class="col-sm-3 col-xs-3">
                    <p style="font-family: 'Myriad Pro'">បានទទូលពី​ <br> Receive from</p>


                </div>
                <div class="col-sm-9 col-xs-9 total">
                    <?php if (!empty($customer->company)) { ?>
                        <p><?= $customer->company; ?></p>
                        <hr style="border: 1px solid black;">
                    <?php } ?>


                </div>




            </div>
            <div class="clear-both">
                <div style="width:100%;height: 50px"></div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-3">
                    <p style="font-family: 'Myriad Pro'">ទឹកប្រាក់សរុប <br>Total amount</p>


                </div>
                <div class="col-sm-9 col-xs-9 total">
                    <?php if (!empty($payment->amount)) { ?>
                        <p><?= $this->erp->formatMoney($payment->amount) . ' ' . (($payment->attachment) ? '<a href="' . base_url('assets/uploads/' . $payment->attachment) . '" target="_blank"><i class="fa fa-chain"></i></a>' : ''); ?></p>
                        <hr style="border: 1px solid black;">
                    <?php } ?>


                </div>




            </div>
                <div style="clear: both;"></div>
            <div class="clear-both">
                <div style="width:100%;height: 200px"></div>
            </div>
            <div id="footer" class="row" >
                <div class="col-sm-6 col-xs-6">
                    <center>
                        <hr style="margin:0; border:1px solid #000; width: 80%">
                        <p style=" margin-top: 4px !important">ហត្ថលេខា និងឈ្មោះអ្នកទទូល</p>
                        <p style="margin-top:-10px;font-family: 'Myriad Pro'">Prepared's Signature & Name</p>
                    </center>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <center>
                        <hr style="margin:0; border:1px solid #000; width: 80%">
                        <p style=" margin-top: 4px !important">ហត្ថលេខា និងឈ្មោះអ្នកលក់</p>
                        <p style="margin-top:-10px;font-family: 'Myriad Pro' ">Customer's Signature & Name</p>
                    </center>
                </div>
            </div>
            <div class="clear-both">
                <div style="width:100%;height: 50px"></div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p>Note: <br>If paymentis made by cheque, this receipt will be valid when the check is cleared.</p>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12 col-sm-12">
                    <p style="background-color: green !important; text-align: center !important; color: #fff !important;">Tel:(855) 23 986 101/Fax: (855) 23 986 103/ E-mail: sopha@selapepper.com/website: www.selapepper.com</p>
                </div>

            </div>
                <div class="clearfix"></div>
                <hr>

        </div>

    </div>
</div>