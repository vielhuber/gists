### single file
ffmpeg -i foo.m4a -acodec libmp3lame -aq 2 bar.mp3

### in current folder
for f in *.m4a; do ffmpeg -i "$f" -acodec libmp3lame -aq 2 "${f%.m4a}.mp3"; done

### recursively in all folders
find . -name '*.m4a' -exec ffmpeg -i {} -acodec libmp3lame -aq 2 {}.mp3 \;

### windows
for /R %f in ("*.m4a") do (ffmpeg.exe -i "%~f" -acodec libmp3lame -aq 2 "%~pf%~nf.mp3")