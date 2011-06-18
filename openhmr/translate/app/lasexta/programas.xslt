<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//div[@id='list_programas']/div[@class='capaseccionl item_vip']/div[@class='player']"/>
</xsl:template>

<xsl:template match="div">
  <xsl:variable name="img" select="a/img[1]" />
  <xsl:variable name="title" select="a/label[@class='item_vip_player_label']" />
  <xsl:variable name="link" select="concat('app/lasexta/programas2,programas,', a/@href)" />
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
