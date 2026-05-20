#!/bin/bash

cd ../sounds-loud

for file in *; do
  ffmpeg -i $file -af "volume=-4dB" -y ../sounds/$file
done
