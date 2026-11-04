#!/usr/bin/env python

import math
import os
import random
import packages.commons.functions as fnc
import packages.commons.classes as cls

# -----------------------------------------------------------------------------
# https://www.eff.org/dice
# -----------------------------------------------------------------------------


# -----------------------------------------------------------------------------
# Functions
# -----------------------------------------------------------------------------

def get_random_line(file_name):
    total_bytes = os.stat(file_name).st_size
    random_point = random.randint(0, total_bytes)
    file = open(file_name)
    file.seek(random_point)
    file.readline()
    line = file.readline()
    file.close()
    return line


# -----------------------------------------------------------------------------

def get_password(cfg):
    assets = cfg.params['assets']
    module = cfg.params['module']
    file_adjectives = cfg.params['file_adjectives']
    file_nouns = cfg.params['file_nouns']

    file_adjectives = f"{assets}/{module}/{file_adjectives}"
    file_nouns = f"{assets}/{module}/{file_nouns}"

    password = ''

    for i in range(3):
        # password += str(random.randint(0, 9))
        # password += ' '
        password += get_random_line(file_adjectives).strip()
        password += ' '
        password += get_random_line(file_nouns).strip()
        if i < 2:
            password += ' '

    size = len(set(password)) + 1
    entropy = math.log2(size) * len(password)

    cfg.params['password'] = password
    cfg.params['entropy'] = f'{float(entropy):,.{0}f}'


# -----------------------------------------------------------------------------
# Main
# -----------------------------------------------------------------------------


def main():
    # -------------------------------------------------------------------------
    # Get Exceptions
    # -------------------------------------------------------------------------

    fnc.get_exceptions()

    # -------------------------------------------------------------------------
    # Get Congiguration
    # -------------------------------------------------------------------------

    cfg = cls.Config()

    # -------------------------------------------------------------------------
    # Generate Password
    # -------------------------------------------------------------------------

    get_password(cfg)

    # -------------------------------------------------------------------------
    # Set Locals
    # -------------------------------------------------------------------------

    module = cfg.params['module']
    title = cfg.params['title']
    zones = cfg.params['zones']
    zone = cfg.params['zone']
    password = cfg.params['password']
    entropy = cfg.params['entropy']

    # -------------------------------------------------------------------------
    # Print Page
    # -------------------------------------------------------------------------

    print('Content-type: text/html;charset=utf-8\n')
    print(fnc.get_template(cfg, 'default').format(**locals()))


# -----------------------------------------------------------------------------

if __name__ == "__main__":
    main()

# -----------------------------------------------------------------------------
