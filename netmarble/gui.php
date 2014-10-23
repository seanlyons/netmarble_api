<?PHP
include(__DIR__.'/../apigui.php');

class Netmarble_Gui extends APIGUI {
	private $property 		= 'netmarble';
	public $entry_method 	= 'gui';
	
	public function get_property()		{ 	return $this->property;		}
	public function get_entry_method()	{ 	return $this->entry_method;	}
}
$gui = new Netmarble_Gui;
$curl = $gui->guiEntryPoint();

echo json_encode($curl);