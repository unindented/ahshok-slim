Vagrant.configure("2") do |config|
  config.vm.box = "precise64"
  config.vm.box_url = "http://files.vagrantup.com/precise64.box"

  config.vm.network :private_network, ip: "192.168.168.168"
  config.ssh.forward_agent = true

  config.vm.hostname = "ahshok.local"

  config.vm.provider :virtualbox do |v|
    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--memory", 1024]
    v.customize ["modifyvm", :id, "--name", "ahshok"]
  end

  nfs_setting = RUBY_PLATFORM =~ /darwin/ || RUBY_PLATFORM =~ /linux/
  config.vm.synced_folder "./", "/var/www/", id: "vagrant-root", :nfs => nfs_setting

  config.vm.provision :shell, :inline =>
    "sed -i 's/^mesg n$/tty -s \\&\\& mesg n/g' /root/.profile"

  config.vm.provision :shell, :inline =>
    "if [[ ! -f /.apt-get ]]; then sudo apt-get update && sudo touch /.apt-get; fi"

  config.vm.provision :shell, :inline =>
    "echo -e 'mysql_root_password=root\\ncontroluser_password=awesome' > /etc/phpmyadmin.facts;"

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "puppet/manifests"
    puppet.module_path = "puppet/modules"
    puppet.options = ['--verbose']
  end
end
