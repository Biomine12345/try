class wildfly_configs {
  file {"/etc/default/wildfly":
    ensure   => present,
    source   => "/vagrant/manifests/wildfly",
    mode     => "0644",
  }
  
  file {"/opt/wildfly/bin/standalone.conf":
    ensure   => present,
    source   => "/vagrant/manifests/standalone.conf",
    mode     => "0644",
  }
  
  file {"/opt/wildfly/standalone/configuration/standalone.xml":
    ensure   => present,
    source   => "/vagrant/manifests/standalone.xml",
    mode     => "0644",
  }
}

include wildfly_configs
