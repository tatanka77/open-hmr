<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//li[@class='more l3 ']/ul/li|//li[@class='more']/ul/li|//li[@class='more l4 ']/ul/li"/>
</xsl:template>

<xsl:template match="li">
  <xsl:variable name="title" select="a" />
  <xsl:variable name="link" select="normalize-space(a/@href)" />
		<item>
			<title><xsl:value-of select="$title" /></title>
  <xsl:choose>
    <xsl:when test="contains($link, 'http://')">
			<link><script>translate_base_url+"app/tve/temp1,,<xsl:value-of select="$link" />";</script></link>
    </xsl:when>
    <xsl:otherwise>
			<link><script>translate_base_url+"app/tve/temp1,,http://www.rtve.es<xsl:value-of select="$link" />";</script></link>
    </xsl:otherwise>
  </xsl:choose>
		</item>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
