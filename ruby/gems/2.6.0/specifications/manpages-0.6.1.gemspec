# -*- encoding: utf-8 -*-
# stub: manpages 0.6.1 ruby lib

Gem::Specification.new do |s|
  s.name = "manpages".freeze
  s.version = "0.6.1"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Bodo Tasche".freeze]
  s.bindir = "exe".freeze
  s.date = "2017-02-05"
  s.description = "With this gem the rubygems command will detect man pages within gems and exposes them to the man command.".freeze
  s.email = ["bodo@tasche.me".freeze]
  s.homepage = "https://github.com/bitboxer/manpages".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "3.0.3".freeze
  s.summary = "Adds support for man pages to rubygems".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_development_dependency(%q<bundler>.freeze, ["~> 1.8"])
      s.add_development_dependency(%q<rake>.freeze, ["~> 10.0"])
      s.add_development_dependency(%q<rspec>.freeze, ["~> 3.0"])
      s.add_development_dependency(%q<pry>.freeze, ["~> 0"])
      s.add_development_dependency(%q<rubocop>.freeze, ["~> 0.44.1"])
    else
      s.add_dependency(%q<bundler>.freeze, ["~> 1.8"])
      s.add_dependency(%q<rake>.freeze, ["~> 10.0"])
      s.add_dependency(%q<rspec>.freeze, ["~> 3.0"])
      s.add_dependency(%q<pry>.freeze, ["~> 0"])
      s.add_dependency(%q<rubocop>.freeze, ["~> 0.44.1"])
    end
  else
    s.add_dependency(%q<bundler>.freeze, ["~> 1.8"])
    s.add_dependency(%q<rake>.freeze, ["~> 10.0"])
    s.add_dependency(%q<rspec>.freeze, ["~> 3.0"])
    s.add_dependency(%q<pry>.freeze, ["~> 0"])
    s.add_dependency(%q<rubocop>.freeze, ["~> 0.44.1"])
  end
end
