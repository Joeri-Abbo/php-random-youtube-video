<?php

require_once 'env.php';
require_once 'helpers.php';

$videos = getVideos();
foreach (getVideos() as $video) {
    $videos[$video['video_id']] = $video;
}

storeVideos($videos);