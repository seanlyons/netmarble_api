<?PHP
include(__DIR__.'/../apicli.php');

class Netmarble_Cli extends APICLI {
	private $property 		= 'netmarble';
	public $entry_method 	= 'cli';
	
	public function get_property()		{ 	return $this->property;		}
	public function get_entry_method()	{ 	return $this->entry_method;	}
}
$cli = new Netmarble_Cli;
$curl = $cli->cliEntryPoint($argv);