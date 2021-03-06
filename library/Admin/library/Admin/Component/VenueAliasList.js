/**
 * @class Admin_Component_VenueAliasList
 * @extends Admin_Component_Abstract
 */
var Admin_Component_VenueAliasList = Admin_Component_Abstract.extend({

	/** @type String */
	_class: 'Admin_Component_VenueAliasList',

	events: {
		'clickConfirmed .deleteAlias': function(event) {
			var id = $(event.currentTarget).closest('li.venueAlias').data('id');
			this.deleteAlias(id);
			return false;
		}
	},

	deleteAlias: function(id){
		this.ajax('deleteAlias', {id: id});
	}
});
