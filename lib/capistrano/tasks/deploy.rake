namespace :dep do
   task :composer_install do
        on roles(:php7, :php5) do
          execute "cd #{release_path} && composer install --no-dev -o --no-interaction --no-progress"
        end
   end

   task :node do
        on roles(:php7, :php5) do
          execute "cd #{release_path} && npm_config_registry='http://registry.npmjs.org' npm install 2>/dev/null"
        end
   end
   task :include do
        on roles(:php7, :php5) do
          execute "sudo echo 'include /etc/nginx/conf.d/#{fetch :application}.conf;' >> /etc/nginx/sites-enabled/default.conf"
        end
   end
end
