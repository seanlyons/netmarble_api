<?PHP
//var_dump(__CLASS__.'::'.__FUNCTION__.' @ '.__LINE__.' >> '.);
define('STANDARD', '-H "Accept: application/json" -H "Content-Type: application/json" -H "GameCode:chrono"');
define('URL', "cpdev-rankingapi.netmarble.net/");
define('NORMAL', "\e[0;37m");
define('RED', "\e[0;31m");
define('GREEN', "\e[0;32m");

class APIBase {
	public $reqs = 'jinkies';
	public $input = NULL;
	public $entry_method = NULL;
	
	public function entry_point($argv, $argc) {
		//Did they fail to provide any args whatsoever? provide first-tier instructions.
		if ($argc === 1 && $argv[0] === __FILE__) {
			$this->msg('No input provided. Valid first-tier inputs:', 0);
			$this->tier_1_err();
			return;
		}

		//The first arg provided is the request type...
		if (strpos($argv[0], 'request_type') === 0) {
			$request_type = substr($argv[0], 1 + strpos($argv[0], '='));
			unset($argv[0]);
		} else {
			$request_type = $argv[1];
		}		

		//Make sure that request-type actually exists.
		
		if (! array_key_exists($request_type, $this->reqs)) {
			$this->msg('No valid request type provided. Valid first-tier inputs:', 0);
			$this->tier_1_err();
			return;
		}

		$argc -= 1;

		if (count($this->reqs[$request_type]['args']) > $argc) {
			$this->msg('Too few arguments for that request type. Request-type "'.$request_type.'" has required arguments:', 0);
			$this->tier_2_err($this->reqs, $request_type);
			return;
		}
		try {
			$options = $this->get_options($argv, $this->reqs[$request_type]['args']);
		} catch (Exception $e) {
			$this->msg('Bad options. Aborting. >> '. $e->getMessage(), 1);
			return;
		}


		if (!empty($options)) {
			$post = "'-d ".json_encode($options) ."'";
		} else {
			$post = '-d {}';
		}

		//Ensure that every option is accounted for

		//Ensure that no extra options are present

		//Ensure that every option value is of the correct var type.

		$command = 'curl '.STANDARD.' -s -X POST '.$post.' '.URL.$this->reqs[$request_type]['endpoint'];

		$response = `$command`;
		//$response = json_encode(array('foo'=>'bar','baz'=>'quoz'));

		$curl = NULL;

		if ($this->entry_method != 'gui') {
			echo "\n";
			echo RED.$command.NORMAL;
			echo "\n\n";
			echo GREEN.$response.NORMAL;
			echo "\n\n";
		} else {
			$curl = array('command' => $command, 'response' => $response);
		}
		
		return $curl;
	}
	
	function msg( $str, $indentation) {
		if (empty($str)) {
			return;
		}
	
		for ($i = 0; $i < $indentation; $i++) {
			$str = "   ".$str;
		}
		if ($this->entry_method == 'gui') {
			echo '<pre>'.$str."</pre>";
		} else {
			echo $str."\n";
		}
	}

	function tier_1_err() {
		foreach ($this->reqs as $k => $v) {
			$this->msg(printf("%20s [%30s]", $k, json_encode($v["endpoint"])), 0);
		}
		return;
	}

	function tier_2_err($reqs, $request_type) {
		if (empty($reqs[$request_type]['args'])) {
			$this->msg('Request type "'.$request_type.'" does not require any arguments.', 0);
			return;
		}
		foreach($reqs[$request_type]['args'] as $k => $v) {
			$this->msg(printf("%30s: %10s", $k, $v['vartype']), 1);
		}
		$example = '';
		foreach ($reqs[$request_type]['args'] as $k => $v) {
			$example .= ' '.$k.'='.$v['example'];
		}
		$this->msg(RED.'Example: php '.__FILE__.' '.$request_type.' '.$example.NORMAL, 2);
		return;
		
		
		return;
	}

	function get_options($argv, $settings) {
		$options = array();
		foreach ($argv as $k => $v) {
			$equals = strpos($v, '=');

			//Error if the key or the value are null, or if there's no =.
			if ($equals === FALSE || $equals === 0 || $equals === strlen($v)) {
				throw new Exception('Option #'.$k.' [['.$v.', '.$equals.']] is invalid: required option form is "key=value"');
			}
			$exploded = explode("=", $v);
			$key = $exploded[0];

			if (isset($settings[$key]['special'])) {
				switch ($settings[$key]['special']) {
					case 'takes_array':
						$value = array(urlencode($exploded[1]));
						break;
					case 'range':
						$hyphen = strpos($exploded[1], '-');
						if ($hyphen === FALSE || $hyphen === 0 || $hyphen === strlen($exploded[1])) {
							throw new Exception('Key "'.$key.' is a ranged value: expected format is "key=0-99".');
						}
						$range = explode("-", $exploded[1]);
						
						if (!is_numeric($range[0]) || !is_numeric($range[1])) {
							throw new Exception('Key "'.$key.' is  a ranged value: expected format is "key=0-99".');
						}
						$value = array($range[0], $range[1]);
						break;
				}
			} else {
				$value = $exploded[1];
			}
			$options[$key] = $value;
		}
		return $options;
	}
	
	function load_files() {
		$property = $this->get_property();
		$file_name = $property.'/config.php';
		include($file_name);
	}
	
	function sanitizeInput($input_array) {
		if (is_scalar($input_array)) {
			return NULL;
		}
		if (!is_array($input_array)) {
			return NULL;
		}
		return $input_array;
	}
	
	function pre( $msg ) {
		echo '<pre>PRE: ';
		if (is_scalar($msg)) {
			echo $msg;
		} else {
			echo json_encode( $msg, JSON_PRETTY_PRINT);
		}
		echo '</pre>';
	}
}