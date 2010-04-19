/**
 * @author Unibozu
 * @license GNU/GPL
 */

var Xservers = {
	/**
	 * Liste des serveurs OGSpy pour la page courante de Ogame
	 */
	list: [],
	
	/**
	 * Verification si la page de ogame correspond a un serveur
	 * @return {boolean}
	 */
	check : function (univers) {
		this.list = [];
		this.each(function (server) {
			if (server.active && server.univers == univers) this.list.push(server);
		}, this);
		return this.list.length != 0;
	},
	
	/**
	 * Parcours les serveurs disponibles avec une fonction
	 * @param {Function} callback
	 * @param {Object} scope
	 */
	each : function (callback, scope) {
		var server = null;
		for (var i = 0, server = null; i < 5 && !(server = new ServerItem(i)).empty(); i++) {
			callback.apply(scope, [server]);
		}
	}
}

