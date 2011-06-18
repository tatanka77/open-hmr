#!/usr/bin/awk -f
#
#   http://code.google.com/media-translate/
#   Copyright (C) 2010  Serge A. Timchenko
#
#   This program is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with this program. If not, see <http://www.gnu.org/licenses/>.
#

# @include getxml.awk

BEGIN {
  UNESCAPEXML = 0;
	print "<channel>"
  print "<title>Shoutcast Radio Genre List</title>"
  while ( getXML(ARGV[1],1) ) 
  {
    if(XTYPE == "TAG")
    {
      if(XITEM == "genre")
      {
        print "<item>"
        for (attrName in XATTR)
          print "<" attrName ">" XATTR[attrName] "</" attrName ">"
        genre = XATTR["name"];
        gsub(" ", "%20", genre)
        print "<link>" translate_base_url "app," genre ",shoutcast/genre</link>"
        print "</item>"
      }
    }
  }
	print "</channel>"
}
