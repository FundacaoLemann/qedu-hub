# config valid only for current version of Capistrano
lock "3.8.2"

# config valid only for current version of Capistrano
set :stages, ["prod","prod-php5"]
set :symfony_env,  "prod"
set :branch, "master"
set :application, ask("set the correct app:")
set :repo_url, "git@github.com:Talits/qedu-hub.git"
set :pty, true
set :deploy_via, :remote_cache
set :http_host, "www.qedu.org.br"
set :symfony_console_path, "bin/console"
set :permission_method, :acl
set :permission_method, true
#set :file_permissions_paths, ["app/logs", "app/cache"]
set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path), "var", "web/uploads"]
set :file_permissions_users, ["nginx"]


after "deploy:log_revision", "dep:node"
after "dep:node", "shared:googlewmt"
after "shared:googlewmt", "deploy:set_permissions:acl"
after "deploy:set_permissions:acl", "dep:include"
after "dep:include", "restart:nginx"
