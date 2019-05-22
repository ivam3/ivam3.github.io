# -*- encoding: utf-8 -*-
# stub: shodan 1.0.0 ruby lib

Gem::Specification.new do |s|
  s.name = "shodan".freeze
  s.version = "1.0.0"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["John Matherly".freeze]
  s.date = "2014-02-19"
  s.description = "  A Ruby library to interact with the Shodan API.\n".freeze
  s.email = "jmath@shodan.io".freeze
  s.extra_rdoc_files = ["LICENSE".freeze, "README.md".freeze]
  s.files = ["LICENSE".freeze, "README.md".freeze]
  s.homepage = "http://github.com/achillean/shodan-ruby".freeze
  s.rdoc_options = ["--charset=UTF-8".freeze]
  s.rubygems_version = "3.0.3".freeze
  s.summary = "A Ruby library to interact with the Shodan API.".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 3

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_runtime_dependency(%q<json>.freeze, [">= 1.4.6"])
    else
      s.add_dependency(%q<json>.freeze, [">= 1.4.6"])
    end
  else
    s.add_dependency(%q<json>.freeze, [">= 1.4.6"])
  end
end
