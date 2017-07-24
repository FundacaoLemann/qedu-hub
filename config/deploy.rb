# config valid only for current version of Capistrano
lock "3.8.2"

set :application, "qedu-hub"
set :repo_url, "git@github.com:QEdu/qedu-hub.git"

# Default branch is :master
ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/var/www/qedu-hub"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
set :pty, true
set :tmp_dir, '/tmp/deployqeduhub'

# Default value for :linked_files is []
# append :linked_files, "config/database.yml", "config/secrets.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
set :local_user, -> { `git config user.name`.chomp }
set :use_sudo, true
set :symfony_console_path, 'bin/console'

# Default value for keep_releases is 5
# set :keep_releases, 5

after 'deploy:starting', 'composer:install_executable'
after 'deploy:updated', 'notify:slack'

namespace :phpfpm do
    desc "Restarting PHP-FPM"
    task :restart do
        run "sudo service php7-fpm restart"
    end
end

namespace :notify do
  desc "Notify Slack of a deployment"
  task :slack do
    user = `git config user.name`.strip
    tag = `git describe --abbrev=0 --tags`.strip

    slack_command = "curl -s -X POST \"https://hooks.slack.com/services/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\" -H \"Content-Type: application/json\" -d '{\"username\": \"#{user}\",\"text\": \":qedu: *QEdu-hub* at `staging` - #{user} deployed branch `master` (#{tag}). :rocket:\",\"icon_url\": \"https://avatars2.githubusercontent.com/u/58257?v=3&s=40\"}'"

    puts "--> Notifying Slack"
    # run slack_command
  end
end