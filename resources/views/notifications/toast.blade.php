{{--
This makes a great "partial" to add to your template layout file. It will self manage your
notifications so you do not need to worry about displaying them. Simply just add notifications
using LaraFlash (Laravel Package) in your controllers, and they will display intelligently
and elegantly into your views.

Simply use an @include statement in your main template/layout file to this partial so that 
this partial is included with every view. The rest can be set once and forgotten.

Requirements:
1. Lodash
2. Vue.js
3. Buefy
4. LaraFlash
5. Laravel/Blade (obviously)

See comments on this GitHub Gist page for more details and links or explanation. https://gist.github.com/jacurtis/9fa687e8f7512bb197decce7ffc30091
--}}
<div id="toast-notifications" style="display:none;"></div>
<script>
	var notifications = new Vue({
		el: '#toast-notifications',
		data: {
			session: {!!json_encode(LaraFlash::allByType())!!},
			validMethods: ['general', 'primary', 'success', 'info', 'warning', 'danger', 'snackbar']
		},
		mounted: function() {
			let vm = this;
			this.$nextTick(function() {
				vm.session.forEach(function(e) {
					if (_.includes(vm.validMethods, e.type.toLowerCase())) {
						vm[e.type.toLowerCase()](e.content);
					} else {
						vm.general(e.content);
					}
				});
			})
		},
		methods: {
			general: function(msg, pos = 'is-top', dur = 5000, color = 'is-dark') {
				this.$toast.open({
							duration: dur,
							message: msg,
							position: pos,
							type: color
					});
			},
			primary: function(msg, pos = 'is-top', dur = 5000) {
				this.$toast.open({
							duration: dur,
							message: msg,
							position: pos,
							type: 'is-primary'
					});
			},
			success: function(msg, pos = 'is-top', dur = 5000) {
				this.$toast.open({
                        duration: dur,
                        message: msg,
                        position: pos,
                        type: 'is-success'
					});
			},
			info: function(msg, pos = 'is-top', dur = 5000) {
				this.$toast.open({
							duration: dur,
							message: msg,
							position: pos,
							type: 'is-info'
					});
			},
			warning: function(msg, pos = 'is-top', dur = 5000) {
				this.$toast.open({
							duration: dur,
							message: msg,
							position: pos,
							type: 'is-warning'
					});
			},
			danger: function(msg, pos = 'is-top', dur = 5000) {
				this.$toast.open({
							duration: dur,
							message: msg,
							position: pos,
							type: 'is-danger'
					});
			},
			snackbar: function(msg, optionsPassed = {}, callback) {
				const defaults = {
					position: 'is-bottom-right',
					duration: 5000,
					type: 'is-success',
					actionText: 'Ok'
				};
				const options = Object.assign({}, defaults, optionsPassed);

				this.$snackbar.open({
							duration: options.duration,
							message: msg,
							type: options.type,
							position: options.position,
							actionText: options.actionText,
							onAction: () => {
								if (typeof callback === 'function') callback();
							}
					})
			},
			toast: function(msg, optionsPassed = {}) {
				const defaults = {
					position: 'is-top',
					duration: 5000,
					type: 'is-dark'
				};
				const options = Object.assign({}, defaults, optionsPassed);

				this.$toast.open({
							duration: options.duration,
							message: msg,
							position: options.position,
							type: options.type
					});
			}
		}
	});
</script>