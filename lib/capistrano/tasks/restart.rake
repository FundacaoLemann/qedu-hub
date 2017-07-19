namespace :restart do
  desc "restart nginx"
  task :nginx do
    on roles(:php7) do
      sudo :service, 'nginx', :restart
    end
  end
end
