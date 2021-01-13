<?php 

ob_start();
include('../config/function.php');
include('MPDF57/mpdf.php');

/* set blank */
$order_id = "";
$html = "";

if(isset($_REQUEST['order_id']) && $_REQUEST['order_id']!="") 
{
	$order_id = $_REQUEST['order_id'];
	$query_select = "SELECT * FROM `orders` WHERE id= '".$order_id."'";
	if($sql_select = $conn->query($query_select))
	{
		if($sql_select->num_rows>0)
		{
			$result = $sql_select->fetch_array(MYSQLI_ASSOC);
			$shipping_id = $result['shipping_id'];
			$ship_name = ucwords($newobject->getdata($conn,"shipping_address","fname","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","lname","id",$shipping_id));
			$ship_address = ucwords($newobject->getdata($conn,"shipping_address","house_no","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","street_no","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","city","id",$shipping_id).' '.$newobject->getdata($conn,"shipping_address","pin_code","id",$shipping_id));
			$user_id = $result['user_id'];
			$invoice_date = date('d M Y');
			$order_date = date('d M Y',strtotime($result['order_date']));
			$query_user = "SELECT * FROM users WHERE id='".$_SESSION['user_id']."' AND email='".$_SESSION['user_name']."'";
			if($sql_user = $conn->query($query_user))
			{
				if($sql_user->num_rows>0)
				{
					$result_user = $sql_user->fetch_array(MYSQLI_ASSOC);
					$name = $result_user['fname'].' '.$result_user['lname'];
					$email = $result_user['email'];
					$phone = $result_user['phone_no'];
				}
			}
			
		}
		else
		{
			echo "<script>document.location.href='order_detail.php';</script>";
			exit;
		}
    }
}

$html .="<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<title>Ramanta invoice</title>
<link rel='stylesheet' media='print' href='https://projects.adsandurl.com/ramanta/assets/css/myprintstyle.css'>
<link href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
<link href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'  media='print'>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap');
body { background:#282828; margin:0; padding:0; font-family:  'Poppins', sans-serif;  font-size:15px; font-weight:400; color:#444; }
 @media screen {
p.bodyText {font-family:  'Poppins', sans-serif;  }
}
 @media print {
p.bodyText {font-family:  'Poppins', sans-serif;  }
}
</style>
</head>
<body>
<div style='width:800px; margin:50px auto;'>
  <div class='invoicearea' style='padding:10px; background:#fff; width:100%; float:left; '>
    <div style='margin-bottom:25px; clear:both; width:100%;'>
      <div style='float:left; width:250px;'> <img src='https://projects.adsandurl.com/ramanta/assets/images/ramanta_logo.png' alt='ramanta logo'> </div>
      <div class='right rec-title' style='float: right; text-align: right; width:380px;'>
        <h2 style='font-size:20px; color:#444; font-weight:600; '> Tax Invoice/Bill of Supply/Cash Memo</h2>
        <h3 style='font-weight: 400; font-size: 17px; color:#444;'>(Original for Recipient)</h3>
      </div>
    </div>
    <section style='width:100%; clear:both; margin-bottom: 15px;'>
      <div  style='width:100%; float:left;  margin-bottom: 15px;'>
        <div   style='width: 300px; float: left;'>
          <h4  style='font-weight: 600; font-size:16px;  color:#444;'> Sold By : </h4>
          <h5 class='soldname' style='font-size:16px;  color:#444;'> RAMANTA STORE </h5>
          <h6 style=' font-weight: 400; color:#444; font-size:16px;'> * 1179, 4th Floor, Block-B, Mangal Bazar Rd, Jahangirpuri, Delhi, 110033 <span class='country block' style='display:block'> IN </span> </h6>
        </div>
        <div class='info-bill right' style='width: 300px;   float: right;   text-align: right;'>
          <h4 class='bold' style='font-weight: 600; color:#444;'> Billing Address : </h4>
          <h5 class='soldname' style='text-transform: uppercase;  font-size: 15px; color:#444;'>".$name."</h5>
          <h6 class='soldaddress' style='font-size: 16px;   font-weight: 400; color:#444;'>".$ship_address."<span class='country block'> IN</span> </h6>
          <ul class='listitem' style='margin: 0; padding: 0; list-style: none;  text-align: right; float:right; color:#444;'>
            <li style='text-align: right; float:right; font-weight: 400; color:#444;'> <span style='font-weight: 600; color:#444; '> City/UT Code:</span> ".$newobject->getdata($conn,"shipping_address","city","id",$shipping_id)."</li>
          </ul>
        </div>
      </div>
      <div class='info_bill_area rowfull' style='width:100%; float:left;'>
        <div class='info-bill left'  style='width: 300px; float: left;'>
          <ul class='listitem' style='margin: 0; padding: 0; list-style: none;'>
            <li> <span style='font-weight: 600;  color:#444; font-size:15px;'>PAN No:</span> EPOPS8865A</li>
            <li> <span style='font-weight: 600;  color:#444; font-size:15px;'>GST Registration No: </span>07EPOPS8865A1Z9</li>
          </ul>
          </h6>
        </div>
        <div class='info-bill right'  style='width: 300px;    float: right;   text-align: right;'>
          <h4 class='bold'  style='font-weight: 600;  color:#444; font-size:15px;'> Shipping Address : </h4>
          <h5 class='soldname' style='text-transform: uppercase; font-size: 15px;'>".$ship_name."</h5>
          <h6 class='soldaddress' style='font-size: 16px;  font-weight: 400;'>".$ship_address."<span class='country block'> IN</span> </h6>
          <ul class='listitem' style='margin: 0; padding: 0; list-style: none; text-align: right; float:right; color:#444;'>
            <li style='text-align: right; float:right; font-weight: 400; color:#444; '> <span style='font-weight: 600;  float:right;  color:#444; '>City/UT Code:</span> ".$newobject->getdata($conn,"shipping_address","city","id",$shipping_id)."</li>
            <li style='text-align: right; float:right; font-weight: 400;  color:#444;'> <span style='font-weight: 600; color:#444; '>Place of delivery: </span>".$newobject->getdata($conn,"shipping_address","house_no","id",$shipping_id)."</li>
          </ul>
        </div>
      </div>
      <div class='info_bill_area rowfull' style='width:100%; float:left;'>
        <div class='info-bill left' style='width:300px; float:left; text-align: left;'>
          <ul class='listitem' style='margin: 0; padding: 0; list-style: none;'>
            <li> <span style='font-weight: 600; color:#444; '>Order Number: </span> 110001".$order_id." </li>
            <li> <span style='font-weight: 600; color:#444; '> Order Date: </span>".$order_date."</li>
          </ul>
          </h6>
        </div>
        <div class='info-bill right' style='width: 300px; float: right; text-align: right;'>
          <ul class='listitem' style='margin: 0; padding: 0; list-style: none;  float: right; text-align: right;'>
            <li> <span style='font-weight: 600; color:#444;'> Invoice Number : </span> RMT-110001".$order_id."</li>
            <li> <span style='font-weight: 600; color:#444;'> Invoice Date : </span> ".$invoice_date."</li>
          </ul>
          </h6>
        </div>
      </div>
    </section>
    <section class='table_product' style='clear:both;'>
	
      <h2 style='font-weight: 600; color:#444; text-align:center; margin-bottom:10px; display:block;'> Product Purchased Information </h2>
	  
      <table width='100%' border='0' cellspacing='0' cellpadding='5' bgcolor='#fff' style='width:800px; margin:10px 0;'>
        <thead>
          <tr style='width:800px; '>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>S.No</th>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>Product Name</th>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>Price/Unit</th>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>HSN Code</th>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>Tax Amount</th>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>Delivery Charge</th>
            <th style='font-weight: 500; background-color: #f5f5f5; text-align: left; font-size: 13px; border:1px solid #7d7d7d;'>Total Amount</th>
          </tr>
        </thead>
        <tbody id='oneTimetab'>
        ";
        if($order_id!="")
        {
        $query_select1 = "SELECT * FROM cart WHERE order_id='".$order_id."'";
        if($sql_select1 = mysqli_query($conn,$query_select1))
        { 
        if(mysqli_num_rows($sql_select1)>0)
        {
        $sno=1;
        while($result1 = mysqli_fetch_array($sql_select1))
        {
        $productid = $result1['product_id'];
        $total_price = $result1['total_price'];
        $product_quantity = $result1['product_quantity'];
        $product_price = $result1['product_price'];
        $productqry="select * from products where id='$productid'";
        $prod_sel=mysqli_query($conn,$productqry);
        $prod_data=mysqli_fetch_assoc($prod_sel);
        $product_name = $prod_data['title'];
        $image = $prod_data['image'];
        $hsn = $prod_data['hsn'];
        $number = $total_price;
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
        . " " . $words[$number % 10] . " "
        . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $html .="
        <tr>
          <td style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d; color:#444;'>".$sno."</td>
		  
          <td  style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d; color:#444;' >".$product_name."</td>
		  
          <td style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d; color:#444;'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp;".number_format($product_price,2)." </td>
		  
		  <td  style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d; color:#444;' >".$hsn."</td>
		  
          <td style='font-weight: 400; text-align: left; font-size: 13px; border:1px solid #7d7d7d; color:#444;'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp;0.00 </td>
		  
          <td style='font-weight: 400;text-align: left; font-size: 13px; border:1px solid #7d7d7d; color:#444;'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp;0.00</td>
		  
          <td  style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d; color:#444;'><i class='fa fa-inr' aria-hidden='true'></i>&nbsp;".number_format($total_price,2)."</td>
		  
        </tr>
        ";
        $i++;
        }
        }
        }
        }
        $html .="
        <tr>
          <td colspan='6' style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d;  '>Total </td>
          <td style='font-weight: 400; text-align: left;  font-size: 13px; border:1px solid #7d7d7d; color:#444;' >Rs.&nbsp;&nbsp;".number_format($total_price,2)."</td>
        </tr>
        
		<tr  align='right'>
          <td colspan='7' align='right' style='font-weight: 400; text-align: right; font-size: 13px; border:1px solid #7d7d7d;  color:#444; '><h3 style='font-weight:600;'> Amount in Words:<small class='block'>".ucwords($result)."</small> </h3></td>
        </tr>
		
        <tr  align='left'>
          <td colspan='7' align='right'  style='font-weight: 400; text-align: left; font-size: 13px; border:1px solid #7d7d7d; color:#444;'><div class='right signarea text-right'>
		  
              <h3 style='font-weight:600; display:block; margin-bottom:5px;'> For RAMANTA STORE:</h3>
			  
                    <h3 style='font-weight:600; display:block;  margin-bottom:5px; '><img src='https://projects.adsandurl.com/ramanta/assets/images/sign.jpg' alt='sign' class='sign' style='display:block;'> </h3>
			  
              <h3  style='font-weight:600; display:block; margin-bottom:5px;'> Authorized Signatory</h3>
			  
            </div></td>
        </tr>
          </tbody>
        
      </table>
      <span style='font-size:15px; margin-top:10px; color:#8c8c8c; display:block; '> Whether tax is payable under reverse charge - No </span> </section>
  </div>
</div>
</div>
</body>
</html>"; 
		
$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->SetDisplayMode('fullpage');
ob_clean();
$mpdf->Output();
flush();
?>