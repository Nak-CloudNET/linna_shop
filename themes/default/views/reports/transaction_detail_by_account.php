<?php
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-th-large"></i><?= lang('transaction_detail_by_acount'); ?><?php
            if ($this->input->post('start_date')) {
                echo " From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                            class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                            class="icon fa fa-toggle-down"></i></a></li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>"><i
                            class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>"><i
                            class="icon fa fa-file-excel-o"></i></a></li>
                <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                            class="icon fa fa-file-picture-o"></i></a></li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("billers") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= site_url('reports/transaction_detail') ?>"><i class="fa fa-building-o"></i> <?= lang('billers') ?></a></li>
                        <li class="divider"></li>
                        <?php
                            foreach ($billers as $biller) {
                                echo '<li ' . ($biller_id && $biller_id == $biller->id ? 'class="active"' : '') . '>
                                        <a href="' . site_url('reports/transaction_detail/0/0/' . $biller->id) . '"><i class="fa fa-building"></i>' . $biller->company . '</a></li>';
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div id="form">
                    <?php echo form_open("reports/transaction_detail/".$v_form); ?>
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="user"><?= lang("account_name"); ?></label>
                                <?php
                                $code = $this->db;
                                $accOption = $code->select('*')->from('gl_charts')->get()->result();
                                $accountArray[""] = " ";
                                foreach ($accOption as $a) {
                                    $accountArray[$a->accountcode] = $a->accountcode . " " . $a->accountname;
                                }
                                echo form_dropdown('account', $accountArray, (isset($v_account) ? $v_account : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("account") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($start_date) ? $start_date : ""), 'class="form-control datetime" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($end_date) ? $end_date : ""), 'class="form-control datetime" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls"> <?php echo form_submit('', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="clearfix"></div>

                <div class="table-scroll">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th><?= lang('type'); ?></th>
                                <th style="width:150px;"><?= lang('Num');?></th>
                                <th style="width:150px;"><?= lang('class'); ?></th>
                                <th style="width:150px;"><?= lang('name'); ?></th>
                                <th style="width:200px;"><?= lang('item'); ?></th>
                                <th style="width:150px;"><?= lang('inventory');?></th>
                                <th style="width:250px;"><?= lang('Qty'); ?></th>
                                <th style="width:50px;"><?= lang('sales_person'); ?></th>
                                <th style="width:150px;"><?= lang('debit'); ?></th>
                                <th style="width:150px;"><?= lang('cre0dit'); ?></th>
                                <th style="width:150px;"><?= lang('balance');?></th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $code = $this->db;
                            $code->select('*')->from('gl_charts');
                            if ($v_account) {
                                $code->where('accountcode', $v_account);
                            }
                           // echo $start_date.$end_date;exit();
                            $accounts = $code->get()->result();                         
                            foreach($accounts as $account){                             
                                $startAmount = $this->db->select('sum(amount) as startAmount')
                                                   ->from('gl_trans')
                                                   ->where(
                                                        array(
                                                            'account_code'=> $account->accountcode
                                                            )
                                                        )
                                    ->where('date(erp_gl_trans.tran_date) =', $this->erp->fld($start_date))
                                    ->where('date(erp_gl_trans.tran_date) <=', $this->erp->fld($end_date));
                                    $this->db->get()->row();

                                $endAccountBalance = 0.00;
                                $endAccountBalanceMinus = 0;
                                $glTrans = $this->db->select("
                                    erp_gl_trans.*, (
                                        CASE
                                        WHEN erp_gl_trans.amount > 0 THEN
                                            erp_gl_trans.amount
                                        END
                                    ) AS am1,
                                    (
                                        CASE
                                        WHEN erp_gl_trans.amount < 0 THEN
                                            erp_gl_trans.amount
                                        END
                                    ) AS am2,
                                    erp_companies.company,
                                    (
                                        CASE
                                        WHEN erp_gl_trans.tran_type = 'SALES' THEN
                                
                                        IF (
                                            erp_gl_trans.bank = '1',
                                            (
                                                SELECT
                                                    erp_companies.company
                                                FROM
                                                    erp_payments
                                                INNER JOIN erp_sales ON erp_sales.id = erp_payments.sale_id
                                                INNER JOIN erp_companies ON erp_companies.id = erp_sales.customer_id
                                                WHERE
                                                    erp_payments.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            ),
                                            (
                                                SELECT
                                                    erp_companies.company
                                                FROM
                                                    erp_sales
                                                INNER JOIN erp_companies ON erp_companies.id = erp_sales.customer_id
                                                WHERE
                                                    erp_sales.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            )
                                        )
                                        WHEN erp_gl_trans.tran_type = 'PURCHASES'
                                        OR erp_gl_trans.tran_type = 'PURCHASE EXPENSE' THEN
                                
                                        IF (
                                            erp_gl_trans.bank = 1,
                                            (
                                                SELECT
                                                    erp_companies.company
                                                FROM
                                                    erp_payments
                                                INNER JOIN erp_purchases ON erp_purchases.id = erp_payments.purchase_id
                                                INNER JOIN erp_companies ON erp_companies.id = erp_purchases.supplier_id
                                                WHERE
                                                    erp_payments.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            ),
                                            (
                                                SELECT
                                                    erp_companies.company
                                                FROM
                                                    erp_purchases
                                                INNER JOIN erp_companies ON erp_companies.id = erp_purchases.supplier_id
                                                WHERE
                                                    erp_purchases.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            )
                                        )
                                        WHEN erp_gl_trans.tran_type = 'SALES-RETURN' THEN
                                            (
                                                SELECT
                                                    erp_return_sales.customer
                                                FROM
                                                    erp_return_sales
                                                WHERE
                                                    erp_return_sales.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            )
                                        WHEN erp_gl_trans.tran_type = 'PURCHASES-RETURN' THEN
                                            (
                                                SELECT
                                                    erp_return_purchases.supplier
                                                FROM
                                                    erp_return_purchases
                                                WHERE
                                                    erp_return_purchases.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            )
                                        WHEN erp_gl_trans.tran_type = 'DELIVERY' THEN
                                            (
                                                SELECT
                                                    erp_companies.company AS customer
                                                FROM
                                                    erp_deliveries
                                                INNER JOIN erp_companies ON erp_companies.id = erp_deliveries.customer_id
                                                WHERE
                                                    erp_deliveries.do_reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            )
                                        WHEN erp_gl_trans.tran_type = 'PRINCIPLE' THEN
                                            (
                                                SELECT
                                                    erp_companies.company
                                                FROM
                                                    erp_payments
                                                LEFT JOIN erp_loans ON erp_loans.id = erp_payments.loan_id
                                                INNER JOIN erp_sales ON erp_loans.sale_id = erp_sales.id
                                                INNER JOIN erp_companies ON erp_companies.id = erp_sales.customer_id
                                                WHERE
                                                    erp_payments.reference_no = erp_gl_trans.reference_no
                                                LIMIT 0,
                                                1
                                            )
                                        ELSE
                                            created_name
                                        END
                                    ) AS NAME,
                                    erp_users.username,
                                    erp_products.product_details AS product_inventory,
                                    erp_products.name AS pro_name,
                                    erp_products.code AS pro_code,
                                    (erp_companies. NAME) AS product_name,
                                    erp_gl_charts.inventory,
                                    erp_stock_trans.quantity_balance_unit,
                                    (erp_companies. NAME) AS biller_name    
                                ")
                                ->from('gl_trans')
                                ->join('stock_trans','gl_trans.product_id = stock_trans.product_id and gl_trans.reference_no = stock_trans.reference', 'left')
                                ->join('products','products.id = gl_trans.product_id', 'left')
                                ->join('companies','companies.id=gl_trans.biller_id')
                                ->join('users', 'users.id = gl_trans.created_by', 'left')
                                ->join('erp_gl_charts','erp_gl_charts.accountcode = erp_gl_trans.account_code','left')
                                ->order_by('tran_date', 'asc')
                                ->where('account_code', $account->accountcode);
                                
                                if ($start_date) {
                                    $glTrans->where('date(erp_gl_trans.tran_date) >=', $this->erp->fld($start_date));
                                }
                                if ($end_date) {
                                    $glTrans->where('date(erp_gl_trans.tran_date) <=', $this->erp->fld($end_date));
                                }
                                
                                if($biller_id != ""){
                                    $glTrans->where_in('gl_trans.biller_id' ,JSON_decode($biller_id));
                                }

                                $glTranLists = $glTrans->get()->result();
                                if($startAmount->startAmount!=0 || $glTranLists)
                                {
                                    ?>
                                    <tr>
                                    <td colspan="4" style="font-weight: bold;"><?= lang(""); ?> <i

                                                aria-hidden="true"></i> <?= $account->accountcode . '. ' . $account->accountname ?>
                                    </td>

                                    <?php if ($startAmount->startAmount >= 0) { ?>
                                        <td class="right"><?= $startAmount->startAmount ?></td>
                                    <?php } else { ?>
                                        <td class="right"></td>
                                      <?php }
                                }?>
                                </tr>
                                <?php
                                if($glTranLists) {
                                $endAmount = $startAmount->startAmount;
                                if($endAmount>0){
                                    $endDebitAmount = $endAmount;
                                    $endCreditAmount = 0;
                                }else{
                                    $endDebitAmount = 0;
                                    $endCreditAmount = $endAmount;
                                }
                                
                                $endAccountBalance= $startAmount->startAmount;
                                foreach($glTranLists as $gltran)
                                {
                                    //$this->erp->print_arrays($gltran);
                                    $endAccountBalance += $gltran->amount;
                                    $endAccountBalanceMinus = explode('-', $endAccountBalance);
                                    $endAmount += $gltran->amount;
                                    $endDebitAmount+=$gltran->am1;
                                    $endCreditAmount+=$gltran->am2;
                                    ?>
                                    <tr>
                                        <td><?= $gltran->tran_type ?></td>
                                        <td><?= $gltran->reference_no ?></td>
                                        <td><?= ($gltran->biller_name!=''?$gltran->biller_name:$gltran->company) ?></td>
                                        <td><?= ($gltran->name !=''?$gltran->name:$gltran->company)?></td>
                                        <td><?= ($gltran->inventory==1?$gltran->pro_code:'')?></td>
                                        <td><?= ($gltran->inventory==1?$gltran->pro_name:'') ?></td>
                                        <td><?=($gltran->inventory==1? ($gltran->quantity_balance_unit<0?'('.abs($gltran->quantity_balance_unit).')':$gltran->quantity_balance_unit):'') ?></td>
                                        <td><?= ($gltran->inventory==1 || $gltran->tran_type =='SALES'||$gltran->tran_type =='SALES-RETURN'  ?$gltran->username:'') ?></td>
                                        <td class="right"><?= $this->erp->formatdecimal(round($gltran->am1 > 0 ? $gltran->am1 : '0.00',2)); ?></td>
                                        <td class="right"><?= $this->erp->formatdecimal(round($gltran->am2 < 1 ?abs($gltran->am2) : '0.00',2))?></td>
                                        <td class="right"><?=$this->erp->formatdecimal( round($endAccountBalance < 0 ? ' (' . $endAccountBalanceMinus[1] . ')' :($endAccountBalance),2)); ?></td>
                                    </tr>
                                        <?php } ?>

                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="3" style="font-weight: bold;">Ending Account Balance <i class="fa fa-caret-right" aria-hidden="true"></i></td>
                                        <!-- <?php if($endAmount > 0) { ?>
                                            <td class="right"><?= $this->erp->formatdecimal(round(abs($endAmount),2)); ?></td>
                                            <td class="right"></td>
                                            <td class="right"></td>
                                        <?php } else { ?>
                                            <td class="right"></td>
                                            <td class="right"><?= $this->erp->formatdecimal(round(abs($endAmount),2)); ?></td>
                                            <td class="right"></td>
                                        <?php } ?> -->
                                        <td class="right"><?=$this->erp->formatdecimal(round(abs($endDebitAmount),2)); ?></td>
                                        <td class="right"><?=$this->erp->formatdecimal(round(abs($endCreditAmount),2)); ?></td>
                                        <?php if($endAmount > 0) { ?>
                                            <td class="right"><?= $this->erp->formatdecimal(round(abs($endAmount),2)); ?></td>
                                        <?php } else { ?>
                                            <td class="right"><?='('. $this->erp->formatdecimal(round(abs($endAmount),2)).')'; ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php
                                }
                            }
                       ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
</div>
<h1>
    <?php
        if ($v_account) {
            $v .= "&ac=" . $v_account;
        }
    ?>
</h1>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('account/transaction_detail/pdf/0/'.JSON_decode($biller_id) . '?v=1'.$v. '&sd='. $start_date . '&ed='. $end_date)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('account/transaction_detail/0/xls/'.JSON_decode($biller_id) . '?v=1'.$v . '&sd='. $start_date . '&ed='. $end_date)?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL();
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>