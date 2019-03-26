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

use nabu\http\adapters\CNabuHTTPServerAdapter;

/**
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 0.0.1
 * @version 0.0.1
 * @package \providers\nabu\phpserver\servers
 */
class CNabuPHPServerInterface extends CNabuHTTPServerAdapter
{
    private $server_addr = null;
    private $server_port = null;
    private $server_name = null;

    public function recognizeSoftware(): bool
    {
        $software = $this->getServerSoftware();

        return preg_match('/^PHP\s+7\.[0-9]{1,}\.[0-9]{1,}/', $software);
    }

    public function getServerAddress()
    {
        return $this->server_addr;
    }

    public function setServerAddress(string $address)
    {
        $this->server_addr = $address;
    }

    public function getServerPort()
    {
        return $this->server_port;
    }

    public function setServerPort(int $port)
    {
        $this->server_port = $port;
    }

    public function getServerName()
    {
        return $this->server_name;
    }

    public function setServerName(string $name)
    {
        $this->server_name = $name;
    }
}
