set :stages, ["prod"]

server "ec2-52-67-216-66.sa-east-1.compute.amazonaws.com", user: "ubuntu", roles: %w{php7}



#variaveis
set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader'
set :branch,         "master"
set :deploy_to,      "/var/www/html/#{fetch :application}"
set :url,            "http://qedu.org.br/"
set :cache_prefix,   "qedu."
#set :application, ask("set the correct app:")
set :metrics_prefix, "qedu"
set :server_env,     10
set :http_host,      "www.qedu.org.br"
set :prismic_ref,    "Master"
set :cookie_domain,  ".qedu.org.br"
set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader'
set :symfony_console_path, "bin/console"
set :ssh_options, {
  forward_agent: true,
  auth_methods: ["publickey"],
  keys: ["~/.ssh/qedu-php7.pem"]  ## modificar path da chave
}
