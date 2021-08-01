<?php

require_once 'env.php';
require_once 'helpers.php';

$videos = getVideos();
crawlVideos($videos, 'wildlife');

