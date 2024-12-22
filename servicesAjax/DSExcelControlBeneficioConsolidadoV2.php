mysqli<?php     
	include('../lib/conex.php');
	session_start();
	$fechaini =  $_REQUEST['fechaini'];
	$fechafin =  $_REQUEST['fechafin'];
	$registro= $_SESSION['reg'];
    $mes1="";
	$conex = ConectarConBD();
if (!$conex) {
    echo '{success:false, "errors":{"reason": "No se puede conectar con la BD"}}';
    exit;
}
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');
		
	/** Include PHPExcel */
	require_once '../PHPExcel-develop/PHPExcel-develop/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$proveedor="";
	$sqlProveedor=' SELECT nombre  from proveedor  where activo=1  order by _id desc limit 1  ';
				 $rproveedor=mysqli_query($conex,$sqlProveedor); 
				 
				 if ($row= mysqli_fetch_array($rproveedor)) 
				 {	
					$proveedor=$row['nombre'];
				 }
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
	$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');
	$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
	$objPHPExcel->getActiveSheet()->mergeCells('E3:I3');
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet1 = $objPHPExcel->getActiveSheet();
	$style = array( 'alignment' =>	array
	                  ( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					  
					  ) 
				   ); 
	$sheet->getStyle("A1:J1")->applyFromArray($style);
	
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'DETALLE DE ALIMENTACION COMEDOR S.R.L');   
	$sheet->getStyle("A2:J2")->applyFromArray($style);
	$sheet->getStyle("A3:J3")->applyFromArray($style);
	$objPHPExcel->getActiveSheet()->setCellValue('A2', 'DEL: '.$fechaini.'         AL: '.$fechafin);   
	$objPHPExcel->getActiveSheet()->setCellValue('A3', 'PROVEEDOR: '.$proveedor); 
	$objPHPExcel->getActiveSheet()->setCellValue('E3', 'REGIONAL: SANTA CRUZ');  
    $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);		 
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");

	$objPHPExcel->setActiveSheetIndex(0);
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	
				$objPHPExcel->getActiveSheet()->setCellValue('A6', 'CODIGO');
				//$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->setCellValue('B6', 'COLABORADOR');
				$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CARGO');
				$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->setCellValue('D6', 'UNIDAD');
				$objPHPExcel->getActiveSheet()->getStyle('E6')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->setCellValue('E6', 'SUBCENTRO');
				$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->setCellValue('F6', 'CENTRO');
				 $sqlHorario=' SELECT *  from horario_comedor  where ACTIVO=1 order by HORARIO  ';
				 $rHorario=mysqli_query($conex,$sqlHorario); 
				 $numHorario=0;
				 while ($row= mysqli_fetch_array($rHorario)) 
				{	
					if($numHorario==0){
						$objPHPExcel->getActiveSheet()->getStyle('G6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('G6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($borders);
					}
					if($numHorario==1){
						$objPHPExcel->getActiveSheet()->getStyle('H6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('H6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($borders);
					}
					if($numHorario==2){
						$objPHPExcel->getActiveSheet()->getStyle('I6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('I6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray($borders);
					}
					if($numHorario==3){
						$objPHPExcel->getActiveSheet()->getStyle('J6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('J6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->applyFromArray($borders);
					}
					if($numHorario==4){
						$objPHPExcel->getActiveSheet()->getStyle('K6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('K6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($borders);
						
					}
					if($numHorario==5){
						$objPHPExcel->getActiveSheet()->getStyle('L6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('L6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->applyFromArray($borders);
					}
					if($numHorario==6){
						$objPHPExcel->getActiveSheet()->getStyle('M6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('M6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($borders);
					}
					if($numHorario==7){
						$objPHPExcel->getActiveSheet()->getStyle('N6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('N6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle('A6:N6')->applyFromArray($borders);
					}
					if($numHorario==8){
						$objPHPExcel->getActiveSheet()->getStyle('O6')->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('O6', $row['DESCRIPCION']);
						$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->applyFromArray($borders);
					}
					 $numHorario++;
				}		
    $objPHPExcel->getActiveSheet()->freezePane('A7');
		$records = json_decode(stripslashes($registro));
	$vt1=0;$vt2=0;$vt3=0;$vt4=0;$vt5=0;$vt6=0;$vt7=0;$vt8=0;$vt9=0;$vt10=0;$vt11=0;$vt12=0;$vt13=0;$vt14=0;$vt15=0;		
	    $i=7;
			if ($records != '')
			{
			
				foreach($records as $record)
				{		
					
					  $codigo= 	$record -> codigo;
					  $nombre= 	$record -> nombre;
					  $cargo= 	$record -> cargo;
					  $unidad=		$record -> unidad;
					  $subcentro=		$record -> subcentro;
					  $centro=		$record -> centro;
					    if($numHorario>=1){$c1= $record -> c1;$vt1=$vt1+$c1;}
						if($numHorario>=2){$c2= $record -> c2;$vt2=$vt2+$c2;}
						if($numHorario>=3){$c3= $record -> c3;$vt3=$vt3+$c3;}
						if($numHorario>=4){$c4= $record -> c4;$vt4=$vt4+$c4;}
						if($numHorario>=5){$c5= $record -> c5;$vt5=$vt5+$c5;}
						if($numHorario>=6){$c6= $record -> c6;$vt6=$vt6+$c6;}
						if($numHorario>=7){$c7= $record -> c7;$vt7=$vt7+$c7;}
						if($numHorario>=8){$c8= $record -> c8;$vt8=$vt8+$c8;}
						if($numHorario>=9){$c9= $record -> c9;$vt9=$vt9+$c9;}
						if($numHorario>=10){$c10= $record -> c10;$vt10=$vt10+$c10;}
						if($numHorario>=11){$c11= $record -> c11;$vt11=$vt11+$c11;}
						if($numHorario>=12){$c12= $record -> c12;$vt12=$vt12+$c12;}
						if($numHorario>=13){$c13= $record -> c13;$vt13=$vt13+$c13;}
						if($numHorario>=14){$c14= $record -> c14;$vt14=$vt14+$c14;}
						if($numHorario>=15){$c15= $record -> c15;$vt15=$vt15+$c15;}
					  
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$i, $codigo )
								->setCellValue('B'.$i, $nombre)
								->setCellValue('C'.$i, (string)$cargo)
								->setCellValue('D'.$i, (string)$unidad)
								->setCellValue('E'.$i, (string)$subcentro)
								->setCellValue('F'.$i, (string)$centro);
								if($numHorario>=1){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('G'.$i, (string)$c1);
								   
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'G'.$i)->applyFromArray($borders);
								}
								if($numHorario>=2){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('H'.$i, (string)$c2);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'H'.$i)->applyFromArray($borders);
								}
								if($numHorario>=3){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('I'.$i, (string)$c3);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'I'.$i)->applyFromArray($borders);
								}
								if($numHorario>=4){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('J'.$i, (string)$c4);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'J'.$i)->applyFromArray($borders);
								}
								if($numHorario>=5){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('K'.$i, (string)$c5);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'K'.$i)->applyFromArray($borders);
								}
								if($numHorario>=6){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('L'.$i, (string)$c6);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'L'.$i)->applyFromArray($borders);
								}
								if($numHorario>=7){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('M'.$i, (string)$c7);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'M'.$i)->applyFromArray($borders);
								}
								if($numHorario>=8){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('N'.$i, (string)$c8);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'N'.$i)->applyFromArray($borders);
								}
								if($numHorario>=9){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('O'.$i, (string)$c9);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'O'.$i)->applyFromArray($borders);
								}
								
					
					$i++;
				}
				
			}	
			
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.'E'.$i);
			//$sheet->getStyle('F'.$i.':'.'F'.$i)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, 'TOTAL'); 
								if($numHorario>=1){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('G'.$i, (string)$vt1);
								   
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'G'.$i)->applyFromArray($borders);
								}
								if($numHorario>=2){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('H'.$i, (string)$vt2);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'H'.$i)->applyFromArray($borders);
								}
								if($numHorario>=3){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('I'.$i, (string)$vt3);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'I'.$i)->applyFromArray($borders);
								}
								if($numHorario>=4){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('J'.$i, (string)$vt4);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'J'.$i)->applyFromArray($borders);
								}
								if($numHorario>=5){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('K'.$i, (string)$vt5);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'K'.$i)->applyFromArray($borders);
								}
								if($numHorario>=6){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('L'.$i, (string)$vt6);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'L'.$i)->applyFromArray($borders);
								}
								if($numHorario>=7){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('M'.$i, (string)$vt7);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'M'.$i)->applyFromArray($borders);
								}
								if($numHorario>=8){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('N'.$i, (string)$vt8);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'N'.$i)->applyFromArray($borders);
								}
								if($numHorario>=9){
								   $objPHPExcel->setActiveSheetIndex(0) 
								   ->setCellValue('O'.$i, (string)$vt9);
								   $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'O'.$i)->applyFromArray($borders);
								}
	
	
     //--------------------------------------------------------------------------------------------------------
    $M[1]="ENERO";$M[2]="FEBRERO";$M[3]="MARZO";$M[4]="ABRIL";$M[5]="MAYO";$M[6]="JUNIO";$M[7]="JULIO";$M[8]="AGOSTO";$M[9]="SEPTIEMBRE";$M[10]="OCTUBRE";$M[11]="NOVIEMBRE";$M[12]="DICIEMBRE";
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle($fechaini.' '.$fechafin);


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

   
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="ReporteBeneficio.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?> 