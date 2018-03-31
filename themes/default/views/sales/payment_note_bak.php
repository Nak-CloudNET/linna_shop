<style type="text/css">
    @media print {
        #myModal .modal-content {
            display: none !important;
        }
    }
</style>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body print">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
			<button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <?php if ($logo) { ?>
                <div class="text-center" style="margin-bottom:20px;">
                <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                     alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-6">
                    <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                    <?= $biller->company ? "" : "Attn: " . $biller->name ?>
                    <?php
                    echo $biller->address . " " . $biller->city . " " . $biller->postal_code . " " . $biller->state . " " . $biller->country;
/*                    echo "<p>";
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
*/
					echo "<br/>";
                    echo lang("tel") . ": " . $biller->phone . "<br />" . lang("email") . ": " . $biller->email;
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-6">
                    <h2 class=""><?= $customer->company ? $customer->company : $customer->name; ?></h2>
                    <?= $customer->company ? "" : "Attn: " . $customer->name ?>
                    <?php
                    echo $customer->address . " " . $customer->city . " " . $customer->postal_code . " " . $customer->state . " " . $customer->country;
/*                    echo "<p>";
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
*/
					echo "<br/>";
                    echo lang("tel") . ": " . $customer->phone . "<br />" . lang("email") . ": " . $customer->email;
                    ?>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <p style="font-weight:bold;"><?= lang("payment_reference"); ?>: <?= $payment->reference_no; ?></p>
                </div>
				<div class="col-sm-6 text-right">
                    <p style="font-weight:bold;"><?= lang("date"); ?>: <?= $this->erp->hrsd($payment->date); ?></p>
                </div>
            </div>
            <div class="well">
                <table class="table table-borderless" style="margin-bottom:0;">
                    <tbody>
                    <tr>
						<tr>
							<td>
								<strong><?= lang("current_balance"); ?></strong>
							</td>
							<td><strong> : <?php echo $this->erp->formatMoney($curr_balance); ?></strong></td>
						</tr>
						
						<?php if($payment->extra_paid != 0) { ?>
						<tr>
							<td>
								<strong><?= lang("paid"); ?></strong>
							</td>
							<td><strong> : <?php echo $this->erp->formatMoney(($payment->amount-$payment->extra_paid)); ?></strong></td>
						</tr>
						<tr>
							<td>
								<strong><?= lang("extra_paid"); ?></strong>
							</td>
							<td><strong> : <?php echo $this->erp->formatMoney($payment->extra_paid); ?></strong></td>
						</tr>
						<?php } ?>
                        <td width="25%">
                            <strong><?= $payment->type == 'returned' ? lang("payment_returned") : lang("payment_received"); ?></strong>
                        </td>
                        <td>
							<strong> : 
								<?php echo '$ '. $this->erp->formatMoney($payment->amount) .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '. $this->erp->convert_number_to_words(($this->erp->fraction($payment->amount) > 0)? $this->erp->formatMoney($payment->amount) : number_format($payment->amount)) .' dolar )'; ?>
							</strong>
                        </td>
						<tr>
							<td>
								<strong><?= lang("balance"); ?></strong>
							</td>
							<td><strong> : <?php echo $this->erp->formatMoney($curr_balance - ($payment->amount - $payment->extra_paid)); ?></strong></td>
						</tr>
                    </tr>
                    <tr>
                        <td><strong><?= lang("paid_by"); ?></strong></td>
                        <td>
							<strong> : 
								<?php echo lang($payment->paid_by);
									if ($payment->paid_by == 'gift_card' || $payment->paid_by == 'CC') {
										echo ' (' . $payment->cc_no . ')';
									} elseif ($payment->paid_by == 'Cheque') {
										echo ' (' . $payment->cheque_no . ')';
									}
                                ?>
							</strong>
						</td>
                    </tr>

					 <tr>
                        <td>
                            <strong><?= lang("note"); ?></strong>
                        </td>
                        <td><strong><?php echo $payment->note; ?></strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="clear: both;"></div>
            <div class="row">
				<div class="col-sm-4 pull-left">
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p style="border-bottom: 1px solid #666;">&nbsp;</p>

                    <p><?= lang("customer_signature"); ?></p>
                </div>
				<div class="col-sm-4 pull-left">
                </div>
                <div class="col-sm-4 pull-left">
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p style="border-bottom: 1px solid #666;">&nbsp;</p>

                    <p><?= lang("receiver_signature"); ?></p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>