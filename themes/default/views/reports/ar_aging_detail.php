<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale by item Detail</title>

    <link href="<?php echo $assets ?>styles/bootstrap.min.css" rel="stylesheet">


    <style>

        .header tr{
            width: 100%;
            text-align: center;

        }

        .line_op{
            position: relative;
            text-align: right;
        }
        .line_op:after{
            position: absolute;
            content: '';
            width: 80%;
            border-top: 1px solid black ;
            top: 0px;
            right: 0px;
        }
        .lp{
            position: relative;
            text-align: right;
        }
        .lp:after{
            position: absolute;
            content: '';
            width: 80%;
            /*border-bottom: 3px double black ;*/
            /*buttom: -150px;*/
            border-bottom-style: double;
            right: 0px;
            height: 80%;
            /*background: red;*/
        }
        .lp:before{
            position: absolute;
            content: '';
            width: 80%;
            border-bottom: 1px solid black ;
            /*buttom: 0px;*/
            right: 0px;
            top: 0%;
        }
    </style>
</head>
<body>
<div class="container">
    <table class="header" width="100%">
        <tr>
            <td><span style="font-size: 15px; font-weight: bold ">Golden Company</span></td>
        </tr>
        <tr>
            <td><span style="font-size: 18px; font-weight: bold ">A/R Aging Detail</span></td>
        </tr>
        <tr><td><span style="font-size: 13px; font-weight: 200 ">August 1 - 23,2018</span></td></tr>
    </table>
    <br>
    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>

            <td>Type</td>
            <td>Date</td>
            <td>Num</td>
            <td>P.O.#</td>
            <td>Name</td>
            <td>Term</td>
            <td>Due Date</td>
            <td>Aging</td>
            <td>Open Balance</td>
            <td>Action</td>

        </tr>
        </thead>
        <tbody>
        <tr><td colspan="10" >1-30</td></tr>

        <tr>

            <td>Invoice</td>
            <td>01/02/2016</td>
            <td>1</td>
            <td>Memo here</td>
            <td>Mr Rak</td>
            <td style="text-align: right">4 &nbsp;</td>
            <td style="text-align: right">10.00 &nbsp;</td>
            <td style="text-align: right">200.00 &nbsp;</td>
            <td style="text-align: right">200.00 &nbsp;</td>
            <td class="text-center" rowspan="1  "><a href="#" class="btn1">View</a></td>

        </tr>
        <tr>

            <td>Invoice</td>
            <td>01/02/2016</td>
            <td>1</td>
            <td>Memo here</td>
            <td>Mr Rak</td>
            <td style="text-align: right">4 &nbsp;</td>
            <td style="text-align: right">10.00 &nbsp;</td>
            <td style="text-align: right">200.00 &nbsp;</td>
            <td style="text-align: right">200.00 &nbsp;</td>
            <td class="text-center" rowspan="1  "><a href="#" class="btn1">View</a></td>

        </tr>

        <tr>

            <td>Invoice</td>
            <td>01/02/2016</td>
            <td>1</td>
            <td>Memo here</td>
            <td>Mr Rak</td>
            <td style="text-align: right">4 &nbsp;</td>
            <td style="text-align: right">10.00 &nbsp;</td>
            <td style="text-align: right">200.00 &nbsp;</td>
            <td style="text-align: right">200.00 &nbsp;</td>
            <td class="text-center" rowspan="1  "><a href="#" class="btn1">View</a></td>

        </tr>
        <tr style=""><td colspan="8" style="">Total 1-30</td><td class="text-right line_op" style="border: none;">200.00 &nbsp;</td><td></td></tr>


        <tr style=""><td colspan="8" style="border: none"><b>Total</b></td><td class="text-right line_op1 lp" >200.00 &nbsp;</td><td></td></tr>

        </tbody>
    </table>
</div>
</body>
</html>