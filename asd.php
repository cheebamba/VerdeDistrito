<?

class Test{
	var $a;
	function add($numer, $ilosc){
		$this->a[$numer] += $ilosc;
	}
	function show(){
		foreach($this->a as $key => $value){
			echo('artykul nr. '.$key.', ilosc '.$value);
		}
	}
}

$asd = new Test;
$asd->add(4, 2);
$asd->add(4, 1);
$asd->show();

?>