<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//div[@class='temasprincipales']/ul/li[@class='dot']"/>
</xsl:template>

<xsl:template match="li">
  <xsl:variable name="img" select="a/img" />
  <xsl:variable name="title" select="a/@title" />
  <xsl:variable name="link" select="a/@href" />
		<item>
			<title><xsl:value-of select="$title" /></title>
			<link><script>translate_base_url+"app/tele5/temp,,<xsl:value-of select="$link" />";</script></link>
			<media:thumbnail width="169" height="109">
					<xsl:attribute name="url">http://www.telecinco.es<xsl:value-of select="$img/@src" /></xsl:attribute>
			</media:thumbnail>
		</item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
