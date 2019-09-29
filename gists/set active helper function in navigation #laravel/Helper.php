<?php
namespace App\Helpers;

use URL;
use Request;

class Helper {

    public static function setActive(...$args) {
      if( Request::url() == call_user_func_array('URL::route',$args) ) {
    		return ' class="active" ';
    	}
    	else {
    		return "";
    	}

    }
    
    public static function setActiveMenu($html) {

        // find all occurences
        $positions = [];
        foreach(['"'.Request::url().'"','"'.Request::url().'/"'] as $needle) {
            $last_pos = 0;
            while(($last_pos = strpos($html, $needle, $last_pos)) !== false) {
                $positions[] = $last_pos;
                $last_pos = $last_pos + strlen($needle);
            }
        }
        sort($positions);

        // insert
        $position_offset = 0;
        foreach($positions as $position__value) {
            $pos = $position__value+$position_offset;
            $pos_begin = strrpos(substr($html,0,$pos), "<");
            $pos_end = strpos($html, ">", $pos);

            // if class attribute is already present
            if( strpos(substr($html, $pos_begin, $pos_end-$pos_begin), 'class="') !== false ) {
                $insert = ' active ';
                $pos_insert = strrpos(substr($html, 0, $pos_end), 'class="')+strlen('class="');
            }
            else {
                $insert = ' class="active" ';
                $pos_insert = $pos_end;
            }

            $position_offset += strlen($insert);
            $html = substr($html, 0, $pos_insert).$insert.substr($html, $pos_insert);
        }

        return $html;

    }
    
}