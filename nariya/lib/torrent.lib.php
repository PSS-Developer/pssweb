<?php
// 기본적으로 UTF-8 형식임.

// Get Torrent File
function na_get_torrent($attach, $path='') {
    global $g5;

	$arr = array();
	$torrent = array();

	if($path) {
		$j = 0;
		for($i=0; $i < count($attach); $i++) {
			if (isset($attach[$i]['source']) && $attach[$i]['source'] && $attach[$i]['view']) 
				continue;
			
			$ext = na_file_info($attach[$i]['source']);

			if($ext['ext'] != 'torrent') 
				continue;

			$arr[$j] = $path.'/'.$attach[$i]['file'];
			$j++;
		}
	} else {
		if(!$attach['torrent']) 
			return;

		$j = 0;
		for($i=0; $i < count($attach); $i++) {

			if($attach[$i]['ext'] != "6") 
				continue;

			$arr[$j] = G5_DATA_PATH.'/item/'.$attach[$i]['id'].'/'.$attach[$i]['file'];
			$j++;
		}
	}

	//require_once (NA_PLUGIN_PATH.'/lib/torrent.lib.php');

	for ($i=0; $i < count($arr); $i++) {
		$torrent_file = file_get_contents($arr[$i]);
		$torrent_array = BDecode($torrent_file);
		$torrent_hash=sha1(BEncode($torrent_array['info']));
		
		$torrent[$i]['name'] = $torrent_array['info']['name'];
		$torrent[$i]['magnet'] = 'magnet:?xt=urn:btih:'.$torrent_hash;
		for($k=0; $k < count($torrent_array['announce-list']); $k++) {
			$torrent[$i]['tracker'][$k] = $torrent_array['announce-list'][$k][0];
		}
		$torrent[$i]['comment'] = $torrent_array['comment'];
		$torrent[$i]['date'] = $torrent_array['creation date'];
		$torrent[$i]['is_size'] = ($torrent_array['info']['length']) ? true : false;
		if($torrent[$i]['is_size']) {
			$torrent[$i]['info']['name'] = $torrent_array['info']['name'];
			$torrent[$i]['info']['size'] = get_filesize($torrent_array['info']['length']);
		} else {
			$total_size = 0;
			for ($k=0;$k <  count($torrent_array['info']['files']);$k++) {
				for ($l=0;$l < count($torrent_array['info']['files'][$k]['path']); $l++) {
					$torrent[$i]['info']['file'][$k]['name'][$l] = $torrent_array['info']['files'][$k]['path'][$l];
				}
				$torrent[$i]['info']['file'][$k]['size'] = get_filesize($torrent_array['info']['files'][$k]['length']);
				$total_size = $total_size + $torrent_array['info']['files'][$k]['length'];
			}
			$torrent[$i]['info']['total_size'] = get_filesize($total_size);
		}
	}

    return $torrent;
}

// Protect our namespace using a class
class BDecode {
	function numberdecode($wholefile, $offset) {
		// Funky handling of negative numbers and zero
		$negative = false;
		if ($wholefile[$offset] == '-') {
			$negative = true;
			$offset++;
		}
		if ($wholefile[$offset] == '0') {
			$offset++;
			if ($negative)
				return array(false);
			if ($wholefile[$offset] == ':' || $wholefile[$offset] == 'e')
				return array(0, ++$offset);
			return array(false);
		}
		$ret[0] = 0;
		for(;;) {
			if ($wholefile[$offset] >= '0' && $wholefile[$offset] <= '9') {
				$ret[0] *= 10;
				//Added 2005.02.21 - VisiGod
	       //Changing the type of variable from integer to double to prevent a numeric overflow   
				settype($ret[0],'double');
				//Added 2005.02.21 - VisiGod
				$ret[0] += ord($wholefile[$offset]) - ord('0');
				$offset++;
			}	else if ($wholefile[$offset] == 'e' || $wholefile[$offset] == ':') {
				// Tolerate : or e because this is a multiuse function
				$ret[1] = $offset+1;
				if ($negative) {
					if ($ret[0] == 0)
						return array(false);
					$ret[0] = - $ret[0];
				}
				return $ret;
			} else return array(false);
		}
	}

	function decodeEntry($wholefile, $offset=0) {
		if ($wholefile[$offset] == 'd')
			return $this->decodeDict($wholefile, $offset);
		if ($wholefile[$offset] == 'l')
			return $this->decodelist($wholefile, $offset);
		if ($wholefile[$offset] == 'i')
			return $this->numberdecode($wholefile, ++$offset);
		// String value: decode number, then grab substring

		$info = $this->numberdecode($wholefile, $offset);
		if ($info[0] === false)
			return array(false);
		$ret[0] = substr($wholefile, $info[1], $info[0]);
		$ret[1] = $info[1]+strlen($ret[0]);
		return $ret;
	}

	function decodeList($wholefile, $offset) {
		if ($wholefile[$offset] != 'l')
			return array(false);
		$offset++;
		$ret = array();
		for ($i=0;;$i++) {
			if ($wholefile[$offset] == 'e')
				break;
			$value = $this->decodeEntry($wholefile, $offset);
			if ($value[0] === false)
				return array(false);
			$ret[$i] = $value[0];
			$offset = $value[1];
		}
		// The empty list is an empty array. Seems fine.
		return array(0=>$ret, 1=>++$offset);
	}

	// Tries to construct an array
	function decodeDict($wholefile, $offset=0) {
		if ($wholefile[$offset] == 'l')
			return $this->decodeList($wholefile, $offset);
		if ($wholefile[$offset] != 'd')
			return false;
		$ret=array();
		$offset++;
		for (;;) {	
			if ($wholefile[$offset] == 'e')	{
				$offset++;
				break;
			}
			$left = $this->decodeEntry($wholefile, $offset);
			if (!$left[0])
				return false;
			$offset = $left[1];
			if ($wholefile[$offset] == 'd') {
				// Recurse
				$value = $this->decodedict($wholefile, $offset);
				if (!$value[0])
					return false;
				$ret[addslashes($left[0])] = $value[0];
				$offset= $value[1];
				continue;
			}
			if ($wholefile[$offset] == 'l') {
				$value = $this->decodeList($wholefile, $offset);
				if (!$value[0] && is_bool($value[0]))
					return false;
				$ret[addslashes($left[0])] = $value[0];
				$offset = $value[1];
				continue;
			}
			$value = $this->decodeEntry($wholefile, $offset);
			if ($value[0] === false)
				return false;
			$ret[addslashes($left[0])] = $value[0];
			$offset = $value[1];
		}
		return array(0=>(empty($ret)?true:$ret), 1=>$offset);
	}
} // End of class declaration.

// Use this function. eg:  BDecode("d8:announce44:http://www. ... e");
function BDecode($wholefile) {
	$decoder = new BDecode;
	$return = $decoder->decodeEntry($wholefile);
	return $return[0];
}

// We'll protect the namespace of our code
// using a class
class BEncode {
	// Dictionary keys must be sorted. foreach tends to iterate over the order
	// the array was made, so we make a new one in sorted order. :)
	function makeSorted($array) {
		// Shouldn't happen!
		if (empty($array))
			return $array;
		$i = 0;
		foreach($array as $key => $dummy)
			$keys[$i++] = stripslashes($key);
		sort($keys);
		for ($i=0; isset($keys[$i]); $i++)
			$return[addslashes($keys[$i])] = $array[addslashes($keys[$i])];
		return $return;
	}

	// Encodes strings, integers and empty dictionaries.
	// $unstrip is set to true when decoding dictionary keys
	function encodeEntry($entry, &$fd, $unstrip = false) {
		if (is_bool($entry)) {
			$fd .= 'de';
			return;
		}
		if (is_int($entry) || is_float($entry)) {
			$fd .= 'i'.$entry.'e';
			return;
		}
		if ($unstrip)
			$myentry = stripslashes($entry);
		else
			$myentry = $entry;
		$length = strlen($myentry);
		$fd .= $length.':'.$myentry;
	}

	// Encodes lists
	function encodeList($array, &$fd) {
		$fd .= 'l';
		// The empty list is defined as array();
		if (empty($array)) {
			$fd .= 'e';
			return;
		}
		for ($i = 0; isset($array[$i]); $i++)
			$this->decideEncode($array[$i], $fd);
		$fd .= 'e';
	}

	// Passes lists and dictionaries accordingly, and has encodeEntry handle
	// the strings and integers.
	function decideEncode($unknown, &$fd) {
		if (is_array($unknown)) {
			if (isset($unknown[0]) || empty($unknown))
				return $this->encodeList($unknown, $fd);
			else
				return $this->encodeDict($unknown, $fd);
		}
		$this->encodeEntry($unknown, $fd);
	}

	// Encodes dictionaries
	function encodeDict($array, &$fd) {
		$fd .= 'd';
		if (is_bool($array)) {
			$fd .= 'e';
			return;
		}
		// NEED TO SORT!
		$newarray = $this->makeSorted($array);
		foreach($newarray as $left => $right) {
			$this->encodeEntry($left, $fd, true);
			$this->decideEncode($right, $fd);
		}
		$fd .= 'e';
	}
} // End of class declaration.

// Use this function in your own code.
function BEncode($array) {
	$string = '';
	$encoder = new BEncode;
	$encoder->decideEncode($array, $string);
	return $string;
}

?>