<?php
include '../db_connect.php';

function generateRow($from, $to, $conn)
{
    $contents = '';
    $stmt = $conn->query("SELECT r.*,s.name as sname FROM return_order r inner join suppliers s on s.id = r.supplier_id WHERE r.date_created BETWEEN '$from' AND '$to' order by r.date_created desc");
    $num = 1;
    while ($row = $stmt->fetch_assoc()) :

        $contents .= '
			<tr>
				<td>' . $num++ . '</td>
				<td>' . date("M d, Y H:i A",strtotime($row['date_created'])) . '</td>
				<td>' . $row['ro_code'] . '</td>
				<td>' . ucwords($row['sname']) . '</td>
				<td>' . number_format($row['total_cost'],2) . '</td>
			</tr>
			';
    endwhile;

    return $contents;
}

if (isset($_POST['print'])) {
    $from = $_POST['from'];
    $to =  $_POST['to'];
    $from_title = date('M d, Y', strtotime($from));
    $to_title = date('M d, Y', strtotime($to));


    require_once('../assets/vendor/tcpdf/tcpdf.php');
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Return Order Report: ' . $from_title . ' - ' . $to_title);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
	      	<h4 align="center">RETURN ORDER REPORT</h4>
	      	<h4 align="center">' . $from_title . " - " . $to_title . '</h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>#</b></th>
	                <th width="30%" align="center"><b>Date</b></th>
					<th width="15%" align="center"><b>Code</b></th>
					<th width="20%" align="center"><b>Supplier</b></th>  
					<th width="15%" align="center"><b>Total Amount</b></th>  
	           </tr>  
	      ';
    $content .= generateRow($from, $to, $conn);
    $content .= '</table>';
    $pdf->writeHTML($content);
    ob_end_clean();
    $pdf->Output('returnorder.pdf', 'I');

    $pdo->close();
} else {
?>
    <script>
        alert("Need date range to provide sales print") <
            script >
        <?php
    }
        ?>