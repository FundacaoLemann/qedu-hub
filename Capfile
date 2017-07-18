require "capistrano/setup"
require "capistrano/deploy"
require "capistrano/nginx"
require 'capistrano/symfony'
require 'capistrano/file-permissions'
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git

Dir.glob("lib/capistrano/tasks/*.rake").each { |r| import r }
