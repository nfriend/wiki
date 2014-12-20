var isLocal = document.location.hostname === 'localhost' || document.location.hostname === '127.0.0.1';
var pageName = isLocal ? getURLParameter('page') : decodeURI(location.pathname.substring(1, location.pathname.length))

var vue = new Vue({
    el: '#app',
    data: {
        pageContent: 'Here\'s a new page for you',
        isEditing: false,
        title: pageName
    },
    filters: {
        marked: marked,
        maxLength: function (text, maxLength) {
            if (!maxLength)
                maxLength = 20;

            if (text.length > maxLength) {
                return text.substring(0, maxLength - 3) + '...'
            } else {
                return text;
            }
        }
    },
    methods: {
        loadContent: function () {
            console.log('hre!');
            setTimeout(function () { this.pageContent = 'sdfsdsdfsdf'; }, 400);
            
        },

        onBodyKeydown: function(e) {

            // ctrl + e or ctrl + shift + e to edit
            if ((e.ctrlKey || (e.ctrlKey && e.shiftKey)) && e.keyCode === 69) {
                e.preventDefault();
                this.edit();
                return false;
            }

            // ctrl + s or ctrl + shift + s to save
            if ((e.ctrlKey || (e.ctrlKey && e.shiftKey)) && e.keyCode === 83) {
                e.preventDefault();
                this.save();
                return false;
            }

            if ((e.ctrlKey || (e.ctrlKey && e.shiftKey)) && e.keyCode === 83) {
                e.preventDefault();
                this.new();
                return false;
            }
        },

        save: function () {
            this.isEditing = false;
        },
        edit: function () {
            console.log('sdfsdf');
            this.isEditing = true;
        },
        cancel: function() {
            this.isEditing = false;
        },
        delete: function () {
            
        },
        new: function () {

        }
    }
});

$.ajax({
    type: "POST",
    url: 'server/get-page.php',
    data: {
        pageName: pageName
    },
    success: function (response) {
        vue.pageContent = response;
    },
    dataType: 'text'
});

// from http://stackoverflow.com/a/11582513/1063392
function getURLParameter(name) {
    console.log(location.search);
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null
}