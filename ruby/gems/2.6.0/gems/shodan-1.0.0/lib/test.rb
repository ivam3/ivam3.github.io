#!/usr/bin/env ruby
#
# shodan_ips.py
# Search SHODAN and print a list of IPs matching the query
#
# Author: achillean
$:.unshift File.dirname(__FILE__)

require 'rubygems'
require 'shodan'

# Configuration
API_KEY = "eMLZhC7qt42If0U8ndfZTlCWSSxFYass"

# Input validation
if ARGV.length == 0
        puts "Usage: ./shodan_ips.rb <search query>"
        exit 1
end

begin
        # Setup the API
        api = Shodan::Shodan.new(API_KEY)

        # Perform the search
        query = ARGV.join(" ")

        puts "\n--- shodan.info ---"
        result = api.info()
        puts result

        puts '--- shodan.search ---'
        result = api.search(query, :page => 2, :facets => 'port')

        # Loop through the matches and print the IPs
        puts "Total: #{result['total']}"
        result['matches'][0..10].each{ |host|
                puts host['ip_str']
        }

        puts "\nTop 10 Ports"
        result['facets']['port'].each{ |facet|
                puts "#{facet['value']}: #{facet['count']}"
        }

        puts "\n--- shodan.count ---"
        result = api.count(query, :facets => 'port')

        # Loop through the matches and print the IPs
        puts "Total: #{result['total']}"
        result['matches'][0..10].each{ |host|
                puts host['ip_str']
        }

        puts "\nTop 10 Ports"
        result['facets']['port'].each{ |facet|
                puts "#{facet['value']}: #{facet['count']}"
        }

        puts "\n--- shodan.host ---"
        result = api.host('217.140.75.46')
        puts result
rescue Exception => e
        puts "Error: #{e.to_s}"
        exit 1
end
