# -*- encoding: utf-8 -*-
# stub: openssl-ccm 1.2.2 ruby lib

Gem::Specification.new do |s|
  s.name = "openssl-ccm".freeze
  s.version = "1.2.2"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Lars Schmertmann".freeze]
  s.date = "2019-01-08"
  s.description = "Ruby Gem for RFC 3610 - Counter with CBC-MAC (CCM)".freeze
  s.email = ["SmallLars@t-online.de".freeze]
  s.extra_rdoc_files = ["README.md".freeze, "LICENSE".freeze]
  s.files = ["LICENSE".freeze, "README.md".freeze]
  s.homepage = "https://github.com/smalllars/openssl-ccm".freeze
  s.licenses = ["MIT".freeze]
  s.post_install_message = "Thanks for installing!".freeze
  s.rdoc_options = ["-x".freeze, "test/data_*".freeze]
  s.required_ruby_version = Gem::Requirement.new(">= 2.0.0".freeze)
  s.rubygems_version = "3.0.3".freeze
  s.summary = "RFC 3610 - CCM".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_development_dependency(%q<rake>.freeze, ["~> 12.3", ">= 12.3.2"])
      s.add_development_dependency(%q<rdoc>.freeze, ["~> 4.3", ">= 4.3.0"])
      s.add_development_dependency(%q<yard>.freeze, ["~> 0.9", ">= 0.9.16"])
      s.add_development_dependency(%q<rubocop>.freeze, ["~> 0.50", ">= 0.50.0"])
      s.add_development_dependency(%q<test-unit>.freeze, ["~> 3.2", ">= 3.2.9"])
      s.add_development_dependency(%q<coveralls>.freeze, ["~> 0.8", ">= 0.8.22"])
    else
      s.add_dependency(%q<rake>.freeze, ["~> 12.3", ">= 12.3.2"])
      s.add_dependency(%q<rdoc>.freeze, ["~> 4.3", ">= 4.3.0"])
      s.add_dependency(%q<yard>.freeze, ["~> 0.9", ">= 0.9.16"])
      s.add_dependency(%q<rubocop>.freeze, ["~> 0.50", ">= 0.50.0"])
      s.add_dependency(%q<test-unit>.freeze, ["~> 3.2", ">= 3.2.9"])
      s.add_dependency(%q<coveralls>.freeze, ["~> 0.8", ">= 0.8.22"])
    end
  else
    s.add_dependency(%q<rake>.freeze, ["~> 12.3", ">= 12.3.2"])
    s.add_dependency(%q<rdoc>.freeze, ["~> 4.3", ">= 4.3.0"])
    s.add_dependency(%q<yard>.freeze, ["~> 0.9", ">= 0.9.16"])
    s.add_dependency(%q<rubocop>.freeze, ["~> 0.50", ">= 0.50.0"])
    s.add_dependency(%q<test-unit>.freeze, ["~> 3.2", ">= 3.2.9"])
    s.add_dependency(%q<coveralls>.freeze, ["~> 0.8", ">= 0.8.22"])
  end
end
