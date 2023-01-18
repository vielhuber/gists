# mac/unix
find foo/ -type d -empty -not -path "./.git/*" -exec touch {}/.gitkeep \;

# windows (cygwin)
find foo/ -type d -empty -not -path "./.git/*" -exec touch \{\}/.gitkeep ;