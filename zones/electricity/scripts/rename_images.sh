#!/bin/bash

cd ./texts

for file in *.txt; do
    [ -f "$file" ] || continue
    i="${file%.txt}"

    echo $i

    perl -i -pe '
        our $c //= 0;
        if (s|(<p><img src="[^"]*\.([^"]*)" /></p>)|"^['"$i"'-" . sprintf("%02d", ++$c) . ".$2]"|ge) {
            my $search  = $1;
            my $replace = "^['"$i"'-" . sprintf("%02d", $c) . ".$2]";
            open(my $log, ">>", "log.txt") or die "Cannot open log.txt: $!";
            print $log "sleep 1; echo \"${replace}\"; curl -s -o \"${replace}\" -A \"\${user_agent}\" \"\${prefix}${search}\"\n";
            close($log);
        }
    ' "$file"
done
