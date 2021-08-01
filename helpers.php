<?php
/**
 * Get videos
 * @return array
 */
function getVideos(): array
{
    $file = PATH . '/videos.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    } else {
        touch($file);

        return [];
    }

}

/**
 * Store videos
 *
 * @param $videos
 *
 * @return array
 */
function storeVideos($videos): array
{
    file_put_contents(PATH . '/videos.json', json_encode($videos));

    return getVideos();
}

/**
 * Crawl videos
 *
 * @param array $videos
 * @param string $q
 * @param int $count
 */
function crawlVideos(array $videos, string $q, int $count = 50)
{
    getVideosOfYoutube($videos, $count, $q);
}

/**
 * Get videos of youtube
 *
 * @param array $videos
 * @param int $count
 * @param int $q
 * @param string|null $nextPage
 */
function getVideosOfYoutube(array $videos, int $count, int $q, string $nextPage = null)
{
    if ( ! empty($videos)) {
        var_dump(count($videos));
    }

    $data = getVideosOfYoutubeData($count, $q, $nextPage);
    if ( ! empty($data->{"items"})) {
        foreach ($data->{"items"} as $result) {
            $videoId = ($result->{"id"}->{"videoId"});
            /*Insert video to your database*/
            $videos[$videoId] = [
                'url'      => 'https://youtu.be/' . $videoId,
                'video_id' => $videoId,
            ];
        }
    }
    $videos = storeVideos($videos);

    if ( ! empty($data->nextPageToken)) {
        getVideosOfYoutube($videos, $count, $q, $data->nextPageToken);
    }

}

function getVideosOfYoutubeData(int $count, string $q, string $nextPage = null)
{
    $nextPage = $nextPage ? '&pageToken=' . $nextPage : '';
    $url      = "https://www.googleapis.com/youtube/v3/search?key=" . GOOGLE_API . "&maxResults=$count&part=snippet&type=video&q=" . $q . $nextPage;

    var_dump($url);
    $JSON             = file_get_contents($url);
    $JSON_Data_search = json_decode($JSON);

    return $JSON_Data_search;
}