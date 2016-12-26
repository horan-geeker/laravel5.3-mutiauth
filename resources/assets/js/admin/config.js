(function () {

	packager('app.config');

	app.config = {

		// init app
		init: function () {
			// this.initLodashConfig();
			this.initSprintf();
			// this.enhanceJqueryValidation();
			// this.customizeJqueryValidationTranslation();
			this.initBootstrap();
			this.initSweetAlert();
			this.initFoucPatch();
			this.initSortableLists();
			this.initCheckboxLimit();
			// this.initTopbar();
			this.initPjax();
			this.stopClickPropagation();
		},

		initLodashConfig: initLodashConfig,
		initSprintf: initSprintf,
		enhanceJqueryValidation: enhanceJqueryValidation,
		customizeJqueryValidationTranslation: customizeJqueryValidationTranslation,
		initBootstrap: initBootstrap,
		initSweetAlert: initSweetAlert,
		initFoucPatch: initFoucPatch,
		initSortableLists: initSortableLists,
		initCheckboxLimit: initCheckboxLimit,
		initTopbar: initTopbar,
		initPjax: initPjax,
		stopClickPropagation: stopClickPropagation
	};


	// config lodash template engine
	// 配置 lodash template 模版引擎, 考虑放到 layout 里
	function initLodashConfig() {
		_.templateSettings.evaluate = /\[\[(.+?)\]\]/g;
		_.templateSettings.interpolate = /\[\[=(.+?)\]\]/g;
		_.templateSettings.escape = /\[\[-(.+?)\]\]/g;
	}


	// --------------------------------------------------------------
	// 前端表单验证错误信息翻译宏文件配置
	// 用法: $.sprintf('required', 'email');
	// 返回: "邮箱不能为空"
	// 只翻译的话用法如: $.trans('http.404');
	// 返回: 未找到
	function initSprintf() {

		// 查看所有翻译
		$.phrases = function () {
			return Phrases;
		};

		// 翻译, 第一个参数为宏标记, 之后所有都为向宏值里插入的变量
		$.sprintf = function () {

			var str = Array.prototype.slice.call(arguments, 0, 1)[0];
			var args = Array.prototype.slice.call(arguments, 1);

			// 尝试翻译参数
			args = $.map(args, function (arg) {
				try {
					if (arg in Phrases.attributes) {
						return Phrases.attributes[arg];
					} else {
						return arg;
					}
				} catch (e) {
					return arg;
				}
			});

			var translation = index(Phrases, str);

			// 把翻译插到开头
			args.unshift(translation);

			try {
				return sprintf.apply(null, args);
			} catch (e) {
				console.log('翻译出错, 检查代码');
				console.log(e);
				console.log(Phrases);
			}
		};

		$.trans = $.sprintf;

		// 以点引用(字符串)的方式从对像里取出对应值
		function index(obj, is, value) {
			if (typeof is == 'string')
				return index(obj, is.split('.'), value);
			else if (is.length == 1 && value !== undefined)
				return obj[is[0]] = value;
			else if (is.length == 0)
				return obj;
			else
				return index(obj[is[0]], is.slice(1), value);
		}
	}


	// --------------------------------------------------------------
	// 为 jquery validation 增加文件大小验证功能, 仅支持高级浏览器
	function enhanceJqueryValidation() {
		$.validator.addMethod('filesize', function (value, element, param) {
			// param = size (in bytes)
			// element = element to validate (<input>)
			// value = value of the element (file name)

			// no file
			if (!element.files[0]) {
				return true;
			}
			console.log($(element).attr('name') + ' filesize:', element.files[0].size / 1024);
			return this.optional(element) || (element.files[0].size / 1024 <= param)
		}, $.validator.format("文件大小应小于 {0} KB"));

		$.validator.addMethod('requiredwithout', function (value, element, param) {

			if (!!$(element).val() || !!$(param).val()) {
				$(param).closest('.form-group').removeClass('has-error').find('label.error').addClass('hidden');
			} else {
				$(param).closest('.form-group').addClass('has-error').find('label.error').removeClass('hidden');
			}

			return !!$(element).val() || !!$(param).val();
		});
	}

	// --------------------------------------------------------------
	// super jquery validation translation; sync with backend
	function customizeJqueryValidationTranslation() {

		// 使用一些后端的翻译
		$.validator.messages.required = function (param, input) {
			return $.trans('validation.required', $.trans('validation.attributes.' + input.name));
		};

		$.validator.messages.maxlength = function (param, input) {
			return $.trans('validation.max.string', $.trans('validation.attributes.' + input.name), $(input).data('rule-maxlength'));
		};

		$.validator.messages.minlength = function (param, input) {
			return $.trans('validation.min.string', $.trans('validation.attributes.' + input.name), $(input).data('rule-minlength'));
		};

		// 至少得填一个
		$.validator.messages.requiredwithout = function (param, input) {
			return $.trans('validation.required_without', $.trans('validation.attributes.' + input.name), $.trans('validation.attributes.' + $($(input).data('rule-requiredwithout')).get(0).name));
		};
	}

	// --------------------------------------------------------------
	// bootstrap config
	function initBootstrap() {

		// init bootstrap tooltip
		$('[data-toggle="tooltip"]').tooltip();
	}


	// --------------------------------------------------------------
	// sweet alert translation
	function initSweetAlert() {
		swal.setDefaults({
			confirmButtonText: '确定',
			cancelButtonText: '取消',
			animation: false
		});
	}

	// --------------------------------------------------------------
	// usage: add class 'fouc' to element you want to prevent fouc effect
	function initFoucPatch() {

		setTimeout(function () {
			$('.fouc').removeClass('fouc');

			// display submit/save button when js finishes
			$('.btn-submit, .btn-save').css('opacity', 1);
		}, 0);
	}

	// --------------------------------------------------------------
	// usage: add class 'has-sortable-items' to sortable elements container
	function initSortableLists() {
		$('.has-sortable-items:not(.initialized)').each(function () {
			$(this).addClass('initialized');
			dragula([this]);
		});
	}

	// --------------------------------------------------------------
	// usage: add data-checkbox-limit='5' will limit the checked items to 5
	function initCheckboxLimit() {

		function check($container) {
			var limit = $container.data('checkbox-limit');
			if ($container.find('input[type="checkbox"]:checked').length >= limit) {
				$container.find('input[type="checkbox"]:unchecked').prop('disabled', true).closest('label').addClass('disabled');
			} else {
				$container.find('input[type="checkbox"]').prop('disabled', false).closest('label').removeClass('disabled');
			}
		}

		$('[data-checkbox-limit]').each(function () {
			check($(this));
		}).on('change', 'input[type="checkbox"]', function () {
			check($(this).closest('[data-checkbox-limit]'));
		});

	}

	// --------------------------------------------------------------
	// topbar config
	function initTopbar() {

		// topbar config
		window.topbar.config({
			//autoRun: false,
			barThickness: 2,
			barColors: {
				'0': 'rgba(26,  188, 156, .7)',
				'.3': 'rgba(41,  128, 185, .7)',
				'1.0': 'rgba(231, 76,  60,  .7)'
			},
			shadowBlur: 5,
			shadowColor: 'rgba(0, 0, 0, .5)'
		});


		// global event
		$('[data-topbar]').on('click', function () {

			topbar.show();

			var count = .6;
			step();

			// speed up fake progress
			function step() {
				var intervalId = setInterval(function () {
					if (count <= 0) {
						topbar.hide();
						clearInterval(intervalId);
						return;
					}
					topbar.progress(count);
					count = count + 0.05;
				}, 5)
			}
		});
	}

	// --------------------------------------------------------------
	// pjax config
	function initPjax() {

		$.pjax.defaults.timeout = 1500;
		$.pjax.defaults.maxCacheLength = 0;
		$.pjax.defaults.scrollTo = false;

		// remove all events
		$(document).off('pjax:send');
		$(document).off('pjax:success');
		$(document).off('pjax:complete');
		$(document).off('pjax:timeout');
		$(document).off('click', '[data-pjax]:not(form)');

		// rebind all events
		$(document).on('pjax:send', function () {
			topbar.show();

			var count = .6;
			step();

			// speed up fake progress
			function step() {
				var intervalId = setInterval(function () {
					if (count <= 0) {
						topbar.hide();
						clearInterval(intervalId);
						return;
					}
					topbar.progress(count);
					count = count + 0.05;
				}, 5)
			}
		}).on('pjax:success', function (e, data, status, xhr, options) {

			// call the callback function if there is any
			if (typeof options.onSuccess === 'function') {
				options.onSuccess();
			}

		}).on('pjax:complete', function (e) {
			topbar.hide();

			// re init app
			app.init();
		}).on('pjax:timeout', function (event) {
			event.preventDefault();

			topbar.hide();

			// todo: consider disabling timeout refresh
			// refresh directly
			// location.reload();
		});

		// pjax element click events
		$(document).on('click', '[data-pjax]:not(form)', function (e) {
			e.stopPropagation();
			e.preventDefault();

			var url = '';
			var container = '';

			if ($(this).is('a')) {
				url = $(this).attr('href');
			} else {
				url = $(this).data('url');
			}

			if ($(this).data('container')) {
				container = $(this).data('container');
			}

			if (!url || !container) {
				alert('视图里未为此元素的 pjax 请求配置 data-url, data-container');
				console.log('pjax url: ', url);
				console.log('pjax container:', container);
				return;
			}

			$.pjax({
				url: url,
				container: container,
				timeout: $(this).data('timeout') ? $(this).data('timeout') : $.pjax.defaults.timeout
			});
		});
	}

	// stop propagation for view element default event
	function stopClickPropagation() {
		$('[data-stop-propagation]').on('click', function (e) {
			e.stopPropagation();
		});
	}
})();



