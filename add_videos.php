<?php

require_once 'env.php';
require_once 'helpers.php';
ini_set("memory_limit", "-1");
set_time_limit(0);
$videos = getVideos();
crawlVideos($videos, 'sealife');

