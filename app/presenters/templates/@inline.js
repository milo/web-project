document.addEventListener('DOMContentLoaded', function () {
	(function (w, timeout) {
		setTimeout(function () {
			var url = w.location.toString();
			if (w.location && w.history && w.history.replaceState && url.indexOf('_fid=') !== -1) {
				w.history.replaceState({}, null, /[?&]_fid=[^&]+$/.test(url)
					? url.replace(/[?&]_fid=[^&]+/, '')
					: url.replace(/([?&])_fid=[^&]+&/, '$1')
				);
			}
		}, timeout || 2000);
	})(window);
});
