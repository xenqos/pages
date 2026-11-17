#!/bin/bash

cd ../sources

for file in *; do
  temp_file=$(mktemp)
  cat ../archive/header.txt "$file" > "$temp_file"
  cat "$temp_file" ../archive/footer.txt > "$file"
  rm "$temp_file"
done
