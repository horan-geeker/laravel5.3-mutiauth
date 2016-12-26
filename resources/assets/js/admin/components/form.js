(function () {

	packager('app.components.form');

	app.components.form = {
		init: function () {
			this.initFileField();
			this.initImgPreview();
			this.initLocaleSwitcher();
			this.validate();
			this.initRichTextEditor();
			this.initPublishedAtField();
			this.initDatetimepicker();
			this.initGenericAjax();
			this.initOldFileUpdateSequence();
			this.initSelectField();
			this.initPostStatus();
		},
		initFileField: initFileField,
		initImgPreview: initImgPreview,
		validate: validate,
		initRichTextEditor: initRichTextEditor,
		initPublishedAtField: initPublishedAtField,
		initDatetimepicker: initDatetimepicker,
		initGenericAjax: initGenericAjax,
		initOldFileUpdateSequence: initOldFileUpdateSequence,
		initLocaleSwitcher: initLocaleSwitcher,
		initSelectField: initSelectField,
		initPostStatus: initPostStatus
	};

	function initFileField() {
		// disabled state
		$('.form-group').on('click', '.file[disabled]', function (e) {
			e.preventDefault();
		});

		// change event
		$('input[type="file"]:not(".initialized")').on('change', function () {

			$(this).addClass('initialized');

			var filename = '未选择文件';
			var labelId = 'field_' + $(this).attr('name');
			$(this).closest('label').attr('id', 'field_' + $(this).attr('name'));

			if ($(this).get(0).files[0]) {
				filename = $(this).get(0).files[0].name;
				$(this).closest('.form-group').removeClass('has-error');
				$(this).closest('.form-group').find('.help-block').addClass('hidden');
				$(this).closest('.form-group').find('.file-field-style').remove();
			}
			$(this).closest('.form-group').append('<style class="file-field-style">#' + labelId + '.file>span.filename:after{content: "' + filename + '"}</style>');
		});
	}

	function initImgPreview() {

		$('.has-img-preview input[type="file"]:not(".preview-initialized")').on('change', function () {

			// initialized
			$(this).addClass('preview-initialized');

			var $preview = $(this).closest('.form-group').find('img.preview');
			var preview = $preview.get(0);
			var file = $(this).closest('.form-group').find('input[type="file"]').get(0).files[0];
			var reader = new FileReader();

			reader.addEventListener("load", function () {
				preview.src = reader.result;
			}, false);

			if (file) {
				reader.readAsDataURL(file);
			} else {
				$preview.attr('src', $preview.data('placeholder-src'));
			}

			// show the image, since we faded it out when removing the old file on edit view
			// todo: use placeholder image instead of letting it fade out
			$preview.show();
		});
	}

	// 初始化表单验证
	function validate() {

		var options = {
			ignore: ".ignore",
			highlight: function (el) {
				$(el).closest('.form-group').addClass('has-error');
				// remove the error message from the server
				$(el).closest('.form-group').find('.help-block').addClass('hidden');
			},
			unhighlight: function (el) {
				$(el).closest('.form-group').removeClass('has-error');
				// remove the error message from the server
				$(el).closest('.form-group').find('.help-block').addClass('hidden');
			},
			errorPlacement: function (error, element) {
				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				} else {
					error.appendTo(element.closest('.form-group'));
				}
			},
			submitHandler: function (form) {

				// disable the submit buttons
				$(form).find('.btn-submit, .btn-save').prop('disabled', true);

				// decide which button to display the state on
				var $clicked = $('.form-submitter.clicked');
				if ($clicked.length) {
					$clicked.html('<i class="fa fa-spinner fa-spin"></i>正在提交...');
					return true;
				}

				// old code, may be removed later
				$(form).find('.btn-submit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>正在提交...');

				return true;
			}
		};

		$('form:not(".should-manually-validate")').each(function () {
			$(this).validate(options);

			$(this).find('.btn-submit, .btn-save').addClass('form-submitter').on('click', function () {
				$('.form-submitter').removeClass('clicked');
				$(this).addClass('clicked');
			});
		});
	}

	function initRichTextEditor() {

		// 富文本编辑器都要有独立 id, 也要有 data-rich-text-editor 属性
		$('[data-rich-text-editor]').each(function () {
			var id = $(this).attr('id');
			var editor = UE.getEditor(id);
			editor.ready(function () {
				$(editor.container).closest('.fouc-editor').removeClass('fouc-editor');
			});
		});
	}

	function initPublishedAtField() {
		$('#show_publishing_datetimepicker').change(function () {
			if ($(this).is(':checked')) {
				$($(this).data('target')).removeClass('hidden');
				$(this).closest('.form-group').find('.btn-save').prop('disabled', true);
			} else {
				$($(this).data('target')).addClass('hidden');
				$(this).closest('.form-group').find('.btn-save').prop('disabled', false);
			}
		});
	}

	function initPostStatus() {
		if ($('.btn-publish, .btn-save').length == 2) {
			$('.btn-publish').on('mousedown', function() {
				$(this).closest('form').find('[name="status"]').val('published');
				var $publishAt = $(this).closest('form').find('[name="published_at"]');
				if (!$publishAt.val()) {
					var now = moment().utc('8').format('YYYY-MM-DD HH:mm:ss');
					$publishAt.val(now);
				}
			});
			$('.btn-save').on('mousedown', function(e) {
				if (e.which == 1) {
					$(this).closest('form').find('[name="status"]').val('draft');
					$(this).closest('form').find('[name="published_at"]').val('');
				}
			});
		}
	}

	// init datetime picker
	function initDatetimepicker() {
		$('[data-datetimepicker]').each(function () {
			var format = $(this).data('format') ? $(this).data('format') : 'YYYY-MM-DD HH:mm:ss';

			$(this).datetimepicker({
				format: format,
				defaultDate: $(this).find('input[name="published_at"]').val(),
				// disable minDate, we are going to fill old data
				//minDate: moment().utc('8').format('YYYY-MM-DD HH:mm:ss')
			});

			$(this).on('click', function () {
				$(this).data("DateTimePicker").show();
			});
		});
	}

	// generic ajax call, set directives inline in html
	function initGenericAjax() {
		$('[data-ajax]').on('click', function () {

			var url = $(this).data('url');
			var method = $(this).data('method');
			var postAction = $(this).data('post-action');

			console.log(url, method, postAction);

			var that = this;

			$.ajax({
					url: url,
					type: method
				})
				.done(function () {
					console.log("success");

					if (postAction == 'delete-row') {
						$(that).closest('tr').remove();
					}
				})
				.fail(function () {
					console.log("error");
				})
				.always(function () {
					console.log("complete");
				});

		});
	}

	function initOldFileUpdateSequence() {

		$('[data-old-file-container]').each(function () {
			var $input = $(this).closest('.form-group').find('input[type="file"]');
			if (!$input.is(':visible')) {
				$input.prop('disabled', true);
			}
		});

		// preload placeholder images
		$('[data-placeholder-src]').each(function () {
			var url = $(this).data('placeholder-src');
			var img = new Image;
			img.src = url;
		});

		$('[data-old-file-container]').on('click', '.btn-delete-file', function () {

			var $that = $(this);
			// if there is an preview image
			// fade out the image and empty its src property
			var $formGroup = $that.closest('.form-group');
			if ($formGroup.hasClass('has-img-preview')) {
				var placeholderSrc = $formGroup.find('img.preview').data('placeholder-src');

				if (placeholderSrc) {
					$formGroup.find('img.preview').attr('src', placeholderSrc);
				} else {
					$formGroup.find('img.preview').fadeOut(200, function () {
						$that.attr('src', '');
					});
				}
			}

			// show the input field
			// and remove the old file container
			$formGroup.find('[data-input-container]').removeClass('hidden');
			$that.closest('[data-old-file-container]').addClass('hidden').find('input').prop('disabled', true);
			$formGroup.find('input[type="file"]').prop('disabled', false);
		});
	}

	// hide other-locale-file form-group
	// and disable the file field
	// if content locale is not Chinese
	function initLocaleSwitcher() {

		function resetFileFields($that) {
			var locale = $that.val();
			if (locale == 'zh') {
				$('.has-other-locale-file').addClass('hidden').find('input[type="file"]').prop('disabled', true);
			} else {
				$('.has-other-locale-file').removeClass('hidden').find('input[type="file"]').prop('disabled', false);
			}

			app.components.form.validate();
		}

		// init
		resetFileFields($('[data-switch-locale]'));

		// bind event
		$('[data-switch-locale]').change(function () {
			resetFileFields($(this));
		});

		// 根据语言切换表单上的字段语言
		function resetMultiLocaleFieldContainers() {
			$('.multi-locale-field-container').each(function() {
				var locale = $(this).closest('form').find('[name="locale"]').val();

				// 取一个语言的模板, 填入容器
				html = $('.' + $(this).data('target-class') + '[data-template-locale="'+ locale + '"]').html();
				$(this).html(html);
			});

			// file field
			app.components.form.initFileField();

			// img preview
			app.components.form.initImgPreview();

			// sortable list
			app.config.initSortableLists();
		}

		resetMultiLocaleFieldContainers();

		// 用户切换语言时, 切换相关专业中英文
		$('[name="locale"]').on('change', resetMultiLocaleFieldContainers);
	}

	// replace native select with select2
	function initSelectField() {
		$('.page-content select').each(function () {
			// insert the caret if it does not exist
			var $caret = $('<i class="fa fa-chevron-down"></i>');
			if ($(this).next() != $caret) {
				$(this).after($caret);
			}
			$(this).closest('.form-group').addClass('has-select-tag');
			$(this).select2({
				minimumResultsForSearch: Infinity,
				width: '100%'
			});
		});
	}
})();