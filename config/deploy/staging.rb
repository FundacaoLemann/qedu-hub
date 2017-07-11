
server "ec2-54-233-112-115.sa-east-1.compute.amazonaws.com", user: "ec2-user", roles: %w{php7}



#variaveis
set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader'
set :branch,         "branch-stage"
set :deploy_to,      "/var/www/html/#{fetch :application}"
set :url,            "http://qa.qedu.org.br/"
set :cache_prefix,   "qedu-stage"
set :metrics_prefix, "qedu-stage"
set :server_env,     10
set :http_host,      "qa.qedu.org.br"
set :curl_options,   "-umeritts:iwantitall"
set :prismic_ref,    "Depoimentos"
set :cookie_domain,  "qa.qedu.org.br"
set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader'


after "deploy:log_revision", "dep:node"
after "dep:node", "shared:googlewmt"
after "shared:googlewmt", "dep:permissao"
after "dep:permissao", "dep:include"
after "dep:include","restart:nginx"
