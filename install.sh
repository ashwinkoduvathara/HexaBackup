#!/bin/bash
mkdir -p /usr/local/cpanel/base/frontend/paper_lantern/hexabackup

cp hexabackup.tar /usr/local/cpanel/base/frontend/paper_lantern/hexabackup
cp hexabackup.live.php /usr/local/cpanel/base/frontend/paper_lantern/hexabackup/hexabackup.live.php

/usr/local/cpanel/scripts/install_plugin /usr/local/cpanel/base/frontend/paper_lantern/hexabackup/hexabackup.tar --theme paper_lantern

mkdir -p /usr/local/cpanel/base/frontend/jupiter/hexabackup

cp hexabackup.tar /usr/local/cpanel/base/frontend/jupiter/hexabackup/hexabackup.tar
cp hexabackup.live.php /usr/local/cpanel/base/frontend/jupiter/hexabackup/hexabackup.live.php

/usr/local/cpanel/scripts/install_plugin /usr/local/cpanel/base/frontend/jupiter/hexabackup/hexabackup.tar --theme jupiter
