# encoding: ascii-8bit
# frozen-string-literal: false
#
# The module storing Ruby interpreter configurations on building.
#
# This file was created by mkconfig.rb when ruby was built.  It contains
# build information for ruby which is used e.g. by mkmf to build
# compatible native extensions.  Any changes made to this file will be
# lost the next time ruby is built.

module RbConfig
  RUBY_VERSION.start_with?("2.6.") or
    raise "ruby lib version (2.6.3) doesn't match executable version (#{RUBY_VERSION})"

  # Ruby installed directory.
  TOPDIR = File.dirname(__FILE__).chomp!("/lib/ruby/2.6.0/arm-linux-androideabi")
  # DESTDIR on make install.
  DESTDIR = '' unless defined? DESTDIR
  # The hash configurations stored.
  CONFIG = {}
  CONFIG["DESTDIR"] = DESTDIR
  CONFIG["MAJOR"] = "2"
  CONFIG["MINOR"] = "6"
  CONFIG["TEENY"] = "3"
  CONFIG["PATCHLEVEL"] = "62"
  CONFIG["INSTALL"] = "install -c"
  CONFIG["EXEEXT"] = ""
  CONFIG["prefix"] = (TOPDIR || DESTDIR + "/data/data/com.termux/files/usr")
  CONFIG["ruby_install_name"] = "$(RUBY_BASE_NAME)"
  CONFIG["RUBY_INSTALL_NAME"] = "$(RUBY_BASE_NAME)"
  CONFIG["RUBY_SO_NAME"] = "$(RUBY_BASE_NAME)"
  CONFIG["exec"] = "exec"
  CONFIG["ruby_pc"] = "ruby-2.6.pc"
  CONFIG["CC_WRAPPER"] = ""
  CONFIG["PACKAGE"] = "ruby"
  CONFIG["BUILTIN_TRANSSRCS"] = " enc/trans/newline.c"
  CONFIG["MANTYPE"] = "man"
  CONFIG["vendorarchhdrdir"] = "$(vendorhdrdir)/$(sitearch)"
  CONFIG["sitearchhdrdir"] = "$(sitehdrdir)/$(sitearch)"
  CONFIG["rubyarchhdrdir"] = "$(rubyhdrdir)/$(arch)"
  CONFIG["vendorhdrdir"] = "$(rubyhdrdir)/vendor_ruby"
  CONFIG["sitehdrdir"] = "$(rubyhdrdir)/site_ruby"
  CONFIG["rubyhdrdir"] = "$(includedir)/$(RUBY_VERSION_NAME)"
  CONFIG["RUBY_SEARCH_PATH"] = ""
  CONFIG["UNIVERSAL_INTS"] = ""
  CONFIG["UNIVERSAL_ARCHNAMES"] = ""
  CONFIG["configure_args"] = " '--disable-dependency-tracking' '--prefix=/data/data/com.termux/files/usr' '--libdir=/data/data/com.termux/files/usr/lib' '--disable-rpath' '--disable-rpath-hack' '--host=arm-linux-androideabi' 'ac_cv_func_setgroups=no' 'ac_cv_func_setresuid=no' 'ac_cv_func_setreuid=no' '--enable-rubygems' '--without-gdbm' 'ac_cv_lib_crypt_crypt=no' 'rb_cv_type_deprecated=x' 'rb_cv_builtin___builtin_mul_overflow=no' '--disable-nls' '--enable-shared' '--disable-static' '--libexecdir=/data/data/com.termux/files/usr/libexec' 'host_alias=arm-linux-androideabi' 'CC=arm-linux-androideabi-clang' 'CFLAGS= -march=armv7-a -mfpu=neon -mfloat-abi=softfp -mthumb -Oz' 'LDFLAGS=-L/data/data/com.termux/files/usr/lib -march=armv7-a -landroid-support' 'CPPFLAGS=-I/data/data/com.termux/files/usr/include' 'CXX=arm-linux-androideabi-clang++' 'CXXFLAGS= -march=armv7-a -mfpu=neon -mfloat-abi=softfp -mthumb -Os' 'CPP=arm-linux-androideabi-cpp'"
  CONFIG["CONFIGURE"] = "configure"
  CONFIG["vendorarchdir"] = "$(vendorlibdir)/$(sitearch)"
  CONFIG["vendorlibdir"] = "$(vendordir)/$(ruby_version)"
  CONFIG["vendordir"] = "$(rubylibprefix)/vendor_ruby"
  CONFIG["sitearchdir"] = "$(sitelibdir)/$(sitearch)"
  CONFIG["sitelibdir"] = "$(sitedir)/$(ruby_version)"
  CONFIG["sitedir"] = "$(rubylibprefix)/site_ruby"
  CONFIG["rubyarchdir"] = "$(rubylibdir)/$(arch)"
  CONFIG["rubylibdir"] = "$(rubylibprefix)/$(ruby_version)"
  CONFIG["ruby_version"] = "2.6.0"
  CONFIG["sitearch"] = "$(arch)"
  CONFIG["arch"] = "arm-linux-androideabi"
  CONFIG["sitearchincludedir"] = "$(includedir)/$(sitearch)"
  CONFIG["archincludedir"] = "$(includedir)/$(arch)"
  CONFIG["sitearchlibdir"] = "$(libdir)/$(sitearch)"
  CONFIG["archlibdir"] = "$(libdir)/$(arch)"
  CONFIG["libdirname"] = "libdir"
  CONFIG["RUBY_EXEC_PREFIX"] = "/data/data/com.termux/files/usr"
  CONFIG["RUBY_LIB_VERSION"] = ""
  CONFIG["RUBY_LIB_VERSION_STYLE"] = "3\t/* full */"
  CONFIG["RI_BASE_NAME"] = "ri"
  CONFIG["ridir"] = "$(datarootdir)/$(RI_BASE_NAME)"
  CONFIG["rubysitearchprefix"] = "$(rubylibprefix)/$(sitearch)"
  CONFIG["rubyarchprefix"] = "$(rubylibprefix)/$(arch)"
  CONFIG["MAKEFILES"] = "Makefile GNUmakefile"
  CONFIG["PLATFORM_DIR"] = ""
  CONFIG["THREAD_MODEL"] = "pthread"
  CONFIG["SYMBOL_PREFIX"] = ""
  CONFIG["EXPORT_PREFIX"] = ""
  CONFIG["COMMON_HEADERS"] = ""
  CONFIG["COMMON_MACROS"] = ""
  CONFIG["COMMON_LIBS"] = ""
  CONFIG["MAINLIBS"] = "-lz -lgmp -ldl -lm "
  CONFIG["ENABLE_SHARED"] = "yes"
  CONFIG["DLDSHARED"] = "$(CC) -shared"
  CONFIG["DLDLIBS"] = " -lc"
  CONFIG["SOLIBS"] = "$(MAINLIBS)"
  CONFIG["LIBRUBYARG_SHARED"] = "-l$(RUBY_SO_NAME)"
  CONFIG["LIBRUBYARG_STATIC"] = "-l$(RUBY_SO_NAME)-static $(MAINLIBS)"
  CONFIG["LIBRUBYARG"] = "$(LIBRUBYARG_SHARED)"
  CONFIG["LIBRUBY"] = "$(LIBRUBY_SO)"
  CONFIG["LIBRUBY_ALIASES"] = "$(LIBRUBY_SONAME) lib$(RUBY_SO_NAME).$(SOEXT)"
  CONFIG["LIBRUBY_SONAME"] = "lib$(RUBY_SO_NAME).$(SOEXT).$(RUBY_API_VERSION)"
  CONFIG["LIBRUBY_SO"] = "lib$(RUBY_SO_NAME).$(SOEXT).$(RUBY_PROGRAM_VERSION)"
  CONFIG["LIBRUBY_A"] = "lib$(RUBY_SO_NAME)-static.a"
  CONFIG["RUBYW_INSTALL_NAME"] = ""
  CONFIG["rubyw_install_name"] = ""
  CONFIG["EXTDLDFLAGS"] = ""
  CONFIG["EXTLDFLAGS"] = ""
  CONFIG["strict_warnflags"] = "-std=gnu99"
  CONFIG["warnflags"] = "-Wall -Wextra -Wdeclaration-after-statement -Wdeprecated-declarations -Wdivision-by-zero -Wimplicit-function-declaration -Wimplicit-int -Wpointer-arith -Wshorten-64-to-32 -Wwrite-strings -Wmissing-noreturn -Wno-constant-logical-operand -Wno-long-long -Wno-missing-field-initializers -Wno-overlength-strings -Wno-parentheses-equality -Wno-self-assign -Wno-tautological-compare -Wno-unused-parameter -Wno-unused-value -Wunused-variable -Wextra-tokens"
  CONFIG["debugflags"] = "-ggdb3"
  CONFIG["optflags"] = "-O3"
  CONFIG["NULLCMD"] = ":"
  CONFIG["ENABLE_DEBUG_ENV"] = ""
  CONFIG["DLNOBJ"] = "dln.o"
  CONFIG["INSTALL_STATIC_LIBRARY"] = "no"
  CONFIG["MJIT_SUPPORT"] = "yes"
  CONFIG["EXECUTABLE_EXTS"] = ""
  CONFIG["ARCHFILE"] = ""
  CONFIG["LIBRUBY_RELATIVE"] = "no"
  CONFIG["EXTOUT"] = ".ext"
  CONFIG["PREP"] = "$(arch)-fake.rb"
  CONFIG["CROSS_COMPILING"] = "yes"
  CONFIG["TEST_RUNNABLE"] = "no"
  CONFIG["rubylibprefix"] = "$(libdir)/$(RUBY_BASE_NAME)"
  CONFIG["setup"] = "Setup"
  CONFIG["ENCSTATIC"] = ""
  CONFIG["EXTSTATIC"] = ""
  CONFIG["STRIP"] = "arm-linux-androideabi-strip -S -x"
  CONFIG["SOEXT"] = "so"
  CONFIG["TRY_LINK"] = ""
  CONFIG["PRELOADENV"] = "LD_PRELOAD"
  CONFIG["LIBPATHENV"] = "LD_LIBRARY_PATH"
  CONFIG["RPATHFLAG"] = ""
  CONFIG["LIBPATHFLAG"] = " -L%s"
  CONFIG["LINK_SO"] = ""
  CONFIG["ASMEXT"] = "S"
  CONFIG["LIBEXT"] = "a"
  CONFIG["DLEXT2"] = ""
  CONFIG["DLEXT"] = "so"
  CONFIG["LDSHAREDXX"] = "$(CXX) -shared"
  CONFIG["LDSHARED"] = "$(CC) -shared"
  CONFIG["CCDLFLAGS"] = "-fPIC"
  CONFIG["STATIC"] = ""
  CONFIG["ARCH_FLAG"] = ""
  CONFIG["DLDFLAGS"] = "-L/data/data/com.termux/files/usr/lib -march=armv7-a -landroid-support -Wl,--compress-debug-sections=zlib"
  CONFIG["ALLOCA"] = ""
  CONFIG["MATHN"] = "yes"
  CONFIG["dsymutil"] = ""
  CONFIG["codesign"] = ""
  CONFIG["POSTLINK"] = ":"
  CONFIG["WERRORFLAG"] = "-Werror"
  CONFIG["CHDIR"] = "cd -P"
  CONFIG["RMALL"] = "rm -fr"
  CONFIG["RMDIRS"] = "rmdir --ignore-fail-on-non-empty -p"
  CONFIG["RMDIR"] = "rmdir --ignore-fail-on-non-empty"
  CONFIG["CP"] = "cp"
  CONFIG["RM"] = "rm -f"
  CONFIG["PKG_CONFIG"] = "pkg-config"
  CONFIG["DOXYGEN"] = ""
  CONFIG["DOT"] = ""
  CONFIG["MAKEDIRS"] = "mkdir -p"
  CONFIG["MKDIR_P"] = "mkdir -p"
  CONFIG["INSTALL_DATA"] = "$(INSTALL) -m 644"
  CONFIG["INSTALL_SCRIPT"] = "$(INSTALL)"
  CONFIG["INSTALL_PROGRAM"] = "$(INSTALL)"
  CONFIG["SET_MAKE"] = ""
  CONFIG["LN_S"] = "ln -s"
  CONFIG["NM"] = "arm-linux-androideabi-nm"
  CONFIG["DLLWRAP"] = ""
  CONFIG["WINDRES"] = ""
  CONFIG["OBJCOPY"] = ":"
  CONFIG["OBJDUMP"] = "arm-linux-androideabi-objdump"
  CONFIG["ASFLAGS"] = ""
  CONFIG["AS"] = "arm-linux-androideabi-clang"
  CONFIG["ARFLAGS"] = "rcD "
  CONFIG["AR"] = "arm-linux-androideabi-ar"
  CONFIG["RANLIB"] = "arm-linux-androideabi-ranlib"
  CONFIG["try_header"] = ""
  CONFIG["CC_VERSION_MESSAGE"] = "Android (5058415 based on r339409) clang version 8.0.2 (https://android.googlesource.com/toolchain/clang 40173bab62ec746213857d083c0e8b0abb568790) (https://android.googlesource.com/toolchain/llvm 7a6618d69e7e8111e1d49dc9e7813767c5ca756a) (based on LLVM 8.0.2svn)\nTarget: armv7a-unknown-linux-android21\nThread model: posix\nInstalledDir: /home/builder/.termux-build/_cache/android5-19b-arm-21-v3/bin"
  CONFIG["CC_VERSION"] = "$(CC) --version"
  CONFIG["CSRCFLAG"] = ""
  CONFIG["COUTFLAG"] = "-o "
  CONFIG["OUTFLAG"] = "-o "
  CONFIG["CPPOUTFILE"] = "-o conftest.i"
  CONFIG["GNU_LD"] = "no"
  CONFIG["LD"] = "arm-linux-androideabi-ld"
  CONFIG["GCC"] = "yes"
  CONFIG["EGREP"] = "grep -E"
  CONFIG["GREP"] = "grep"
  CONFIG["CPP"] = "arm-linux-androideabi-cpp"
  CONFIG["CXXFLAGS"] = " -march=armv7-a -mfpu=neon -mfloat-abi=softfp -mthumb -Os"
  CONFIG["CXX"] = "arm-linux-androideabi-clang++"
  CONFIG["OBJEXT"] = "o"
  CONFIG["CPPFLAGS"] = "-I/data/data/com.termux/files/usr/include $(DEFS) $(cppflags)"
  CONFIG["LDFLAGS"] = "-L. -L/data/data/com.termux/files/usr/lib -march=armv7-a -landroid-support -fstack-protector-strong -rdynamic -Wl,-export-dynamic"
  CONFIG["CFLAGS"] = " -march=armv7-a -mfpu=neon -mfloat-abi=softfp -mthumb -Oz -fPIC"
  CONFIG["CC"] = "arm-linux-androideabi-clang"
  CONFIG["target_os"] = "linux-androideabi"
  CONFIG["target_vendor"] = "unknown"
  CONFIG["target_cpu"] = "arm"
  CONFIG["target"] = "arm-unknown-linux-androideabi"
  CONFIG["host_os"] = "linux-androideabi"
  CONFIG["host_vendor"] = "unknown"
  CONFIG["host_cpu"] = "arm"
  CONFIG["host"] = "arm-unknown-linux-androideabi"
  CONFIG["RUBY_VERSION_NAME"] = "$(RUBY_BASE_NAME)-$(ruby_version)"
  CONFIG["RUBYW_BASE_NAME"] = "rubyw"
  CONFIG["RUBY_BASE_NAME"] = "ruby"
  CONFIG["build_os"] = "linux-gnu"
  CONFIG["build_vendor"] = "pc"
  CONFIG["build_cpu"] = "x86_64"
  CONFIG["build"] = "x86_64-pc-linux-gnu"
  CONFIG["RUBY_API_VERSION"] = "$(MAJOR).$(MINOR)"
  CONFIG["RUBY_PROGRAM_VERSION"] = "2.6.3"
  CONFIG["HAVE_GIT"] = "yes"
  CONFIG["GIT"] = "git"
  CONFIG["cxxflags"] = "$(optflags) $(debugflags) $(warnflags)"
  CONFIG["cppflags"] = ""
  CONFIG["cflags"] = "$(optflags) $(debugflags) $(warnflags)"
  CONFIG["target_alias"] = ""
  CONFIG["host_alias"] = "arm-linux-androideabi"
  CONFIG["build_alias"] = ""
  CONFIG["LIBS"] = "-lm "
  CONFIG["ECHO_T"] = ""
  CONFIG["ECHO_N"] = "-n"
  CONFIG["ECHO_C"] = ""
  CONFIG["DEFS"] = ""
  CONFIG["mandir"] = "$(datarootdir)/man"
  CONFIG["localedir"] = "$(datarootdir)/locale"
  CONFIG["libdir"] = "$(exec_prefix)/lib"
  CONFIG["psdir"] = "$(docdir)"
  CONFIG["pdfdir"] = "$(docdir)"
  CONFIG["dvidir"] = "$(docdir)"
  CONFIG["htmldir"] = "$(docdir)"
  CONFIG["infodir"] = "$(datarootdir)/info"
  CONFIG["docdir"] = "$(datarootdir)/doc/$(PACKAGE)"
  CONFIG["oldincludedir"] = "/usr/include"
  CONFIG["includedir"] = "$(prefix)/include"
  CONFIG["localstatedir"] = "$(prefix)/var"
  CONFIG["sharedstatedir"] = "$(prefix)/com"
  CONFIG["sysconfdir"] = "$(prefix)/etc"
  CONFIG["datadir"] = "$(datarootdir)"
  CONFIG["datarootdir"] = "$(prefix)/share"
  CONFIG["libexecdir"] = "$(DESTDIR)/data/data/com.termux/files/usr/libexec"
  CONFIG["sbindir"] = "$(exec_prefix)/sbin"
  CONFIG["bindir"] = "$(exec_prefix)/bin"
  CONFIG["exec_prefix"] = "$(prefix)"
  CONFIG["PACKAGE_URL"] = ""
  CONFIG["PACKAGE_BUGREPORT"] = ""
  CONFIG["PACKAGE_STRING"] = ""
  CONFIG["PACKAGE_VERSION"] = ""
  CONFIG["PACKAGE_TARNAME"] = ""
  CONFIG["PACKAGE_NAME"] = ""
  CONFIG["PATH_SEPARATOR"] = ":"
  CONFIG["SHELL"] = "/bin/bash"
  CONFIG["UNICODE_VERSION"] = "12.1.0"
  CONFIG["UNICODE_EMOJI_VERSION"] = "12.0"
  CONFIG["archdir"] = "$(rubyarchdir)"
  CONFIG["topdir"] = File.dirname(__FILE__)
  # Almost same with CONFIG. MAKEFILE_CONFIG has other variable
  # reference like below.
  #
  #   MAKEFILE_CONFIG["bindir"] = "$(exec_prefix)/bin"
  #
  # The values of this constant is used for creating Makefile.
  #
  #   require 'rbconfig'
  #
  #   print <<-END_OF_MAKEFILE
  #   prefix = #{Config::MAKEFILE_CONFIG['prefix']}
  #   exec_prefix = #{Config::MAKEFILE_CONFIG['exec_prefix']}
  #   bindir = #{Config::MAKEFILE_CONFIG['bindir']}
  #   END_OF_MAKEFILE
  #
  #   => prefix = /usr/local
  #      exec_prefix = $(prefix)
  #      bindir = $(exec_prefix)/bin  MAKEFILE_CONFIG = {}
  #
  # RbConfig.expand is used for resolving references like above in rbconfig.
  #
  #   require 'rbconfig'
  #   p Config.expand(Config::MAKEFILE_CONFIG["bindir"])
  #   # => "/usr/local/bin"
  MAKEFILE_CONFIG = {}
  CONFIG.each{|k,v| MAKEFILE_CONFIG[k] = v.dup}

  # call-seq:
  #
  #   RbConfig.expand(val)         -> string
  #   RbConfig.expand(val, config) -> string
  #
  # expands variable with given +val+ value.
  #
  #   RbConfig.expand("$(bindir)") # => /home/foobar/all-ruby/ruby19x/bin
  def RbConfig::expand(val, config = CONFIG)
    newval = val.gsub(/\$\$|\$\(([^()]+)\)|\$\{([^{}]+)\}/) {
      var = $&
      if !(v = $1 || $2)
	'$'
      elsif key = config[v = v[/\A[^:]+(?=(?::(.*?)=(.*))?\z)/]]
	pat, sub = $1, $2
	config[v] = false
	config[v] = RbConfig::expand(key, config)
	key = key.gsub(/#{Regexp.quote(pat)}(?=\s|\z)/n) {sub} if pat
	key
      else
	var
      end
    }
    val.replace(newval) unless newval == val
    val
  end
  CONFIG.each_value do |val|
    RbConfig::expand(val)
  end

  # :nodoc:
  # call-seq:
  #
  #   RbConfig.fire_update!(key, val)               -> string
  #   RbConfig.fire_update!(key, val, mkconf, conf) -> string
  #
  # updates +key+ in +mkconf+ with +val+, and all values depending on
  # the +key+ in +mkconf+.
  #
  #   RbConfig::MAKEFILE_CONFIG.values_at("CC", "LDSHARED") # => ["gcc", "$(CC) -shared"]
  #   RbConfig::CONFIG.values_at("CC", "LDSHARED")          # => ["gcc", "gcc -shared"]
  #   RbConfig.fire_update!("CC", "gcc-8")                  # => ["CC", "LDSHARED"]
  #   RbConfig::MAKEFILE_CONFIG.values_at("CC", "LDSHARED") # => ["gcc-8", "$(CC) -shared"]
  #   RbConfig::CONFIG.values_at("CC", "LDSHARED")          # => ["gcc-8", "gcc-8 -shared"]
  #
  # returns updated keys list, or +nil+ if nothing changed.
  def RbConfig.fire_update!(key, val, mkconf = MAKEFILE_CONFIG, conf = CONFIG)
    return if (old = mkconf[key]) == val
    mkconf[key] = val
    keys = [key]
    deps = []
    begin
      re = Regexp.new("\\$\\((?:%1$s)\\)|\\$\\{(?:%1$s)\\}" % keys.join('|'))
      deps |= keys
      keys.clear
      mkconf.each {|k,v| keys << k if re =~ v}
    end until keys.empty?
    deps.each {|k| conf[k] = mkconf[k].dup}
    deps.each {|k| expand(conf[k])}
    deps
  end

  # call-seq:
  #
  #   RbConfig.ruby -> path
  #
  # returns the absolute pathname of the ruby command.
  def RbConfig.ruby
    File.join(
      RbConfig::CONFIG["bindir"],
      RbConfig::CONFIG["ruby_install_name"] + RbConfig::CONFIG["EXEEXT"]
    )
  end
end
CROSS_COMPILING = nil unless defined? CROSS_COMPILING
