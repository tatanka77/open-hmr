<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//span[@class='imgT']|//span[@class='imgL']"/>
</xsl:template>

<xsl:template match="span">
  <xsl:variable name="img" select="a/img" />
  <xsl:variable name="title" select="$img/@alt" />
  <xsl:variable name="link" select="normalize-space(a/@href)" />
  <xsl:if test="contains($link,'/mediateca/videos/')">
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
