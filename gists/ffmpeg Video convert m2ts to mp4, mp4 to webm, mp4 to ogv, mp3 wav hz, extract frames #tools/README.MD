## video convert m2ts to mp4, mp4 to webm, mp4 to ogv

#### mp4 to mp4 (medium)
```sh
ffmpeg -i input.mp4 -b 1000000 output.mp4
```

#### m2ts to mp4
```sh
ffmpeg -i input.m2ts -vcodec libx264 -crf 20 -acodec ac3 -vf "yadif" output.mp4
```

#### mp4 to webm (high)
```sh
ffmpeg -i input.mp4 -aq 5 -ac 2 -qmax 25 -threads 2 output.webm
ffmpeg -i input.mp4 -c:v libvpx-vp9 -crf 30 -b:v 0 -b:a 128k -c:a libopus output.webm
```

#### mp4 to webm (medium)
```sh
ffmpeg -i input.mp4 -aq 5 -ac 2 -qmax 35 -threads 2 output.webm
```

#### mp4 to ogv (high)
```sh
ffmpeg -i input.mp4 -vcodec libtheora -acodec libvorbis -q:v 6 -q:a 5 output.ogv
```

#### mp4 to ogv (medium)
```sh
ffmpeg -i input.mp4 -vcodec libtheora -acodec libvorbis -q:v 2 -q:a 4 output.ogv
```

## convert m4a to mp3

#### single file
```sh
ffmpeg -i foo.m4a -acodec libmp3lame -aq 2 bar.mp3
```

#### in current folder
```sh
for f in *.m4a; do ffmpeg -i "$f" -acodec libmp3lame -aq 2 "${f%.m4a}.mp3"; done
```

#### recursively in all folders
```sh
find . -name '*.m4a' -exec ffmpeg -i {} -acodec libmp3lame -aq 2 {}.mp3 \;
```

#### windows
```sh
for /R %f in ("*.m4a") do (ffmpeg.exe -i "%~f" -acodec libmp3lame -aq 2 "%~pf%~nf.mp3")
```

## convert wav files in folder to mp3 and ogg (+ increasing the volume)

```sh
rm -f ~/audio/files/*.mp3;
rm -f ~/audio/files/*.ogg;
cd ~/audio/files/;
for i in *.wav; do ~/ffmpeg/ffmpeg -y -i $i -af volume=2.5 -ab 192k ${i/%.wav/.mp3}; done;
for i in *.wav; do ~/ffmpeg/ffmpeg -y -i $i -af volume=2.5 -aq 10 ${i/%.wav/.ogg}; done;
```

## download and convert akamai hd m3u8 file to mp3

```sh
ffmpeg -i "https://***.akamaihd.net/i/***/master.m3u8" -c copy input.ts
ffmpeg -i input.ts -c:v libx264 -c:a copy output.mp4
```

## convert wav to mp3

#### no options

```sh
ffmpeg -i input.wav -acodec libmp3lame output.mp3
```

#### with options (no video, set frequency and audio channels)

```sh
ffmpeg -i input.wav -vn -ar 44100 -ac 2 -ab 192k -f mp3 output.mp3
```

## convert mp3 to rate 9khz and mono 16bit PCM wav

```sh
ffmpeg -i input.mp3 -ac 1 -ar 8000 -acodec pcm_s16le output.wav
```

## extract first/last frame

```sh
ffmpeg -ss 0 -i input.mp4 -frames:v 1 first.png
ffmpeg -sseof -3 -i input.mp4 -update 1 -q:v 1 last.png
```

## cut off

#### cut off all before 5s of mp4

```sh
ffmpeg -i input.mp4 -ss 3.5 -c:v libx264 -c:a aac -strict experimental output.mp4
```

#### cut off from 10s of mp4

```sh
ffmpeg -i input.mp4 -t 10 -c copy output.mp4
```

## concatenate multiple mp4 files

#### same codecs/size

```sh
ffmpeg -f concat -safe 0 -i <(for f in ./*.mp4; do echo "file '$PWD/$f'"; done) -c copy output.mp4
```

#### different codecs/size

```sh
ffmpeg -i 1.mp4 -i 2.mp4 -filter_complex "[0:v:0][1:v:0]concat=n=2:v=1[outv]" -map "[outv]" -c:v libx264 -preset fast -crf 23 output.mp4
```

#### no audio at video 2 and different sizes

```sh
ffmpeg -i 1.mp4 -i 2.mp4 -filter_complex "[0:v:0]scale=1080:1468,setsar=1[v1]; [1:v:0]scale=1080:1468,setsar=1[v2]; [v1][v2]concat=n=2:v=1[outv]" -map "[outv]" -map 0:a:0 -c:v libx264 -preset fast -crf 23 -c:a aac -b:a 128k output.mp4
```
