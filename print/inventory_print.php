<?php
include '../db_connect.php';

function generateRow($from, $to, $conn)
{
    $contents = '';
    $stmt = $conn->query("SELECT * FROM items WHERE date_created BETWEEN '$from' AND '$to' order by date_created desc");
    $num = 1;
    while ($row = $stmt->fetch_assoc()) :
        $inn = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 1 and item_id =" . $row['id']);
        $inn = $inn->num_rows > 0 ? $inn->fetch_array()['stock'] : 0;
        $out = $conn->query("SELECT sum(qty) as stock FROM stocks where type = 2 and item_id =" . $row['id']);
        $out = $out->num_rows > 0 ? $out->fetch_array()['stock'] : 0;
        $available = $inn - $out;

        $contents .= '
			<tr>
				<td>' . $num++ . '</td>
				<td>' . $row['item_code'] . '</td>
				<td>' . ucwords($row['name']) . '</td>
				<td>' . $row['size'] . '</td>
				<td>' . $available . '</td>
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
    $pdf->SetTitle('Inventory Report: ' . $from_title . ' - ' . $to_title);
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
	      	<h4 align="center">INVENTORY REPORT</h4>
	      	<h4 align="center">' . $from_title . " - " . $to_title . '</h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>#</b></th>
	                <th width="15%" align="center"><b>Item Code</b></th>
					<th width="30%" align="center"><b>Name</b></th>
					<th width="20%" align="center"><b>Item Size</b></th>  
					<th width="15%" align="center"><b>Stocks</b></th>  
	           </tr>  
	      ';
    $content .= generateRow($from, $to, $conn);
    $content .= '</table>';
    $pdf->writeHTML($content);
    ob_end_clean();
    $pdf->Output('inventory.pdf', 'I');

    $pdo->close();
} else {
?>
    <script>
        alert("Need date range to provide sales print") <
            script >
        <?php
    }
        ?>