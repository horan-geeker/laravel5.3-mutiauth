(function () {

	// define app factory
	packager('app');

	app = {

		// init app
		init: function () {

			// config app
			this.config.init();
			this.components.table.init();
			this.components.form.init();
			this.components.sidebar.init();
		},

		// app config
		config: {},

		// app components
		components: {},

		// app modules
		modules: {},

		// app global functions
		utils: {}
	};
})();