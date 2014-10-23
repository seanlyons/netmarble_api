<?PHP
include('apibase.php');

class APIGUI extends APIBase {
	//public $reqs;
	public $foo;
	
	public function __construct() {
		//Include the config file, using the entrypoint's values.
		$this->load_files();
		//We have the config file loaded, now let's reference it.
		$config_name = ucfirst($this->get_property()).'_Config';	//Ohhhh, sweet polymorphic inheritance.
		$config = new $config_name;	//We now have access to $config->reqs!
		$this->reqs = $config->reqs;	//Port it to the local var, so we can use it with $this
	}

	public function guiEntryPoint() {
		$args = $_REQUEST;
		$this->input = $this->sanitizeInput($args);
		if ($this->input == NULL) {
			//They didn't put anything! Let's render them the basic site.
			$template = $this->get_property() . '/template.php';
			$this->render( $template );
		} else {
			header('Content-Type: application/json');
			foreach($this->input as $k => $v) {
				$input[] = $k.'='.$v;
			}
			$curl = $this->entry_point($input, count($this->input));
			return $curl;
		}
	}
	
	public function render($file) {
		$this->foo = 'bar';
		include( $file );
	}
}