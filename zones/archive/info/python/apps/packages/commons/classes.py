import os
import sys
import yaml


# -----------------------------------------------------------------------------

class Config:
    def __init__(self):
        self.module = os.path.splitext(
            os.path.basename(sys.modules['__main__'].__file__))[0]

        with open('../configs/commons.yaml', 'r') as object:
            self.shared = yaml.safe_load(object)

        with open(f'../configs/{self.module}.yaml', 'r') as object:
            self.params = yaml.safe_load(object)

        self.params.update(self.shared)
        del self.shared

        self.params['module'] = self.module

        self.params['initfile'] = \
            self.params['initdir'] + '/' +\
            self.module + '.py'

# -----------------------------------------------------------------------------
