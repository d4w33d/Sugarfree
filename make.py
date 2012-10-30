#!/usr/bin/python

import sys
import os
import shutil

repo_dir = os.path.dirname(__file__)
repo_name = os.path.basename(repo_dir)
root_dir = os.path.join(repo_dir, '..')
samples_dir = os.path.join(repo_dir, 'samples')

dirs = [
    'code',
    'code/handlers',
    'code/models',
    'code/views',
    'code/views/css',
    'code/views/js',
    'code/views/templates',
    'data',
    'data/images'
]

deletable = [
    '.htaccess',
    'index.php',
    'code/handlers/home.php'
]


class Maker:
    def make(self, args=[]):
        for f in dirs:
            path = os.path.join(root_dir, f.replace('/', os.sep))
            if not os.path.isdir(path):
                print 'Creating directory %s...' % path
                os.mkdir(path)

        print 'Making .htaccess...'
        shutil.copyfile(os.path.join(samples_dir, '.htaccess'),
            os.path.join(root_dir, '.htaccess'))

        print 'Making index.php with repository name: %s...' % repo_name
        o = open(os.path.join(samples_dir, 'index.php'), 'r')
        c = o.read()
        o.close()
        o = open(os.path.join(root_dir, 'index.php'), 'w')
        o.write(c.format(repo_name=repo_name))
        o.close()

        print 'Copying handler sample...'
        shutil.copyfile(os.path.join(samples_dir, 'handler.php'),
            os.path.join(root_dir, 'code', 'handlers', 'home.php'))

        print 'Done.'

    def destruct(self, args=[]):
        for f in dirs:
            path = os.path.join(root_dir, f.replace('/', os.sep))
            if os.path.isdir(path):
                print 'Removing directory %s...' % path
                shutil.rmtree(path)

        for f in deletable:
            path = os.path.join(root_dir, f)
            if os.path.isfile(path):
                print 'Removing %s...' % os.path.basename(path)
                os.remove(path)

        print 'Done.'

    def restore(self, args=[]):
        self.destruct()
        self.make()
        print 'Restoring done.'


if __name__ == '__main__':
    mkr = Maker()
    args = sys.argv[1:]
    action = 'make' if not len(args) else args[0]
    method = getattr(mkr, action)
    method(args[1:] if len(args) else [])
