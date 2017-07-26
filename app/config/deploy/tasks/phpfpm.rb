namespace :phpfpm do
  desc "Restart php-fpm"
  task :restart do
    on roles :all do
      execute 'sudo service php7-fpm restart'
    end
  end
end
