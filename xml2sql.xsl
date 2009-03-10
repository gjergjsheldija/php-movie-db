<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" version="1.0" indent="yes" omit-xml-declaration="yes"/>
	<xsl:template match="movieinfo">
  		<xsl:for-each select="movielist/movie">INSERT INTO catalog ( id, movie, cover, release_date, plot, runtime, genre, cast, director, studio, thumbnail ) VALUES (
  			"<xsl:value-of select="id"/>",
  			"<xsl:value-of select='translate(title,"&apos;", "")'/>",
  			"<xsl:value-of select='translate(coverfront, "&apos;","")'/>",
  			"<xsl:value-of select='releasedate/date'/>",
			"<xsl:value-of select="translate(translate(plot,&quot;&#xA;'&quot;,''),'&#34;' ,'' )"/>",
  			"<xsl:value-of select="runtime"/>",
  			CONCAT_WS(" ",<xsl:for-each select="genres/genre">		
  				"<xsl:value-of select="displayname"/>",
  			</xsl:for-each>""),CONCAT_WS(" ",<xsl:for-each select="cast">
  				<xsl:for-each select='star/person'>
  					"<xsl:value-of select='translate(displayname,"&apos;", "")'></xsl:value-of>",
  				</xsl:for-each>
  			</xsl:for-each>""),CONCAT_WS(" ",
  			<xsl:for-each select="crew/crewmember[roleid='dfDirector']/person">
  				"<xsl:value-of select='translate(displayname,"&apos;", "")'></xsl:value-of>",
  			</xsl:for-each>""),
  			"<xsl:value-of select='translate(studios/studio/displayname,"&apos;", "")'></xsl:value-of>",
  			"<xsl:value-of select="thumbfilepath"/>");
  		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>