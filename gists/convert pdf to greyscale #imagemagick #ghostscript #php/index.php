<?php
define('GHOSTSCRIPT_PATH', '"C:\Program Files\GS\gs9.22\bin\gswin64c.exe"');
function pdfGreyscale($source, $target, $type = 'vector')
{
	if( !file_exists($source) )
	{
		throw new \Exception();
	}
    if( $type === 'vector' )
    {
      	exec(GHOSTSCRIPT_PATH.' -sOutputFile='.$target.' -sDEVICE=pdfwrite -sColorConversionStrategy=Gray -dProcessColorModel=/DeviceGray -dCompatibilityLevel=1.4 -dAutoRotatePages=/None -dNOPAUSE -dBATCH '.$source);
    }
    elseif( $type === 'pixel' )
    {
      	exec(IMAGEMAGICK_PATH.' -density 120 '.$source.' -colorspace sRGB -colorspace GRAY '.$target); 
    }
	return true;
}