<?php
namespace Barcode;
abstract class Barcode
{
	protected $text, $size, $orientation, $convertedText;
	
	function __construct($text = 0, $size = 20)
	{
		$this->text = $text;
		$this->convertText($text);
		$this->size = $size;
	}
	
	protected abstract function convertText($text);
	
	protected function getCodeLength($text)
	{
		$codeLength = 2;
		for($i = 0; $i < strlen($text); $i++)
		{
			$codeLength = $codeLength + (integer)(substr($text,($i),1));
		}
		return $codeLength;
	}
	
	protected function generateVerticalImage()
	{
		$imgWidth = $this->size;
		$imgHeight = $this->getCodeLength($this->convertedText);
		$image = imagecreate($imgWidth, $imgHeight);
		$black = imagecolorallocate ($image, 0, 0, 0);
		$white = imagecolorallocate ($image, 255, 255, 255);
		imagefill($image, 0, 0, $white);
		$location = 1;
		for($i = 0; $i < strlen($this->convertedText); $i++)
		{
			$curSize = $location + (substr($this->convertedText, $i, 1));
			$color = $i % 2?$black:$white;
			imagefilledrectangle($image, 0, $location, $imgWidth, $curSize, $color);
			$location = $curSize;
		}
		return $image;
	}
	
	protected function generateHorizontalImage()
	{
		$imgWidth = $this->getCodeLength($this->convertedText);
		$imgHeight = $this->size;
		$image = imagecreate($imgWidth, $imgHeight);
		$black = imagecolorallocate ($image, 0, 0, 0);
		$white = imagecolorallocate ($image, 255, 255, 255);
		imagefill($image, 0, 0, $white);
		$location = 1;
		for($i = 0; $i < strlen($this->convertedText); $i++)
		{
			$curSize = $location + (substr($this->convertedText, $i, 1));
			$color = $i % 2?$black:$white;
			imagefilledrectangle($image, $location, 0, $curSize, $imgHeight, $color);
			$location = $curSize;
		}
		return $image;
	}
	
	protected function getImage($vertical = false)
	{
		if($vertical)
		{
			$image = $this->generateVerticalImage();
		}
		else
		{
			$image = $this->generateHorizontalImage();
		}
		return $image;
	}
	
	public function displayPNG($vertical = false)
	{
		$image = $this->getImage($vertical);
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
	
	public function displayJPG($vertical = false)
	{
		$image = $this->getImage($vertical);
		header('Content-type: image/jpg');
		imagejpeg($image);
		imagedestroy($image);
	}
	
	public function displayGIF($vertical = false)
	{
		$image = $this->getImage($vertical);
		header('Content-type: image/gif');
		imagegif($image);
		imagedestroy($image);
	}
	
	public function testImageGeneration()
	{
		$image = $this->getImage();
		
	}
}