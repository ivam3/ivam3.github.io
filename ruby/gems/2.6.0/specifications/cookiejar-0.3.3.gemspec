# -*- encoding: utf-8 -*-
# stub: cookiejar 0.3.3 ruby lib

Gem::Specification.new do |s|
  s.name = "cookiejar".freeze
  s.version = "0.3.3"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["David Waite".freeze]
  s.date = "2014-02-01"
  s.description = "Allows for parsing and returning cookies in Ruby HTTP client code".freeze
  s.email = ["david@alkaline-solutions.com".freeze]
  s.homepage = "http://alkaline-solutions.com".freeze
  s.rdoc_options = ["--title".freeze, "CookieJar -- Client-side HTTP Cookies".freeze]
  s.rubygems_version = "3.0.3".freeze
  s.summary = "Client-side HTTP Cookie library".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_development_dependency(%q<rake>.freeze, ["~> 10.0"])
      s.add_development_dependency(%q<rspec-collection_matchers>.freeze, ["~> 1.0"])
      s.add_development_dependency(%q<rspec>.freeze, ["~> 3.0"])
      s.add_development_dependency(%q<yard>.freeze, ["~> 0.8", ">= 0.8.7"])
      s.add_development_dependency(%q<bundler>.freeze, [">= 0.9.3"])
    else
      s.add_dependency(%q<rake>.freeze, ["~> 10.0"])
      s.add_dependency(%q<rspec-collection_matchers>.freeze, ["~> 1.0"])
      s.add_dependency(%q<rspec>.freeze, ["~> 3.0"])
      s.add_dependency(%q<yard>.freeze, ["~> 0.8", ">= 0.8.7"])
      s.add_dependency(%q<bundler>.freeze, [">= 0.9.3"])
    end
  else
    s.add_dependency(%q<rake>.freeze, ["~> 10.0"])
    s.add_dependency(%q<rspec-collection_matchers>.freeze, ["~> 1.0"])
    s.add_dependency(%q<rspec>.freeze, ["~> 3.0"])
    s.add_dependency(%q<yard>.freeze, ["~> 0.8", ">= 0.8.7"])
    s.add_dependency(%q<bundler>.freeze, [">= 0.9.3"])
  end
end
