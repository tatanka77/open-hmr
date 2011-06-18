<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//div[@class='capaseccionl item']/div[@class='player_programas']"/>
</xsl:template>

<xsl:template match="div">
  <xsl:variable name="img" select="a[1]/img" />
  <xsl:variable name="title" select="../h5[@class='titulo']/a" />
  <xsl:variable name="link" select="concat('app/lasexta/video,,', a[1]/@href)" />
		<item>
			<title><xsl:value-of select="$title" /></title>
			<link><script>translate_base_url+"<xsl:value-of select="$link" />";</script></link>
			<media:thumbnail width="169" height="109">
					<xsl:attribute name="url"><xsl:value-of select="$img/@src" /></xsl:attribute>
			</media:thumbnail>
		</item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
