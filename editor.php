<?php
	ini_set("display_errors", 1);

	require './vendor/autoload.php';	
	require_once './vendor/phpoffice/phpword/bootstrap.php';

	use PhpOffice\PhpWord\Settings;
	use PhpOffice\PhpWord\IOFactory;
	use NcJoes\OfficeConverter\OfficeConverter;
	
	$my_template = new \PhpOffice\PhpWord\TemplateProcessor('document.docx');
	
	$my_template->setValue('name', $_POST["name"]);
	$my_template->setValue('address', $_POST["address"]);
	$img = $_POST['signature'];
	$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
	file_put_contents('signature.png', $data);
	$my_template->setImageValue('signature', 'signature.png');

	try{
        $my_template->saveAs('doc.docx');

		$converter = new OfficeConverter('doc.docx');
		$converter->convertTo('doc.pdf');
    }catch (Exception $e){
        //handle exception
    }
    header('Location: /form/thankyou.html');
?>