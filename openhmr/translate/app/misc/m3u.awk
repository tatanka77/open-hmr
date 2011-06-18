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

  while ( getXML(ARGV[1],1) ) 
  {
    if(XTYPE == "TAG")
    {
      if(XITEM == "playlist")
      {
        print "#EXTM3U";
      }
      else
      if(XITEM == "track")
      {
        stream_url = "";
        location = "";
        title = "";
      }
      else
      {
        if(XITEM == "meta")
        {
          tagname = XATTR["rel"];
        }
        else
        {
          tagname = XITEM;
        }
        
        if(XPATH ~ /^\/playlist\/trackList\/track\//)
        {
          value = "";
          getXML(ARGV[1],0); 
          if(XTYPE == "DAT")
          {
            value = XITEM;
            getXML(ARGV[1],1); 
          }
          if(tagname == "location")
          {
            location = value;
          }
          else
          if(tagname == "stream_url")
          {
            stream_url = value;
          }
          else
          if(tagname == "title")
          {
            title = value;
          }
        }
      }
    }
    else
    if(XTYPE == "END")
    {
      if(XITEM == "track")
      {
        if(stream_url == "")
          stream_url = location;

        if(stream_url != "")
        {
          print "#EXTINF:-1," title
          print stream_url
        }
      }
    }
  }
}

