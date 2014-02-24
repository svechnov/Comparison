Comparison = {
	add: {
		options: {
			add: '.comparison-add',
			remove: '.comparison-remove',
			go: '.comparison-go',
			total: '.comparison-total',
			added: 'added',
			can_compare: 'can_compare',
			loading: 'loading'
		},
		initialize: function(selector, params) {
			if (!$(selector).length) {return;}

			var options = this.options;
			var minItems = !params.min ? 2 : params.min;
			$(document).on('click', selector + ' ' + options.add + ',' + selector + ' ' + options.remove, function() {
				var $this = $(this);
				var $parent = $this.parents(selector);
				var text = $this.data('text');
				var list = $parent.data('list');
				var id = $parent.data('id');
				var action = $this.hasClass(options.add.substr(1))
					? 'add'
					: 'remove';
				
				if ($this.hasClass(options.loading)) {return false;}
				else {$this.addClass(options.loading);}
				if (text.length) {
					$this.attr('data-text', $this.text()).text(text);
				}
				$.post(document.location.href, {cmp_action: action, list: list, resource: id}, function(response) {
					if (text.length) {
						text = $this.attr('data-text');
						$this.attr('data-text', $this.text()).text(text);
					}
					$this.removeClass(options.loading);
					if (response.success) {
						$(options.total, selector).text(response.data.total);

						if (response.data.link) {
							$(options.go, selector).attr('href', response.data.link);
						}
						if (response.data.total >= minItems) {
							$(selector).addClass(options.can_compare);
						}
						else {$(selector).removeClass(options.can_compare);}

						if (action == 'add') {$parent.addClass(options.added);}
						else {$parent.removeClass(options.added);}
					}
					else {
						if (typeof miniShop2 != 'undefined') {miniShop2.Message.error(response.message);}
						else {alert(response.message);}
					}
				}, 'json');
				return false;
			});
		}
	},

	list: {
		options: {
			all: '.comparison-params-all',
			unique: '.comparison-params-unique',
			remove: '.comparison-remove',
			same_class: 'same',
			active_class: 'active'
		},
		initialize: function(selector, params) {
			if (!$(selector).length) {return;}

			var options = this.options;
			var minItems = !params.min ? 2 : params.min;

			// Switch parameters
			$(document).on('click', selector + ' ' + options.all + ',' + selector + ' ' + options.unique, function() {
				var $this = $(this);
				var $parent = $this.parents(selector);

				if ($this.hasClass(options.active_class)) {
					return false;
				}
				else if ($this.hasClass(options.all.substr(1))) {
					$(options.unique, $parent).removeClass(options.active_class);
					$this.addClass(options.active_class);
					$('.'+options.same_class, $parent).show();
				}
				else if ($this.hasClass(options.unique.substr(1))) {
					$(options.all, $parent).removeClass(options.active_class);
					$this.addClass(options.active_class);
					$('.'+options.same_class, $parent).hide();
				}
				return false;
			});

			// Remove from list
			$(document).on('click', selector + ' ' + options.remove, function(e) {
				var $this = $(this);
				var $parent = $this.parents(selector);
				var text = $this.data('text');
				var list = $this.parent().data('list');
				var id = $this.parent().data('id');
				var index = $(options.remove, selector).index(this) + 1;

				if (text.length) {
					$this.attr('data-text', $this.text()).text(text);
				}
				$.post(document.location.href, {cmp_action: 'remove', list: list, resource: id}, function(response) {
					if (text.length) {
						text = $this.attr('data-text');
						$this.attr('data-text', $this.text()).text(text);
					}
					$this.removeClass(options.loading);
					if (response.success) {
						if (response.data.total < minItems) {
							document.location.reload();
						}

						$parent.find('tr').each(function() {
							$(this).find('th:eq('+index+'), td:eq('+index+')').remove();
						});
					}
					else {
						if (typeof miniShop2 != 'undefined') {miniShop2.Message.error(response.message);}
						else {alert(response.message);}
					}
				}, 'json');

				return false;
			});
		}
	}
};