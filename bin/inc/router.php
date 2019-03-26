<?php
use nabu\core\CNabuEngine;

use providers\nabu\phpserver\servers\CNabuPHPServerInterface;

error_log(print_r($_SERVER, true));

require_once 'common.php';

CNabuEngine::setLocateHTTPServerHook(function($nb_http_server) {
    error_log("HOLA");
    if ($nb_http_server instanceof CNabuPHPServerInterface) {
        $nb_http_server->setServerAddress('172.31.18.234');
        $nb_http_server->setServerPort(80);
        $nb_http_server->setServerName('www.nabu-3.com');
    }
});

$request_uri = $_SERVER['REQUEST_URI'];
$current_dir = getcwd();

if (strlen($request_uri) == 0) {
   $request_uri = '/';
}

/** @source
  * error_log(print_r($_SERVER, true));
  * error_log(print_r($_ENV, true));
  * error_log('include_path=' . ini_get('include_path'));
  * error_log('open_basedir=' . ini_get('open_basedir'));
  * error_log('expose_php=' . ini_get('expose_php'));
  * error_log('display_errors=' . ini_get('display_errors'));
  * error_log($http_mode);
  * error_log($argv['http_mode']);
  * error_log(print_r(ini_get_all(), true));
*/

$request_file = preg_replace('/\//', DIRECTORY_SEPARATOR, $request_uri);

$mode = 'http';

$project_folders = array(
    $current_dir . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'commondocs',
    $current_dir . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'httpdocs'
);

foreach ($project_folders as $basepath) {
    $filename = $basepath . $request_file;
    if (file_exists($filename)) {
        if (is_file($filename)) {
            error_log('In ' . $basepath);
            header('Content-type: ' . mime_content_type($filename));
            $fh = fopen($filename, 'r');
            fpassthru($fh);
            fclose($fh);
            return true;
        } else {
            $filename = $basepath
                      . $request_file
                      . (nb_strEndsWith($request_file, DIRECTORY_SEPARATOR) ? '' : DIRECTORY_SEPARATOR)
                      . 'index.php'
            ;
            if (file_exists($filename)) {
                include $filename;
                return true;
            }
        }
    }
}

/** @source error_log('Calling nabu-3 loader'); */
$_GET['__x_nb_path'] = $request_file;
include $project_folders[1] . DIRECTORY_SEPARATOR . 'nabu-3.php';

return true;
