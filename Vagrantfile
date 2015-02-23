Vagrant.configure('2') do |config|
  config.ssh.forward_agent = true
  config.vm.box = 'cargomedia/debian-7-amd64-cm'

  config.vm.hostname = 'www.denkmal.dev'
  if Vagrant.has_plugin? 'landrush'
    config.landrush.enable
    config.landrush.tld = 'dev'
    config.landrush.host 'denkmal.dev'
  end

  if Vagrant.has_plugin? 'vagrant-phpstorm-tunnel'
    config.phpstorm_tunnel.project_home = '/home/vagrant/denkmal'
    config.phpstorm_tunnel.command_prefix = 'sudo'
  end

  config.vm.network :private_network, ip: '10.10.10.12'
  config.vm.synced_folder '.', '/home/vagrant/denkmal', :type => 'nfs'
  config.vm.synced_folder '../CM', '/home/vagrant/CM', :type => 'nfs' if Dir.exists? '../CM'

  config.librarian_puppet.puppetfile_dir = 'puppet'
  config.librarian_puppet.placeholder_filename = '.gitkeep'
  config.librarian_puppet.resolve_options = {:force => true}
  config.vm.provision :puppet do |puppet|
    puppet.module_path = 'puppet/modules'
    puppet.manifests_path = 'puppet/manifests'
  end

  config.vm.provision 'shell', run: 'always', inline: [
    'cd /home/vagrant/denkmal',
    '(test ! -L vendor/cargomedia/cm || rm vendor/cargomedia/cm)',
    'composer --no-interaction install --dev',
  ].join(' && ')

  if ENV['LINK']
      config.vm.provision 'shell', run: 'always', inline: [
        'cd /home/vagrant/denkmal',
        'rm -rf vendor/cargomedia/cm',
        'ln -s ../../../CM vendor/cargomedia/cm',
      ].join(' && ')
  end

  config.vm.provision 'shell', run: 'always', inline: [
    'cd /home/vagrant/denkmal',
    'cp resources/config/local.dev.php resources/config/local.php',
    'bin/cm app set-deploy-version',
    'bin/cm app setup',
    'bin/cm db run-updates',
    'sudo foreman-debian stop --app denkmal',
    'sudo foreman-debian install --app denkmal --user root',
    'sudo foreman-debian start --app denkmal',
  ].join(' && ')
end
