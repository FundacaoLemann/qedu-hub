set :deploy_config_path, 'app/config/deploy/deploy.rb'
set :stage_config_path, 'app/config/deploy/stages'

require "capistrano/setup"
require "capistrano/deploy"
require 'capistrano/symfony'
require 'capistrano/file-permissions'
require "capistrano/scm/git"

install_plugin Capistrano::SCM::Git

Dir.glob("app/config/deploy/tasks/*.rb").each { |r| import r }
