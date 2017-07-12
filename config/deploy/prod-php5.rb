set :stages, ["prod-php5"]

server "18.231.30.2", user: "ubuntu", roles: %w{php5}



#variaveis
set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader'
set :branch,         "master"
set :deploy_to,      "/var/www/html/#{fetch :application}"
set :url,            "http://qedu.org.br/"
set :application, "qedu"
set :cache_prefix,   "qedu."
set :metrics_prefix, "qedu"
set :server_env,     10
set :http_host,      "www.qedu.org.br"
set :prismic_ref,    "Master"
set :cookie_domain,  ".qedu.org.br"
set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader'
set :symfony_console_path, "bin/console"
set :permission_method, :acl
set :file_permissions_users, ["nginx"]
set :file_permissions_paths, ["var", "web/uploads"]
set :permission_method, true
set :ssh_options, {
  forward_agent: true,
  auth_methods: ["publickey"],
  keys: ["~/.ssh/qedu-php7.pem"]  ## modificar path da chave
}
