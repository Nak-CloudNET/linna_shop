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
	.container{
		font-family:My
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
    
	<div class="row">
		<div class="col-sm-2 col-xs-12" style="background-color:lavender;">
			Logo
		</div>
		<div class="col-sm-8 col-xs-12">
			<center>
				<h3 style="font-family:khmer Os Moul light !important;">សិលា ផិបភើរ ខូអិលធីឌី</h3>
				<div>
					<p>លេខអត្តសញ្ញាណកម្ម អតប</p>
					<p>អាស័យដ្ខាន​ </p>
				</div>
			</center>
		</div>
		<div class="col-sm-2 col-xs-12"></div>
    </div>
	<div style="border-bottom: 2px solid green !important;"></div>
	<center>
		<h4 style="font-family:khmer Os Moul light !important;">វិក័យបត្រ</h4>
		<h4>Commercial Invoice</h4>
	</center>
	<div class="row">
		<div class="col-sm-6 col-xs-6">
			<div class="row">
				<p>ឈ្មោះក្រុមហ៊ុន ឬ អតិថិន:&nbsp;&nbsp;Saothan </p>
				<p>Company/Customer Name:&nbsp;&nbsp;Saothan</p>
				<p>អាស័យដ្ខាន​&nbsp;&nbsp;:ភ្នំពេញ</p>
				<p>Address:&nbsp;&nbsp;Phnom Penh</p>
				<p>អ្នកទំនាក់ទំនង/<br> Contact Person:&nbsp;&nbsp;Dara</p>
			
				
			</div>
		</div>
		<div class="col-sm-6 col-xs-6" style="margin-right:-1px !important;">
			<div class="row">
			<p>លេខអត្តសញ្ញាណកម្មសារពើពន្ធ/VAT TIN:&nbsp;&nbsp;112255522225</p>
			<p>លេខរៀង/No:&nbsp;&nbsp;TDD000001</p>
			<p>កាលបរិច្ឆេទ/Date​:&nbsp;&nbsp;12-Jun-2018</p>  
			<p>យោង/Ref:&nbsp;&nbsp;2333666</p>
			<p>ទូរស័ព្ទលេខ/Telephone No:&nbsp;&nbsp;096 333 9498</p>
		
			</div>
		</div>
	</div> 
		<table class="table">
				<tr>
					<th>ល.រ<br>No</th>
					<th>បរិយាយមុខទំនិញ<br>Description</th>
					<th>លេខកូដ<br>Code</th>
					<th>បរិមាណ<br>Qty/Kg</th>
					<th>ថ្លៃឯកតា<br>Unit Price</th>
					<th>បញ្ជុះតម្លៃ<br>Discount</th>
					<th>ថ្លៃទំនិញ<br>Amount</th>
				</tr>
				<tr>
					<td>1</td>
					<td>Apple</td>
					<td>1236</td>
					<td>10</td>
					<td>$1500</td>
					<td>10%</td>
					<td>$15000000</td>
				</tr>
				
		</table>
		
		<tfoot>
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<p>ហត្ថលេខា និងឈ្មោះអ្នកទទួល<br>Buy's Signature and Name</p>
				</div>
				<div class="col-sm-4 col-xs-12"></div>
				<div class="col-sm-4 col-xs-12">
					<p>ហត្ថលេខា និងឈ្មោះអ្នកលក់<br>Authoized Signature and Name</p>
				</div>
			</div>
			<div class="row">
				<center>
				<div class="col-sm-12 col-xs-12" style="background-color:green !important; color:white !important;font-family:Myriad Pro !important;">Tel.(855) 23 986 101 / Fax (855) 23 986 103/ Email: sopha@selapepper.com/ Website:www.selapepper.com</div>
				</center>
			</div>
		</tfoot>
</div>
</body>
</html>