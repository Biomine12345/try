class jcseg_configs {
  file {"/opt/wildfly/biomine/jcseg/jcseg.properties":
    ensure   => present,
    source   => "/vagrant/manifests/jcseg.properties",
    mode     => "0644",
  }
  
  file {"/opt/wildfly/biomine/jcseg/lexicon":
    ensure   => directory,
    source   => "/vagrant/manifests/lexicon",
    recurse  => true,
    mode     => "0644",
  }
}

include jcseg_configs
