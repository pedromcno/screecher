# Screecher App

To run this app, you'll need to have vagrant installed. You can go here https://www.vagrantup.com/ to figure out how to install it. Keep in mind that you'll also need to get  VirtualBox.

As soon as you're done install VirtualBox and Vagrant, you'll need to clone this repository and ``cd`` into the project root folder (the one with the ``VagrantFile`` in it). There, you'll need to run ``vagrant up``. This might take a few minutes, as the vagrant box needs to be downloaded and so forth. 

In the meantime, you can go into the ``application`` folder and run ``composer update``. This will download Silex and should get you a running application.

After both vagrant and composer are done with their jobs, go back to the project root folder and ssh into the machine (via ``vagrant ssh``). Here you need to navigate to the ``/vagrant/vagrant`` folder and run ``sudo php bootstrap.php``.

As soon as all is done, you should click here:

[Click me!](http://192.168.33.10/)

That should be it!




