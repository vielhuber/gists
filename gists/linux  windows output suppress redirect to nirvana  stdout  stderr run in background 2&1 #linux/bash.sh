# linux (no output)
bash script.sh > /dev/null 2>&1

# linux (no output & run in background)
bash script.sh > /dev/null 2>&1 &

# windows (no output)
echo foo 2> nul

# windows (run in background)
start /b bash script.sh

# unix & windows (no output)
echo foo >nul 2>&1

# unix (no output)
echo foo 2>/dev/null