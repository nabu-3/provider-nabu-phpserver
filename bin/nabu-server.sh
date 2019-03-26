#!/bin/sh
echo ========================================================================
echo nabu-3 - HTTP Server
echo ========================================================================
echo Copyright 2009-2011 Rafael Gutierrez Martinez
echo Copyright 2012-2013 Welma WEB MKT LABS, S.L.
echo Copyright 2014-2016 Where Ideas Simply Come True, S.L.
echo
echo Licensed under the Apache License, Version 2.0 \(the ""License""\);
echo you may not use this file except in compliance with the License.
echo You may obtain a copy of the License at
echo
echo     http://www.apache.org/licenses/LICENSE-2.0
echo
echo Unless required by applicable law or agreed to in writing, software
echo distributed under the License is distributed on an \"AS IS\" BASIS,
echo WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
echo See the License for the specific language governing permissions and
echo limitations under the License.
echo ========================================================================
echo

# This variable defines the path for config files. You can change this value.
# When nabu-3 install script runs, he creates this path if not exists.
NABU_ETC_PATH=/etc/opt/nabu-3.conf.d
NABU_SCRIPT_PATH=`realpath $0`
NABU_SCRIPT_PATH=`dirname $NABU_SCRIPT_PATH`
NABU_HOST_PATH=`pwd`

if [ -d ${NABU_ETC_PATH} ] && [ -f ${NABU_ETC_PATH}/nabu-3.conf ] ; then
    source ${NABU_ETC_PATH}/nabu-3.conf
else
    echo Config file not found
    exit 1
fi

echo Starting HTTP Server...
echo
php -S localhost:8000 \
       -d expose_php=0 \
       -d display_errors=0 \
       -d open_basedir=none \
       -d error_reporting=E_ALL \
       -d session.auto_start=0 \
       -d include_path=.:${NABU_HOST_PATH}/src/php:${NABU_BASE_PATH}/src/:${NABU_BASE_PATH}/pub/:${NABU_BASE_PATH}/sdk/:${NABU_BASE_PATH}/lib/ \
       ${NABU_SCRIPT_PATH}/inc/router.php
