<?PHP
include('apibase.php');

class APICLI extends APIBase {
	public function __construct() {
		//Include the config file, using the entrypoint's values.
		$this->load_files();
		//We have the config file loaded, now let's reference it.
		$config_name = ucfirst($this->get_property()).'_Config';	//Ohhhh, sweet polymorphic inheritance.
		$config = new $config_name;	//We now have access to $config->reqs!
		$this->reqs = $config->reqs;	//Port it to the local var, so we can use it with $this
	}

	public function cliEntryPoint($argv) {
		$args = $argv;
		//Remove the __file__ from the argv.
		array_shift($args);
		$this->input = $this->sanitizeInput($args);
		if ($this->input == NULL) {
			//They didn't put anything! Let's render them the basic site.
			$this->tier_1_err();
			return;
		} else {
			list($curl, $response) = $this->entry_point($this->input, count($this->input));
			return;
		}
	}
	
	public function render($file) {
		$this->foo = 'bar';
		include( $file );
	}
}