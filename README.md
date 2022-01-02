# youtube-video-information
Fungsi PHP untuk mendapatkan informasi video dari youtube berupa informasi judul video, deskripsi, durasi dan lainnya.

## Fitur
Informasi video youtube yang dapat diambil sebagai berikut:
* Nama Channel
* Waktu publikasi
* Judul video
* Deskripsi video
* Thumbnails standard
* Tag
* Durasi
* Jumlah viewer, like dan komentar

## Penggunaan
Sebelum menggunakan repo ini, pastikan anda sudah memiliki Youtube API Key. Silahkan lihat cara mendapatkan Youtube API Key [disini.](https://argiaacademy.com/cara-mendapatkan-youtube-api-key-dengan-mudah/)

```sh
//clone repo
git clone https://github.com/ahmdsya/youtube-video-information.git
```

```sh
require "YoutubeVideoInfo.php"; //panggil file YoutubeVideoInfo.php
```
```sh
$apiKey = "Youtube-API-KEY"; //Youtube API KEY
$videoURL = "https://www.youtube.com/watch?v=PiTZFxQC1B4"; //URL Video Youtube

$video = new YoutubeVideoInfo($apiKey); //panggil class dan kirim API Key
$video->setVideoURL($videoURL); //kirim video url
```

```sh
echo $video->channelTitle; //menampilkan nama channel
echo $video->publishedAt; //menampilkan waktu publikasi video
echo $video->title; //menampilkan judul video
echo $video->description; //menampilkan deskripsi video
echo $video->thumbnail; //menampilkan url gambar thumbnails
echo $video->tags; //menampilkan data tags video
echo $video->duration; //menampilkan durasi video dalam detik
echo $video->durationTimeFormat; //menampilkan durasi video dalam format waktu (ex: 04.21)
echo $video->viewCount; //menampilkan jumlah viewer
echo $video->likeCount; //menampilkan jumlah like
echo $video->commentCount; //menampilkan jumlah komentar
```

### Terimakasih
---
