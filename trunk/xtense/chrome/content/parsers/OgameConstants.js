/**
 * @author OGSteam
 * @license GNU/GPL
 */

Xogame.Xpaths = {
		galaxy_galaxy : "//input[@name='galaxy']/@value",
		galaxy_system : "//input[@name='system']/@value",
		galaxy_ally_onmouseover : "//table[@width='569']/tbody/tr/th[6]/a/@onmouseover",
		galaxy_player_name : "//table[@width='569']/tbody/tr[#pos#]/th[5]/a[1]/span/text()",
		galaxy_ally_name : "//table[@width='569']/tbody/tr/th[6]/a[1]/text()"
}

Xogame.XpathsRedisign = {
		galaxy_galaxy : "//input[@name='galaxy']/@value",
		galaxy_system : "//input[@name='system']/@value",
		galaxy_ally_onmouseover : "//tr[@class='row']/th[6]/a/@onmouseover",
		galaxy_player_name : "//tr[#pos#]/td[contains(@class,'playername')]/a[1]/span/text()",
		galaxy_ally_name : "//tr[#pos#]/td[contains(@class,'allytag')]/span/text()"
}