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

namespace providers\nabu\phpserver;

use nabu\core\CNabuEngine;

use nabu\core\interfaces\INabuApplication;

use nabu\http\adapters\CNabuHTTPModuleManagerAdapter;

use nabu\http\app\base\CNabuHTTPApplication;

use nabu\http\descriptors\CNabuHTTPServerInterfaceDescriptor;

/**
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 0.0.1
 * @version 0.0.1
 * @package \providers\nabu\phpserver
 */
class CNabuPHPServerManager extends CNabuHTTPModuleManagerAdapter
{
    /** @var CNabuHTTPServerInterfaceDescriptor PHP Server Interface Descriptor. */
    private $nb_php_server_descriptor = null;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        parent::__construct(NABU_PHPSERVER_VENDOR_KEY, NABU_PHPSERVER_MODULE_KEY);
    }

    public function enableManager()
    {
        $nb_engine = CNabuEngine::getEngine();

        $this->nb_php_server_descriptor = new CNabuHTTPServerInterfaceDescriptor(
            $this,
            'NabuPHPServer',
            'Nabu PHP Server',
            __NAMESPACE__,
            'CNabuPHPServerInterface'
        );
        $nb_engine->registerProviderInterface($this->nb_php_server_descriptor);

        return true;
    }

    public function registerApplication(INabuApplication $nb_application)
    {
        if ($nb_application instanceof CNabuHTTPApplication) {
            $this->nb_application = $nb_application;
        }

        return $this;
    }
}
