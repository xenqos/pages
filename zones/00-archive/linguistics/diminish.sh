#!/bin/bash

cd ./sounds-big

for file in *; do
  ffmpeg -i $file -ar 16000 -b:a 32k ../sounds/$file
done
