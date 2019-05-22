# -*- encoding: utf-8 -*-
# stub: celluloid-io 0.16.2 ruby lib

Gem::Specification.new do |s|
  s.name = "celluloid-io".freeze
  s.version = "0.16.2"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Tony Arcieri".freeze]
  s.date = "2015-01-30"
  s.description = "Evented IO for Celluloid actors".freeze
  s.email = ["tony.arcieri@gmail.com".freeze]
  s.homepage = "http://github.com/celluloid/celluloid-io".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "3.0.3".freeze
  s.summary = "Celluloid::IO allows you to monitor multiple IO objects within a Celluloid actor".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<celluloid>.freeze, [">= 0.16.0"])
      s.add_runtime_dependency(%q<nio4r>.freeze, [">= 1.1.0"])
      s.add_development_dependency(%q<rake>.freeze, [">= 0"])
      s.add_development_dependency(%q<rspec>.freeze, ["~> 2.14.0"])
      s.add_development_dependency(%q<benchmark_suite>.freeze, [">= 0"])
      s.add_development_dependency(%q<guard-rspec>.freeze, [">= 0"])
      s.add_development_dependency(%q<rb-fsevent>.freeze, ["~> 0.9.1"])
    else
      s.add_dependency(%q<celluloid>.freeze, [">= 0.16.0"])
      s.add_dependency(%q<nio4r>.freeze, [">= 1.1.0"])
      s.add_dependency(%q<rake>.freeze, [">= 0"])
      s.add_dependency(%q<rspec>.freeze, ["~> 2.14.0"])
      s.add_dependency(%q<benchmark_suite>.freeze, [">= 0"])
      s.add_dependency(%q<guard-rspec>.freeze, [">= 0"])
      s.add_dependency(%q<rb-fsevent>.freeze, ["~> 0.9.1"])
    end
  else
    s.add_dependency(%q<celluloid>.freeze, [">= 0.16.0"])
    s.add_dependency(%q<nio4r>.freeze, [">= 1.1.0"])
    s.add_dependency(%q<rake>.freeze, [">= 0"])
    s.add_dependency(%q<rspec>.freeze, ["~> 2.14.0"])
    s.add_dependency(%q<benchmark_suite>.freeze, [">= 0"])
    s.add_dependency(%q<guard-rspec>.freeze, [">= 0"])
    s.add_dependency(%q<rb-fsevent>.freeze, ["~> 0.9.1"])
  end
end
