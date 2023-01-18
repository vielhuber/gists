rm -f ~/audio/files/*.mp3;
rm -f ~/audio/files/*.ogg;
cd ~/audio/files/;
for i in *.wav; do ~/ffmpeg/ffmpeg -y -i $i -af volume=2.5 -ab 192k ${i/%.wav/.mp3}; done;
for i in *.wav; do ~/ffmpeg/ffmpeg -y -i $i -af volume=2.5 -aq 10 ${i/%.wav/.ogg}; done;