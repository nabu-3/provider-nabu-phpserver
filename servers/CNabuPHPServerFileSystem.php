<?php

/** @license
 *  Copyright 2009-2011 Rafael Gutierrez Martinez
 *  Copyright 2012-2013 Welma WEB MKT LABS, S.L.
 *  Copyright 2014-2016 Where Ideas Simply Come True, S.L.
 *  Copyright 2017 nabu-3 Group
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace providers\nabu\phpserver\servers;

use nabu\data\site\CNabuSite;

use nabu\http\CNabuHTTPFileSystem;

/**
 * Overrides main class @see CNabuHTTPFileSystem to change File System folders.
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 0.0.1
 * @version 0.0.1
 * @package \providers\nabu\phpserver\servers
 */
class CNabuPHPServerFileSystem extends CNabuHTTPFileSystem
{
    /** @var string Contains the variable Virtual Hosts (vhosts) base path. */
    private $virtual_hosts_base_path = null;

    public function getVirtualHostsBasePath(): string
    {
        return $this->virtual_hosts_base_path;
    }

    public function getVirtualLibrariesBasePath(): string
    {
        return $this->virtual_hosts_base_path . NABU_TMP_FOLDER . NABU_LIB_FOLDER;
    }

    public function getVirtualCacheBasePath(): string
    {
        return $this->virtual_hosts_base_path . NABU_TMP_FOLDER . NABU_CACHE_FOLDER;
    }

    public function getSiteBasePath(CNabuSite $nb_site): string
    {
        return $this->virtual_hosts_base_path;
    }

    public function getSiteVirtualLibraryPath(CNabuSite $nb_site): string
    {
        return $this->getVirtualLibrariesBasePath() . DIRECTORY_SEPARATOR . $nb_site->getBasePath();
    }

    public function getSiteCachePath(CNabuSite $nb_site): string
    {
        return $this->getVirtualCacheBasePath() . DIRECTORY_SEPARATOR . $nb_site->getBasePath();
    }
    /**
     * Set current Virtual Hosts base path.
     * @param string $path Path to be applied.
     */
    public function setVirtualHostsBasePath(string $path) {
        $this->virtual_hosts_base_path = $path;
    }
}
