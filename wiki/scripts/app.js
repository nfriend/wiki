new Vue({
    el: '#app',
    data: {
        input: '# New page',
        editor: getURLParameter('editor') === 'true'
    },
    filters: {
        marked: marked
    },
    methods: {
        onBodyKeydown: function(e) {

            // ctrl + shift + e to edit
            if (e.ctrlKey + e.shiftKey && e.keyCode === 69) {
                e.preventDefault();
                this.editor = true;
                return false;
            }

            // ctrl + s or ctrl + shift + s to save
            if ((e.ctrlKey || (e.ctrlKey && e.shiftKey)) && e.keyCode === 83) {
                e.preventDefault();
                this.editor = false;
                return false;
            }
        }
    }
});

// from http://stackoverflow.com/a/11582513/1063392
function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null
}