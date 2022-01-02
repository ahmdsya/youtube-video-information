<?php

class YoutubeVideoInfo {

    public $channelTitle;
    public $publishedAt;
    public $title;
    public $description;
    public $thumbnail;
    public $tags;
    public $duration;
    public $durationTimeFormat;
    public $viewCount;
    public $likeCount;
    public $commentCount;

    private $key;
    private $videoURL;
    private $baseURL = 'https://www.googleapis.com/youtube/v3/videos';


    public function __construct($key)
    {
        $this->key = $key;
    }

    public function setVideoURL($videoURL)
    {
        $this->videoURL = $videoURL;
        $this->setAll();
    }

    private function setAll()
    {
        $videoInfo          = $this->getAllVideoData();
        $this->channelTitle = $videoInfo['channelTitle'];
        $this->publishedAt  = $videoInfo['publishedAt'];
        $this->title        = $videoInfo['title'];
        $this->description  = $videoInfo['description'];
        $this->thumbnail    = $videoInfo['thumbnails'];
        $this->tags         = $videoInfo['tags'];
        $this->duration     = $videoInfo['duration'];
        $this->viewCount    = $videoInfo['viewCount'];
        $this->likeCount    = $videoInfo['likeCount'];
        $this->commentCount = $videoInfo['commentCount'];
        $this->durationTimeFormat = $this->secondToTimeFormat($this->duration);
    }

    private function getVideoId()
    {
        $video = array();
    
        $split_url = parse_url( $this->videoURL );
        if ( isset( $split_url['host'] ) ) {
            $video['host'] = $split_url['host'];
    
            if ( $video['host'] == 'www.youtube.com' || $video['host'] == 'youtube.com' ) {
                $video_id = explode( '?v=', $this->videoURL ); 
                
                if ( empty( $video_id[1] ) ) {
                    $video_id = explode( '&v=', $this->videoURL );
                    if ( empty( $video_id[1] ) ) {
                        $video_id = explode( '/v/', $this->videoURL );
                    }
                }

                $video_id    = explode( '&', $video_id[1] );
                $video['id'] = $video_id[0];
            }
        }
    
        return $video['id'];
    }

    private function getAllVideoData()
    {
        $videoID = $this->getVideoId();

        $dataParam = [
            'key'  => $this->key,
            'id'   => $videoID,
            'part' => 'snippet,contentDetails,statistics,player'
        ];

        $params = http_build_query($dataParam);

        $videoData = file_get_contents($this->baseURL.'?'.$params);
        $videoInfo = json_decode($videoData, true);

        $allInfo = array();

        foreach($videoInfo['items'] as $item){
            
            $allInfo['channelTitle'] = $item['snippet']['channelTitle'];
            $allInfo['publishedAt']  = date("d-m-Y H:i:s", strtotime($item['snippet']['publishedAt']));
            $allInfo['title']        = $item['snippet']['title'];
            $allInfo['description']  = $item['snippet']['description'];
            $allInfo['thumbnails']   = $item['snippet']['thumbnails']['standard']['url'];
            $allInfo['tags']         = implode(', ', $item['snippet']['tags']);
            $allInfo['duration']     = $this->videoDurationToSecond($item['contentDetails']['duration']);
            $allInfo['viewCount']    = $item['statistics']['viewCount'];
            $allInfo['likeCount']    = $item['statistics']['likeCount'];
            $allInfo['commentCount'] = $item['statistics']['commentCount'];
            // $allInfo['embed']        = $item['player']['embedHtml'];
        
        }

        return $allInfo;

    }

    private function videoDurationToSecond($videoDuration)
    {
        $duration = new DateInterval($videoDuration);
        $hours_to_seconds = $duration->h * 60 * 60;
        $minutes_to_seconds = $duration->i * 60;
        $seconds = $duration->s;
        
        return $hours_to_seconds + $minutes_to_seconds + $seconds;
    }

    private function secondToTimeFormat($seconds)
    {
        $hours = floor($seconds / 3600);
        $mins  = floor($seconds / 60 % 60);
        $secs  = floor($seconds % 60);
    
        if($hours >= 1){
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        }else{
            $timeFormat = sprintf('%02d:%02d', $mins, $secs);
        }
    
        return $timeFormat;
    }
}