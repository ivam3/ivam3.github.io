# -*- encoding: utf-8 -*-
# stub: lolcat 99.9.69 ruby lib

Gem::Specification.new do |s|
  s.name = "lolcat".freeze
  s.version = "99.9.69"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Moe".freeze]
  s.date = "2019-04-04"
  s.description = "Rainbows and unicorns!".freeze
  s.email = ["moe@busyloop.net".freeze]
  s.executables = ["lolcat".freeze]
  s.files = ["bin/lolcat".freeze]
  s.homepage = "https://github.com/busyloop/lolcat".freeze
  s.rubygems_version = "3.0.3".freeze
  s.summary = "Okay, no unicorns. But rainbows!!".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_development_dependency(%q<rake>.freeze, [">= 0"])
      s.add_runtime_dependency(%q<paint>.freeze, ["~> 2.0.0"])
      s.add_runtime_dependency(%q<optimist>.freeze, ["~> 3.0.0"])
      s.add_runtime_dependency(%q<manpages>.freeze, ["~> 0.6.1"])
    else
      s.add_dependency(%q<rake>.freeze, [">= 0"])
      s.add_dependency(%q<paint>.freeze, ["~> 2.0.0"])
      s.add_dependency(%q<optimist>.freeze, ["~> 3.0.0"])
      s.add_dependency(%q<manpages>.freeze, ["~> 0.6.1"])
    end
  else
    s.add_dependency(%q<rake>.freeze, [">= 0"])
    s.add_dependency(%q<paint>.freeze, ["~> 2.0.0"])
    s.add_dependency(%q<optimist>.freeze, ["~> 3.0.0"])
    s.add_dependency(%q<manpages>.freeze, ["~> 0.6.1"])
  end
end
