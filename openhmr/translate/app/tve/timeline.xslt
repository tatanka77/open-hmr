<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:media="http://search.yahoo.com/mrss/"
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:template match="/">
    <xsl:apply-templates select="//dia/informacion"/>
</xsl:template>

<xsl:template match="informacion">
  <xsl:variable name="img" select="normalize-space(@imagen)" />
  <xsl:variable name="title" select="@titulo" />
  <xsl:variable name="link" select="normalize-space(@enlace)" />
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
    <xsl:choose>
      <xsl:when test="contains($link, 'http://')">
					<xsl:attribute name="url"><xsl:value-of select="$img" /></xsl:attribute>
      </xsl:when>
      <xsl:otherwise>
					<xsl:attribute name="url">http://www.rtve.es<xsl:value-of select="$img" /></xsl:attribute>
      </xsl:otherwise>
    </xsl:choose>
			</media:thumbnail>
		</item>
  </xsl:if>

</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>
