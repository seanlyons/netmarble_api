<?PHP
$reqs = json_encode((array) $this->reqs, JSON_PRETTY_PRINT);
?>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

<style>
	.col1 {
		left:0px;
		width:200px;
		position:absolute;
	}
	.col2 {
		left:200px;
		width:200px;
		position:absolute;
	}

</style>


<div id=datalist data-keys="<?PHP echo implode(',', array_keys($this->reqs)); ?>"></div>
<?PHP foreach( $this->reqs as $k => $v) { ?>
	<div id="<?PHP echo $k; ?>" data-json='<?PHP echo json_encode($v['args']); ?>'></div>
<?PHP } ?>

<form>
<select>
	<option value="choose_a_type">Choose a call type</option>
	<?PHP foreach ($this->reqs as $k => $v) { ?>
		<option value="<?PHP echo strtolower($k); ?>"><?PHP echo ucfirst(strtolower($k)); ?></option>
	<?PHP } ?>
</select>
</form>

<form id='dyno' action='nway.php' method='get'>
</form>

<script src="http://sean.hexault.com/nwayapi/ajax.js"></script>
