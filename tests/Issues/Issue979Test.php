<?php

namespace Issues;

use Mpdf\Output\Destination;

class Issue979Test extends \Mpdf\BaseMpdfTest
{

	public function testUnknownTag()
	{

		$html = <<<HTML
<html>
<body>
🗿
</body>
</html>
HTML;

		$settings = [
			'mode'			=> 'UTF-8-c',
			'format'		=> 'A4',
			'default_font_size' => 0,
			'default_font'	=> '',
			'margin_left'	 => 10,
			'margin_right'	=> 10,
			'margin_top'	=> 17,
			'margin_bottom' => 8.5,
			'margin_header' => 3,
			'margin_footer' => 3,
			'orientation'	 => 'P',
		];

$title='tiotlůe';

		$mpdf = new \Mpdf\Mpdf($settings);

		$mpdf->displayDefaultOrientation = true;
		$mpdf->keep_table_proportions = true;
		$mpdf->use_kwt = true;
		$mpdf->useSubstitutions=true;
		$mpdf->backupSubsFont = array('dejavusanscondensed', 'arialunicodems','freesans', 'sun-exta');

		$mpdf->title2annots=false;
		$mpdf->bookmarkStyles = array(
			0 => array('color'=> array(85, 157, 208), 'style'=>''),
			1 => array('color'=> array(0,0,0), 'style'=>''),
			2 => array('color'=> array(0,0,0), 'style'=>'I'),
		);

		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetAuthor('Cockpit');
		$mpdf->SetCreator('Cockpit');
		$mpdf->dpi = 96;
		$mpdf->img_dpi = 150;

		$mpdf->SetHTMLHeader('<table width="100%" border="0" cellspacing="0" cellpadding="0"<tr><td><h1>'.$title.'</h1></td><td align="right"><img align="right" width="150" src="img/logo.png" border="0" /></td></tr></table>');

		$mpdf->SetFooter("{DATE d.m.Y H:i:s} by Cockpit|asdfasdf|Seite {PAGENO}/{nb}");

		$mpdf->setBasePath('/');

		$mpdf->WriteHTML($html, 0);

		$output = $mpdf->output('', 'S');
		$this->assertStringStartsWith('%PDF-', $output);
	}

}
