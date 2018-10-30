
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice&nbsp;<?= $invs->reference_no ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?php echo $assets ?>styles/style.css" rel="stylesheet">


</head>
<style>
    body{
        font-size:14px;
    }
    table tbody tr th{
        font-size:20px;
    }
    @media print{
        .bd{
            width:100% !important;
        }
        .md{
            margin:30px 0px;
        }
        .mdg{
            margin-bottom:0px !important;
        }
        .com b{
            font-size:10px !important;
        }
        .bd{
            width:100% !important;
            margin-left : 0px !important;
        }
        .modal-content, .modal-body{
            border:none !important;
        }
        #table_header{
            font-size : 12px !important;
        }
        #th-header, #logo{
            font-size : 12px !important;
        }
        #logo{
            font-size : 12px !important;
        }
        #phone{
            font-size : 10px !important;
        }
    }
</style>
<div class="modal-dialog modal-md no-modal-header bd">
    <div class="modal-content"> <div class="modal-body">

            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();"> 	  <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>

            <div class="container" style="margin-bottom:50px">
                <div class="col-sm-12 col-xs-12 text-center "style="margin-bottom:20px;" id = "logo">
                    <?php if ($logo) { ?>
                        <div class="text-center" style="margin-bottom:20px;">
                            <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                        </div>
                    <?php } ?>
                    <?= $biller->address?>
                    <br> Tel : <span style="text-align: justify;" id = "phone"> <?= $biller->phone?> </span>
                </div>
                <!-- <table class="col-md-12 col-sm-12 col-xs-12" id= "table_header">
				<tbody>
					<tr>
						<td class="col-md-2 col-sm-2 col-xs-2"style="padding:0px;"><?= lang('date')?>:</td>
						<td class="col-md-4 col-sm-3 col-xs-4"style="padding-right:0px"><?= $sale_order->date?></td>
						<td class="col-md-2 col-sm-2 col-xs-2 "><?=lang('customers')?>:</td>
						<td class="col-md-4 col-sm-5 col-xs-4 text-right" style="padding:0px;"><?= $customer->name?></td>
					</tr>
					<tr>
						<td class="col-md-2 col-sm-2 col-xs-2" style="padding:0px;"><?= lang('order_no')?>:</td>
						<td class="col-md-4 col-sm-3 col-xs-4"><?= $sale_order->reference_no?></td>
						<td class="col-md-2 col-sm-2 col-xs-2 "><?=lang('saleman')?>:</td>
						<td class="col-md-4 col-sm-5 col-xs-4  text-right" style="padding:0px;"><?= $saleman->first_name;?>&nbsp;<?= $saleman->last_name;?></td> </tr>
					<tr>
						<!-- <td class="col-md-2 col-sm-2 col-xs-2" style="padding:0px;"><?= lang('driver')?>&nbsp;&nbsp;:</td>
						<td class="col-md-4 col-sm-3 col-xs-4"><?= $driver->name; ?></td>
						<td class="col-md-2 col-sm-2 col-xs-2" style="padding:0px;"><?=lang('username')?>:</td>
						<td class="col-md-4 col-sm-3 col-xs-4" ><?= $user->username?></td> </tr>
				</tbody>
			</table> -->
                <div class="row" style = "font-size : 13px !important; margin-left : 15px !important;">
                    <div>
                        <div class="col-xs-5">
                            <?= lang('date')?> :
                        </div>
                        <div class="col-xs-7">
                            <?= date('Y-m-d', strtotime($inv->date)); ?>
                        </div>
                    </div>
                    <div>
                        <div class="col-xs-5">
                            <?= lang('order_no')?> :
                        </div>
                        <div class="col-xs-7">
                            <?= $inv->reference_no; ?>
                        </div>
                    </div>
                    <div>
                        <div class="col-xs-5">
                            <?= lang('customers')?> :
                        </div>
                        <div class="col-xs-7">
                            <?= trim($customer->name); ?>
                        </div>
                    </div>
                    <div>
                        <div class="col-xs-5">
                            <?=lang('saleman')?> :
                        </div>
                        <div class="col-xs-7">
                            <?= $saleman->first_name;?>&nbsp;<?= $saleman->last_name;?>
                        </div>
                    </div>
                </div>
                <table border="1px" class="col-md-12 col-sm-12 col-xs-12"style="margin-top:20px;" id="th-header">
                    <thead>
                    <tr bgcolor="gray">
                        <th class="text-center"><?=lang('no')?></th>
                        <th class="text-center"><?=lang('description')?></th>
                        <th class="text-center"><?=lang('quantity')?></th>
                        <th class="text-center"><?=lang('balance_delivered')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $total_qty = '';
                    foreach($rows as $data){
                        $total_qty += $data->quantity;
                        $total_qty_balance += ($data->quantity - $data->quantity_received);

                        ?>
                        <tr>
                            <td class="text-center"><?= $i?></td>
                            <td style="padding-left:5px;">
                                <?= $data->product_name.' ('.$data->product_code.')'?>
                            </td>
                            <td class="text-center">
                                <?= $this->erp->formatQuantity($data->quantity)?>
                            </td>
                            <td class="text-center">
                                <?= $this->erp->formatQuantity($data->quantity - $data->quantity_received)?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <tr height="22px"> <td class="text-center"></td>
                        <td class="text-center"></td> <td class="text-center"></td><td></td>
                    </tr>
                    <tr height="22px">
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2" class="text-right" style="padding-right:5px;">
                            <?=lang('total_qty')?>
                        </th>
                        <th class="text-center"><?= $this->erp->formatQuantity($total_qty)?></th>
                        <th class="text-center"><?= $this->erp->formatQuantity($total_qty_balance)?></th>
                    </tr>
                    </tfoot>
                </table>
            </div> </div> </div> </div>