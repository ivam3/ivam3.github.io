# -*- encoding: utf-8 -*-
# stub: rubydns 1.0.3 ruby lib

Gem::Specification.new do |s|
  s.name = "rubydns".freeze
  s.version = "1.0.3"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Samuel Williams".freeze]
  s.date = "2016-01-03"
  s.description = "\t\tRubyDNS is a high-performance DNS server which can be easily integrated into\n\t\tother projects or used as a stand-alone daemon. By default it uses\n\t\trule-based pattern matching. Results can be hard-coded, computed, fetched from\n\t\ta remote DNS server or fetched from a local cache, depending on requirements.\n\n\t\tIn addition, RubyDNS includes a high-performance asynchronous DNS resolver\n\t\tbuilt on top of Celluloid. This module can be used by itself in client\n\t\tapplications without using the full RubyDNS server stack.\n".freeze
  s.email = ["samuel.williams@oriontransfer.co.nz".freeze]
  s.executables = ["rubydns-check".freeze]
  s.files = ["bin/rubydns-check".freeze]
  s.homepage = "http://www.codeotaku.com/projects/rubydns".freeze
  s.licenses = ["MIT".freeze]
  s.required_ruby_version = Gem::Requirement.new(">= 1.9.3".freeze)
  s.rubygems_version = "3.0.3".freeze
  s.summary = "An easy to use DNS server and resolver for Ruby.".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<celluloid>.freeze, ["= 0.16.0"])
      s.add_runtime_dependency(%q<celluloid-io>.freeze, ["= 0.16.2"])
      s.add_runtime_dependency(%q<timers>.freeze, ["~> 4.0.1"])
      s.add_development_dependency(%q<bundler>.freeze, ["~> 1.3"])
      s.add_development_dependency(%q<process-daemon>.freeze, ["~> 0.5.5"])
      s.add_development_dependency(%q<rspec>.freeze, ["~> 3.2.0"])
      s.add_development_dependency(%q<rake>.freeze, [">= 0"])
    else
      s.add_dependency(%q<celluloid>.freeze, ["= 0.16.0"])
      s.add_dependency(%q<celluloid-io>.freeze, ["= 0.16.2"])
      s.add_dependency(%q<timers>.freeze, ["~> 4.0.1"])
      s.add_dependency(%q<bundler>.freeze, ["~> 1.3"])
      s.add_dependency(%q<process-daemon>.freeze, ["~> 0.5.5"])
      s.add_dependency(%q<rspec>.freeze, ["~> 3.2.0"])
      s.add_dependency(%q<rake>.freeze, [">= 0"])
    end
  else
    s.add_dependency(%q<celluloid>.freeze, ["= 0.16.0"])
    s.add_dependency(%q<celluloid-io>.freeze, ["= 0.16.2"])
    s.add_dependency(%q<timers>.freeze, ["~> 4.0.1"])
    s.add_dependency(%q<bundler>.freeze, ["~> 1.3"])
    s.add_dependency(%q<process-daemon>.freeze, ["~> 0.5.5"])
    s.add_dependency(%q<rspec>.freeze, ["~> 3.2.0"])
    s.add_dependency(%q<rake>.freeze, [">= 0"])
  end
end
