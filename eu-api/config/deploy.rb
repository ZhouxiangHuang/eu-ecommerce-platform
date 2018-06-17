# config valid only for Capistrano 3.1
lock '3.5.0'

set :application, 'yii'
#set :repo_url, 'git@github.com:gre-foundation/gre-app-server.git'
set :scm, :copy
set :exclude_dir, "{.svn,.git,vendor,lib,Gemfile,Gemfile.*,Capfile,Uploads,runtime,tests,}"

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call

# Default deploy_to directory is /var/www/my_app
set :deploy_to, '/data/website/omart/'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, %w{config/database.yml}

# Default value for linked_dirs is []
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5

set :format, :pretty
set :log_level, :debug
set :keep_releases, 100



namespace :deploy do
  httpd_user = "nobody"
  httpd_group = "nobody"

  task :update_source do
    on roles(:all) do
	  puts "\n\n=== Svn update ===\n\n"
	  system "git add ."
	  system "git commit -am '修改'"
	  system "git push -u origin master"
	end
  end
  desc 'Restart application'
  task :restart do
    on roles(:all) do
      puts "restart app"
      #upload!("web/.htaccess", "#{current_path}/web")
      # Your restart mechanism here, for example:

      execute :mkdir, "-p", "#{shared_path}/frontend_runtime"
      execute :ln, "-sf", "#{shared_path}/frontend_runtime", "#{current_path}/runtime"
      execute :mkdir, "-p", "#{shared_path}/frontend_assets"
      execute :ln, "-sf", "#{shared_path}/frontend_assets", "#{current_path}/web/assets"

      execute :sudo, 'chown', "-R", "#{httpd_user}:#{httpd_group}", "#{shared_path}/frontend_runtime"
      execute :sudo, 'chown', "-R", "#{httpd_user}:#{httpd_group}", "#{shared_path}/frontend_assets"

      execute :mkdir, "-p", "#{shared_path}/Uploads"
      execute :ln, "-sf", "#{shared_path}/Uploads", "#{current_path}/web/Uploads"
      execute :sudo, 'chown', "-R", "#{httpd_user}:#{httpd_group}", "#{shared_path}/Uploads"

      execute :ln, "-sf", "#{shared_path}/vendor", "#{current_path}/vendor"
      # execute fetch(:php_bin), "#{current_path}/init", "--env=#{fetch(:environment).capitalize}", "--overwrite=a"

      execute :mkdir, "-p", "#{shared_path}/assets"
      execute :ln, "-sf", "#{shared_path}/assets", "#{current_path}/web/assets"

      execute :chmod, "-R", "0744", current_path
      execute :sudo, 'chown', "-RH", "--dereference", "#{httpd_user}:#{httpd_group}", current_path
    end
  end

  desc 'Restart PHP'
  task :restart_php do
    on roles(:all) do
      puts "Restart PHP"
      execute "service", "httpd", "restart"
    end
  end

  desc 'Migration database'
  task :migrate do
    on roles(:all) do
      puts "Migration database"
      execute :sudo, "APP_ENV=" + fetch(:environment), fetch(:php_bin), "#{current_path}/yii", "migrate/up", "--interactive=0"
    end
  end
  desc 'Delete Releases'
  task :delete do
      on roles(:all) do
        puts "Deleting old files"
        time = Time.new - (3600 * 24 * 5)
        date = time.strftime("%Y%m%d")
        execute :sudo, "rm -rf /data/website/omart/releases/" + date + "*"
      end
    end
  desc "Update vendor"
  task :update_vendor do
    on roles(:all) do
      #system "composer update --prefer-dist"
      tar_file = "vendor"
      system "tar -czf vendor.tar.gz #{tar_file}"

      tmp_file = capture("mktemp")

      upload!("vendor.tar.gz", tmp_file)

      execute :sudo, :tar, "-xzf", tmp_file, "-C", shared_path
      execute :sudo, :chmod, "-R", "0744", "#{shared_path}/#{tar_file}"
      execute :sudo, :sudo, 'chown', "-R", "#{httpd_user}:#{httpd_group}", "#{shared_path}/#{tar_file}"
      execute :sudo, :rm, tmp_file

      system "rm -rf vendor.tar.gz"
    end
  end
  desc "Update upload"
  task :update_upload do
    on roles(:all) do
      tar_file = "Uploads"
      system "tar -czf upload.tar.gz #{tar_file}"

      tmp_file = capture("mktemp")

      upload!("upload.tar.gz", tmp_file)

      execute :tar, "-xzf", tmp_file, "-C", shared_path
      execute :chmod, "-R", "0744", "#{shared_path}/#{tar_file}"
      execute :sudo, 'chown', "-R", "#{httpd_user}:#{httpd_group}", "#{shared_path}/#{tar_file}"
      execute :rm, tmp_file

      system "rm -rf upload.tar.gz"
    end
  end

  #before :started, :update_source
  after :publishing, :restart
  after :restart, :migrate
  after :migrate, :delete
  #after :finishing, :restart_php

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end
end
