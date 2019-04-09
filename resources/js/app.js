
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

window.Event = new Vue;

var App = new Vue({
    el: '#app',

    methods: {
        goToHref: function(event) {
            var element = event.target.closest('.clickable');
            var href = element.dataset.href;
            window.location = href;
        },
    	deleteUrl: function(event) {
    		if (! confirm('All the collected data will be erased from our systems. Delete the URL? ')) {
    			return false;
    		}
            var sites = event.target.dataset.sites;

    		axios.delete(event.target.href).then(function(data) {
                window.location = sites;
    		}).catch(function(error) {
                alert('There was an error. The site was not deleted.');  
            });
    		
    	}
    },

    mounted() {
        let input = document.querySelector('[autofocus]');
        if (input) {
            input.focus()
        }
    }
});