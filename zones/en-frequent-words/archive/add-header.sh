#!/bin/bash

cd ./sources

for file in *; do
  temp_file=$(mktemp)
  cat ../header.txt "$file" > "$temp_file"
  cat "$temp_file" ../footer.txt > "$file"
  rm "$temp_file"
done
