# -*- encoding: utf-8 -*-
# stub: net-ssh 5.2.0 ruby lib

Gem::Specification.new do |s|
  s.name = "net-ssh".freeze
  s.version = "5.2.0"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Jamis Buck".freeze, "Delano Mandelbaum".freeze, "Mikl\u00F3s Fazekas".freeze]
  s.bindir = "exe".freeze
  s.cert_chain = ["-----BEGIN CERTIFICATE-----\nMIIDQDCCAiigAwIBAgIBATANBgkqhkiG9w0BAQsFADAlMSMwIQYDVQQDDBpuZXRz\nc2gvREM9c29sdXRpb3VzL0RDPWNvbTAeFw0xOTAzMTEwOTQ1MzZaFw0yMDAzMTAw\nOTQ1MzZaMCUxIzAhBgNVBAMMGm5ldHNzaC9EQz1zb2x1dGlvdXMvREM9Y29tMIIB\nIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxieE22fR/qmdPKUHyYTyUx2g\nwskLwrCkxay+Tvc97ZZUOwf85LDDDPqhQaTWLvRwnIOMgQE2nBPzwalVclK6a+pW\nx/18KDeZY15vm3Qn5p42b0wi9hUxOqPm3J2hdCLCcgtENgdX21nVzejn39WVqFJO\nlntgSDNW5+kCS8QaRsmIbzj17GKKkrsw39kiQw7FhWfJFeTjddzoZiWwc59KA/Bx\nfBbmDnsMLAtAtauMOxORrbx3EOY7sHku/kSrMg3FXFay7jc6BkbbUij+MjJ/k82l\n4o8o0YO4BAnya90xgEmgOG0LCCxRhuXQFnMDuDjK2XnUe0h4/6NCn94C+z9GsQID\nAQABo3sweTAJBgNVHRMEAjAAMAsGA1UdDwQEAwIEsDAdBgNVHQ4EFgQUBfKiwO2e\nM4NEiRrVG793qEPLYyMwHwYDVR0RBBgwFoEUbmV0c3NoQHNvbHV0aW91cy5jb20w\nHwYDVR0SBBgwFoEUbmV0c3NoQHNvbHV0aW91cy5jb20wDQYJKoZIhvcNAQELBQAD\nggEBAILNXrrFaLruwlBoTx3F7iL5wiRUT+cOMfdon25gzX8Tf87hi6rITnRgFfak\nw+C/rbrYOuEfUJMeZSU5ASxzrB4ohgJ5AFxuxGNkWEQJC4nICGn3ML8PmHzEV12z\n+nMm9AtBM16dJTdTKA2B6du0ZtTtbm4M3ULB7rhkUO2L2RbDyyiGQw85IBdaVdzr\nGmrxZPAOhBABOREsvJU1+3GIyJncqXmtrYUGUoLiIf/WO0mxPzYALZC/6ZYfu2UP\n+MqVFjDxsJA7cDfACke51RypSH1gZoPjzoW6w0sMRAzZT8hU1eGyqtNuBiSZ1UKv\nB/ztNLEP0OWhpj/NZ1fnGRvo/T0=\n-----END CERTIFICATE-----\n".freeze]
  s.date = "2019-03-11"
  s.description = "Net::SSH: a pure-Ruby implementation of the SSH2 client protocol. It allows you to write programs that invoke and interact with processes on remote servers, via SSH2.".freeze
  s.email = ["net-ssh@solutious.com".freeze]
  s.extra_rdoc_files = ["LICENSE.txt".freeze, "README.rdoc".freeze]
  s.files = ["LICENSE.txt".freeze, "README.rdoc".freeze]
  s.homepage = "https://github.com/net-ssh/net-ssh".freeze
  s.licenses = ["MIT".freeze]
  s.required_ruby_version = Gem::Requirement.new(">= 2.2.6".freeze)
  s.rubygems_version = "3.0.3".freeze
  s.summary = "Net::SSH: a pure-Ruby implementation of the SSH2 client protocol.".freeze

  s.installed_by_version = "3.0.3" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4

    if Gem::Version.new(Gem::VERSION) >= Gem::Version.new('1.2.0') then
      s.add_development_dependency(%q<bcrypt_pbkdf>.freeze, ["~> 1.0"])
      s.add_development_dependency(%q<ed25519>.freeze, ["~> 1.2"])
      s.add_development_dependency(%q<bundler>.freeze, ["~> 1.11"])
      s.add_development_dependency(%q<minitest>.freeze, ["~> 5.10"])
      s.add_development_dependency(%q<mocha>.freeze, [">= 1.2.1"])
      s.add_development_dependency(%q<rake>.freeze, ["~> 12.0"])
      s.add_development_dependency(%q<rubocop>.freeze, ["~> 0.54.0"])
    else
      s.add_dependency(%q<bcrypt_pbkdf>.freeze, ["~> 1.0"])
      s.add_dependency(%q<ed25519>.freeze, ["~> 1.2"])
      s.add_dependency(%q<bundler>.freeze, ["~> 1.11"])
      s.add_dependency(%q<minitest>.freeze, ["~> 5.10"])
      s.add_dependency(%q<mocha>.freeze, [">= 1.2.1"])
      s.add_dependency(%q<rake>.freeze, ["~> 12.0"])
      s.add_dependency(%q<rubocop>.freeze, ["~> 0.54.0"])
    end
  else
    s.add_dependency(%q<bcrypt_pbkdf>.freeze, ["~> 1.0"])
    s.add_dependency(%q<ed25519>.freeze, ["~> 1.2"])
    s.add_dependency(%q<bundler>.freeze, ["~> 1.11"])
    s.add_dependency(%q<minitest>.freeze, ["~> 5.10"])
    s.add_dependency(%q<mocha>.freeze, [">= 1.2.1"])
    s.add_dependency(%q<rake>.freeze, ["~> 12.0"])
    s.add_dependency(%q<rubocop>.freeze, ["~> 0.54.0"])
  end
end
