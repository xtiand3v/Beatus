<?php
	include '../db_connect.php';
	function generateRow($from, $to, $conn){
		$contents = '';
	 	
		$stmt = mysqli_query($conn,"SELECT * FROM sales LEFT JOIN users ON users.id=sales.user_id WHERE DATE(sales.date_created) BETWEEN '$from' AND '$to' ORDER BY date_created DESC");
		while($row = mysqli_fetch_array($stmt)){
			$getTotal = mysqli_query($conn,"SELECT SUM(total_amount) as total from sales WHERE date_created BETWEEN '$from' AND '$to'");
			$data = mysqli_fetch_array($getTotal);
			$total = $data['total'];
			$contents .= '
			<tr>
				<td>'.date('M d, Y', strtotime($row['date_created'])).'</td>
				<td>'.$row['name'].'</td>
				<td align="right">Php '.number_format($row['amount_tendered'], 2).'</td>
				<td align="right">Php '.number_format($row['total_amount'], 2).'</td>
			</tr>
			';
		}

		$contents .= '
			<tr>
				<td colspan="3" align="right"><b>Total</b></td>
				<td align="right"><b>Php '.number_format($total, 2).'</b></td>
			</tr>
		';
		return $contents;
	}

	if(isset($_POST['print'])){
		$from = $_POST['min'];
		$to =  $_POST['max'];
		$from_title = date('M d, Y', strtotime($from));
		$to_title = date('M d, Y', strtotime($to));


		require_once('../assets/vendor/tcpdf/tcpdf.php');  
	    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
	    $pdf->SetCreator(PDF_CREATOR);  
	    $pdf->SetTitle('Sales Report: '.$from_title.' - '.$to_title);  
	    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
	    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
	    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	    $pdf->SetDefaultMonospacedFont('helvetica');  
	    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
	    $pdf->setPrintHeader(false);  
	    $pdf->setPrintFooter(false);  
	    $pdf->SetAutoPageBreak(TRUE, 10);  
	    $pdf->SetFont('helvetica', '', 11);  
	    $pdf->AddPage();  
	    $content = '';  
	    $content .= '
	      	<h2 align="center">Beatus</h2>
	      	<h4 align="center">SALES REPORT</h4>
	      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>Date</b></th>
	                <th width="30%" align="center"><b>Buyer Name</b></th>
					<th width="40%" align="center"><b>Amount Tendered</b></th>
					<th width="15%" align="center"><b>Total Amount</b></th>  
	           </tr>  
	      ';  
	    $content .= generateRow($from, $to, $conn);  
	    $content .= '</table>';  
	    $pdf->writeHTML($content);  
		ob_end_clean();
	    $pdf->Output('sales.pdf', 'I');

	    $pdo->close();

	}
	else{
		?>
		<script>
            alert("Need date range to provide sales print")
			<script>
		<?php
	}
?>