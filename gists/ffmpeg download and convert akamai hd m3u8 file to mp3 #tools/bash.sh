ffmpeg -i "https://***.akamaihd.net/i/***/master.m3u8" -c copy input.ts
ffmpeg -i input.ts -c:v libx264 -c:a copy output.mp4