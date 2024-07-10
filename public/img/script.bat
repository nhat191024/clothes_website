FOR %%i IN (*.jpg) DO ffmpeg -i "%%i" -compression_level 100 "{destination folder}\%%~ni.webp"
