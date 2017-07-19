set :stages, ["nginx"]

server "ec2-52-67-216-66.sa-east-1.compute.amazonaws.com", user: "ubuntu", roles: %w{nginx}

set :nginx_template, "#{stage_config_path}/nginx.conf.erb"
set :nginx_redirected_domains, "172.31.1.132"
set :nginx_domains, "52.67.216.66"
set :application, ask('set the name for the app')
#set :application2, ask('set the path for the other server')
set :nginx_sudo_paths, [:nginx_log_path, :nginx_sites_enabled_dir, :nginx_sites_available_dir]
set :nginx_sudo_tasks, ['nginx:start', 'nginx:stop', 'nginx:restart', 'nginx:reload', 'nginx:configtest', 'nginx:site:add', 'nginx:site:disable', 'nginx:site:enable', 'nginx:site:remove' ]
set :nginx_roles , :all
set :nginx_service_path, "/etc/init.d/nginx"
set :nginx_static_dir, "/var/www/html/"
set :nginx_sites_available_dir, "/etc/nginx/conf.d"
set :nginx_template, "#{stage_config_path}/nginx.conf.erb"
set :nginx_application_name, "#{fetch :application}.conf"
set :nginx_log_path, "/var/www/html/#{fetch :application}/shared/app/logs"
set :nginx_use_ssl, false
set :nginx_read_timeout, 30
set :app_server, true # indica se  terá ou não proxy pass
set :app_server_host, "127.0.0.1"
set :app_server_port, 80
set :ssh_options, {
  forward_agent: true,
  auth_methods: ["publickey"],
  keys: ["~/.ssh/qedu-php7.pem"]  ## modificar path da chave
}
