# -*- encoding: utf-8 -*-
# stub: em-http-request 1.1.5 ruby lib

Gem::Specification.new do |s|
  s.name = "em-http-request".freeze
  s.version = "1.1.5"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Ilya Grigorik".freeze]
  s.date = "2016-07-01"
  s.description = "EventMachine based, async HTTP Request client".freeze
  s.email = ["ilya@igvita.com".freeze]
  s.homepage = "http://github.com/igrigorik/em-http-request".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "3.0.3".freeze
  s.summary = "EventMachine based, async HTTP Request client".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<addressable>.freeze, [">= 2.3.4"])
      s.add_runtime_dependency(%q<cookiejar>.freeze, ["!= 0.3.1"])
      s.add_runtime_dependency(%q<em-socksify>.freeze, [">= 0.3"])
      s.add_runtime_dependency(%q<eventmachine>.freeze, [">= 1.0.3"])
      s.add_runtime_dependency(%q<http_parser.rb>.freeze, [">= 0.6.0"])
      s.add_development_dependency(%q<mongrel>.freeze, ["~> 1.2.0.pre2"])
      s.add_development_dependency(%q<multi_json>.freeze, [">= 0"])
      s.add_development_dependency(%q<rack>.freeze, [">= 0"])
      s.add_development_dependency(%q<rake>.freeze, [">= 0"])
      s.add_development_dependency(%q<rspec>.freeze, [">= 0"])
    else
      s.add_dependency(%q<addressable>.freeze, [">= 2.3.4"])
      s.add_dependency(%q<cookiejar>.freeze, ["!= 0.3.1"])
      s.add_dependency(%q<em-socksify>.freeze, [">= 0.3"])
      s.add_dependency(%q<eventmachine>.freeze, [">= 1.0.3"])
      s.add_dependency(%q<http_parser.rb>.freeze, [">= 0.6.0"])
      s.add_dependency(%q<mongrel>.freeze, ["~> 1.2.0.pre2"])
      s.add_dependency(%q<multi_json>.freeze, [">= 0"])
      s.add_dependency(%q<rack>.freeze, [">= 0"])
      s.add_dependency(%q<rake>.freeze, [">= 0"])
      s.add_dependency(%q<rspec>.freeze, [">= 0"])
    end
  else
    s.add_dependency(%q<addressable>.freeze, [">= 2.3.4"])
    s.add_dependency(%q<cookiejar>.freeze, ["!= 0.3.1"])
    s.add_dependency(%q<em-socksify>.freeze, [">= 0.3"])
    s.add_dependency(%q<eventmachine>.freeze, [">= 1.0.3"])
    s.add_dependency(%q<http_parser.rb>.freeze, [">= 0.6.0"])
    s.add_dependency(%q<mongrel>.freeze, ["~> 1.2.0.pre2"])
    s.add_dependency(%q<multi_json>.freeze, [">= 0"])
    s.add_dependency(%q<rack>.freeze, [">= 0"])
    s.add_dependency(%q<rake>.freeze, [">= 0"])
    s.add_dependency(%q<rspec>.freeze, [">= 0"])
  end
end
