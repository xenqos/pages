#!/bin/bash

#cd ./texts-a2
#split -l 10 01-a1.txt zzz_

#cd ./texts-a2
#split -l 10 02-a2.txt zzz_
#cd ..

#cd ./texts-b1
#split -l 10 03-b1.txt zzz_
#cd ..

#cd ./texts-b2
#split -l 10 04-b2.txt zzz_
#cd ..

#cd ./texts-c1
#split -l 10 05-c1.txt zzz_
#cd ..

#cd ./texts-c2
#split -l 10 06-c2.txt zzz_
#cd ..

cd ./texts-a2
for file in *.txt; do
    echo "$file" | cat - "$file" > temp && mv temp "$file"
done
cd ..

cd ./texts-b1
for file in *.txt; do
    echo "$file" | cat - "$file" > temp && mv temp "$file"
done
cd ..

cd ./texts-b2
for file in *.txt; do
    echo "$file" | cat - "$file" > temp && mv temp "$file"
done
cd ..

cd ./texts-c1
for file in *.txt; do
    echo "$file" | cat - "$file" > temp && mv temp "$file"
done
cd ..

cd ./texts-c2
for file in *.txt; do
    echo "$file" | cat - "$file" > temp && mv temp "$file"
done
cd ..
