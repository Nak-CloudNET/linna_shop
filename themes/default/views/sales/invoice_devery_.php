<!doctype>
<html>
	<head>
		<title>RULE</title>
		<meta charset="utf-8">
		<style>
			@media print{
			
				#tb tr th{
					background-color: #DCDCDC !important;
				}
				#body{
					width:1000px;
					height:100%;
					margin:0 auto;
					background:#fff !important;
				}
				#print{
					display:none;
				}
				#foot{
					width:100%;
					background:#fff !important;
				}	
				.fon{
					color: rgba(0, 0, 0, 0.3) !important;
				}
				.left_ch{
					 left: 80px !important;
				}
			}
			#print{
				
				width:60px;
				height:45px;
				border:0px;
				background: #4169E1;
				color:#fff;
				cursor:pointer;
				-webkit-box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.75);
box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.75);
			}
			#body,h2,h3,h4,h5,p{
				margin:0px;
				padding:5px;
				
			}
			
			#body{
				width:95%;
				height:100%;
				margin:0 auto;
				background:#F0F8FF;
				
				
			}		

		
			#top{
				width:95%;
				height:100px;
				margin:0 auto;
				
				padding-top:20px;
			}
			#top_l{
				width:220px;
				float:left;
			}
			#top_r{
				width:200px;
				float:right;
				text-align:center;
			}
			h1,h2,h3,h4{
				font-family:"Khmer OS Muol";
			}
			
			p{
				font-size:15px;
				font-family:"Arial Narrow";
			}
			#top2{
				width:95%;
				margin:0 auto;
				text-align:center;
				height:420px;
				
				margin-bottom:10px;
			}
			#top2_l{
				width:30%;
				margin:0 auto;
				text-align:center;
				
				float:left;
				height:150px;
			}
			#top2_c{
				width:30%;
				margin:0 auto;
				text-align:center;
				height:150px;
				
				float:left;
			}
			#top2_r{
				width:30%;
				margin:0 auto;
				text-align:center;
				
				float:left;
				height:210px;
			}
			#top2 h5{
				font-family:"Khmer OS Muol";
			}
			#tb tr th{
				font-size:16px;
				padding:5px;
				font-family:"Arial Narrow";
				 font-weight: bold;
			}
			#tb tr td{
					font-size:15px;
					padding:4px;
					font-family:"Arial Narrow";
				}
				#tb {
					width:98%;
					margin:0 auto;
				}
				#foot{
				width:100%;
				height:150px;
				background:#F0F8FF;	
			}		
			#tb2 tr td,#tb3 tr td{
				font-size:15px;
				border-radius:20px;
				font-family:"Arial Narrow";
				text-align:left;
				padding-left:10px;
			}
			
		</style>
	</head>
	<body>
	
	<div id="body">	
	<button id="print" onclick="window.print()">
		<img src="<?= base_url() . 'assets/uploads/printer.png'; ?>">
	</button>
		<div class="left_ch" style="
		width:700px;
		text-align:center;
		 position: absolute;
    left: 300px;
    top: 580px;
		z-index:1;
	-webkit-transform: rotate(350deg);
-moz-transform: rotate(350deg);
-o-transform: rotate(350deg);
writing-mode: lr-tb;
		">
			<span class="fon" style="font-size:40px;font-family:Khmer OS;
color: rgba(0, 0, 0, 0.3);
			" >វិក័យប័ត្រនេះមិនអាចប្រកាសជា<br>បន្ទុកចំណាយបានទេ</span>
		</div>
		
		<div id="top2">
			<!--<h1>ខេ អិន អិន លក់ រថយន្ដ និង គ្រឿងចក្រ</h1>
			<h1>KNN Cambodia Co., Ltd (KNN Group)</h1>-->
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<h2>វិក័យប័ត្រ</h2>
			<h2>Invoice</h2>
			<br>
			<div style="float:left; width:50%;border-radius: 10px 10px 10px 10px;
-moz-border-radius: 10px 10px 10px 10px;
-webkit-border-radius: 10px 10px 10px 10px;
border: 1px solid #000000;">
				<table id="tb2" style=" width:100%;">
					<tr>
						<td>Customer</td>
						<td>: <?=$invs->company;?></td>
					</tr>
					<tr>
						<td>Address</td>
						<td>: <?=$invs->address;?></td>
					</tr>
					<tr>
						<td>Tel</td>
						<td>: <?=$invs->phone;?></td>
					</tr>
					<tr>
						<td>Model</td>
						<td>: </td>
					</tr>
					<tr>
						<td>Time</td>
						<td>: <?= date('H:II')?></td>
					</tr>
				</table>
			</div>
			<div style="float:right; width:40%;border-radius: 10px 10px 10px 10px;
-moz-border-radius: 10px 10px 10px 10px;
-webkit-border-radius: 10px 10px 10px 10px;
border: 1px solid #000000;">
				<table id="tb3" style=" width:100%;">
					<tr>
						<td>From</td>
						<td>: <?=$bill->biller;?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td>: <?=$this->erp->hrsd($bill->date);?></td>
					</tr>
					<!--<tr>
						<td>lnv. No</td>
						<td>: <?=$bill->reference_no;?></td>
					</tr>
					<tr>
						<td>VAT</td>
						<td>:  <?=$bill->vat_no;?></td>
					</tr>
					<tr>
						<td>Division</td>
						<td>: </td>
					</tr>-->
				</table>
			</div>
			
			</div>
			
			<table id="tb" style="border-collapse: collapse;text-align:center;" border="1" >
				<tr>
					<th style="text-align:center;">Item<br>ប្រការ</th>
					<th style="text-align:center;">Delivery Date<br>ថ្ងៃបញ្ចេញទំនិញ</th>
					<th style="text-align:center;">Typer of Concrete <br>ប្រភេទ</th>
					<th style="text-align:center;">Quantity<br>ចំនួន</th>
					<th style="text-align:center;">Unit Price<br>តំលៃរាយ</th>
					<th style="text-align:center;">Amount<br>តំលៃសរុប</th>
					
				</tr>
				<?php 
				$i = 1;
				$stotal = 0;
				$tqty = 0;
					foreach($rows as $row){
						
					
				?>
				<tr>
					<td><?=$i?></td>
					<td><?=$this->erp->hrsd($row->date);?></td>
					<td style="text-align:left;"><?=$row->product_name?></td>
					<td><?=$this->erp->formatDecimal($row->quantity_received);?></td>
					<td><?=$this->erp->formatMoney($row->unit_price)?> $</td>
					<td style="text-align:right;"><?=$this->erp->formatMoney($row->quantity_received*$row->unit_price)?> $</td>
					
					
				</tr>
				<?php
				$i++;
				$tqty +=$row->quantity_received;
				$stotal +=$row->quantity_received*$row->unit_price;
					}
					for($k = 0;$k<7;$k++){
				?>
				<tr class="blank">
					<td><?=$i?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right;">$</td>
				</tr>
				
				<?php 
				$i++;
					}
					?>
				<tr>
				
					<td colspan="2" rowspan="3"><?=$invs->invoice_footer;?></td>
					<td  style="text-align:right;">សរុប Sub Total</td>
					<td ><?=$this->erp->formatDecimal($tqty);?></td>
					<td></td>
					
					<td  style="text-align:right;"><?=$this->erp->formatMoney($stotal);?> $</td>
					
				</tr>
				<tr>
					<td  colspan="3" style="text-align:right;">ចំនួនទឹកប្រាក់ដែលមិនទាន់បានបង់ពីមុន<br> unpaid previous period  USD</td>
					<td   ></td>
					
				</tr>
				<tr>
					<td  colspan="3"​ style="text-align:right;" >ចំនួនទឹកប្រាក់សរុប<br> grand total  USD</td>
					<td   style="text-align:right;" ><?=$this->erp->formatMoney($stotal);?> $</td>
					
				</tr>
			
			</table>
			<p>Remark: The invoice above is excluding 10% VAT.</p>
			<p>ផ្សេងៗ៖ តំលៃខាងលើមិនបូករួមពន្ធ 10% នៃ VAT</p>
			<br>
			<div id="foot">
			<div id="top2_l">
				<p>ហត្ថលេខាអ្នកទទួល</p>
				<p>Received By :</p>
			</div>
			
			<!--<div id="top2_c">
				<p>បានពិនិត្យ ត្រឹមត្រូវ</p>
				<p>ប្រធានការិយាល័យគណនេយ្យ</p>
			</div>
			<div id="top2_c">
				<p>អ្នកគ្រប់គ្រងស្ដុក</p>
				
			</div>-->
			<div id="top2_c">
			<p>អនុម័តដោយ</p>
				<p>Approved By :</p>
				
			</div>
			<div id="top2_r">
				<p>គនេយ្យ</p>
				<p>Accountant By:</p>
			</div>
			</div>
		</div>
	</div>	
		
	</body>
</html>