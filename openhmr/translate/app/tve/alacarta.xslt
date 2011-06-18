<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//div[@class='ContentTabla']/ul/li[@class='odd']|//div[@class='ContentTabla']/ul/li[@class='even']"/>
</xsl:template>

<xsl:template match="li">
  <xsl:variable name="img" select="a[1]/img" />
  <xsl:variable name="title" select="span[@class='col_tit']/a" />
  <xsl:variable name="link" select="normalize-space(span[@class='col_tit']/a/@href)" />

  <xsl:if test="contains($link,'/alacarta/')">
		<item>
			<title><xsl:value-of select="$title" /></title>
  <xsl:choose>
    <xsl:when test="contains($link, 'http://')">
			<link><script>translate_base_url+"app/tve/video,,<xsl:value-of select="$link" />";</script></link>
    </xsl:when>
    <xsl:otherwise>
			<link><script>translate_base_url+"app/tve/video,,http://www.rtve.es<xsl:value-of select="$link" />";</script></link>
    </xsl:otherwise>
  </xsl:choose>
			<media:thumbnail width="169" height="109">
					<xsl:attribute name="url">http://www.rtve.es<xsl:value-of select="normalize-space($img/@src)" /></xsl:attribute>
			</media:thumbnail>
		</item>
  </xsl:if>

</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
