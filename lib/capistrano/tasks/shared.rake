namespace :shared do
    task :googlewmt do
      on roles(:php7) do
        execute "cd #{release_path}/public && ln -s ../../../shared/googleba542b7c90582163.html"
      end
    end
end
