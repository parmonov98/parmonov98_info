<?php

$isp = geoip_isp_by_name($_SERVER['REMOTE_ADDR']);

print_r($isp);