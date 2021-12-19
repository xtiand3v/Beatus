<?php
	include '../db_connect.php';

	function generateRow($from, $to, $conn){
		$contents = '';
		$stmt = mysqli_query($conn,"SELECT * FROM purchase_order p INNER join suppliers s on s.id = p.supplier_id WHERE p.date_created BETWEEN '$from' AND '$to' order by p.date_created desc");
		while($row = mysqli_fetch_array($stmt)){
			$getTotal = mysqli_query($conn,"SELECT SUM(total_cost) as total from purchase_order WHERE date_created BETWEEN '$from' AND '$to'");
			$data = mysqli_fetch_array($getTotal);
			$total = $data['total'];
            if($row['status'] == 1):
                $status = "Received";
            elseif($row['status'] == 2):
                $status = "Partially Received";
            else:
               $status = "Pending";
           endif;
			$contents .= '
			<tr>
				<td>'.date('M d, Y', strtotime($row['date_created'])).'</td>
				<td>'.$row['po_code'].'</td>
				<td>'.$row['name'].'</td>
				<td align="right">Php '.number_format($row['total_cost'], 2).'</td>
				<td>'.$status.'</td>
			</tr>
			';
		}

		$contents .= '
			<tr>
				<td colspan="3" align="right"><b>Total</b></td>
				<td align="left" colspan="2"><b>Php '.number_format($total, 2).'</b></td>
			</tr>
		';
		return $contents;
	}

	if(isset($_POST['print'])){
		$from = $_POST['from'];
		$to =  $_POST['to'];
		$from_title = date('M d, Y', strtotime($from));
		$to_title = date('M d, Y', strtotime($to));


		require_once('../assets/vendor/tcpdf/tcpdf.php');  
	    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
	    $pdf->SetCreator(PDF_CREATOR);  
	    $pdf->SetTitle('Purchase Order Report: '.$from_title.' - '.$to_title);  
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
	      	<h4 align="center">PURCHASE ORDER REPORT</h4>
	      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>Date</b></th>
	                <th width="15%" align="center"><b>P.O Code</b></th>
					<th width="30%" align="center"><b>Supplier</b></th>
					<th width="20%" align="center"><b>Total</b></th>  
					<th width="15%" align="center"><b>Status</b></th>  
	           </tr>  
	      ';  
	    $content .= generateRow($from, $to, $conn);  
	    $content .= '</table>';  
	    $pdf->writeHTML($content);  
		ob_end_clean();
	    $pdf->Output('purchase_order.pdf', 'I');

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