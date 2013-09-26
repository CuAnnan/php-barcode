php-barcode
===========

Class based version of https://github.com/davidscotttufts/php-barcode/

The abstract Barcode class is responsible for all of the work except converting
the plain text to encoded characters. The individual barcode type Classes 
implement the convertText method which generates the string of encoded text for
barcodifying.

Usage:
```php
<?php
spl_autoload_register(
	function($class)
	{
		$classParts = explode('\\', $class);
		$relativePath = implode('/', $classParts).'.class.php';
		$path = 'classes/'.$relativePath;
		if(is_file($path))
		{
			include $path;
			return true;
		}
		return false;
	}
);

$characterCodePrefix = "309";
$characterCode = "108";
$code = $characterCodePrefix.'-'.str_pad($characterCode, 6, '0', STR_PAD_LEFT);
$generator = new \Barcode\CodaBarBarcode($code);
$generator->displayPNG();
?>
```
