class apache_configs {
  file { "/etc/apache2/apache2.conf":
    ensure   => present,
    source   => "/vagrant/manifests/apache2.conf",
    mode     => "0644",
  }

  file { "/etc/apache2/conf-available/h5bp-server-configs-apache.conf":
    ensure   => present,
    source   => "/vagrant/manifests/h5bp-server-configs-apache.conf",
    mode     => "0644",
  }
}

include apache_configs
