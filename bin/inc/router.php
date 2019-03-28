<?php
use nabu\core\CNabuEngine;

use providers\nabu\phpserver\servers\CNabuPHPServerInterface;

require_once 'common.php';

CNabuEngine::setLocateHTTPServerHook(function($nb_http_server) {
    if ($nb_http_server instanceof CNabuPHPServerInterface) {
        $nb_http_server->setServerAddress('172.31.18.234');
        $nb_http_server->setServerPort(80);
        $nb_http_server->setServerName('www.nabu-3.com');
        $nb_http_fs = $nb_http_server->getFileSystem();
        $nb_http_fs->setVirtualHostsBasePath(getcwd());
    }
});

$request_uri = $_SERVER['REQUEST_URI'];
$current_dir = getcwd();
$tmp_dir = $current_dir . NABU_TMP_FOLDER;

if (!file_exists($tmp_dir)) {
    mkdir($tmp_dir);
}

if (strlen($request_uri) == 0) {
   $request_uri = '/';
}

$request_file = preg_replace('/\//', DIRECTORY_SEPARATOR, $request_uri);

$mode = 'http';

$project_folders = array(
    $current_dir . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'commondocs',
    $current_dir . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . $mode . 'docs',
    NABU_PUB_PATH
);

foreach ($project_folders as $basepath) {
    $filename = $basepath . $request_file;
    if (file_exists($filename)) {
        if (is_file($filename)) {
            error_log('In ' . $basepath . ' found ' . $request_uri);

            if (nb_strEndsWith($filename, 'css')) {
                $info = 'text/css';
            } elseif (nb_strEndsWith($filename, 'js')) {
                $info = 'application/javascript';
            } else {
                $fi = finfo_open(FILEINFO_MIME);
                $info = finfo_file($fi, $filename);
                finfo_close($fi);
            }
            error_log($info);

            header('Content-type: ' . $info);
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
