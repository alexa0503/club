define('public/appAjax', function(require, exports, module) {
    var appAjax = function() {
        var _self = this;
        this.name = 'Model Ajax';
        var request = this.request = null;
        var options = {
            type: 'POST',
            dataType: 'json'
        };

        this.setRequest = function(states) {
            request = states?true:false;
        }
        this.send = function(opts) {
            if(!opts.ignorRequest){
                if(request) {
                    console.log('is requesting aborted');
                  return;
                }
            }

            request = true;
            var ajaxOpts = $.extend(options,opts);

            if(!ajaxOpts.url){
                console.log('url为必需参数!');
                return;
            }

            $.ajax(ajaxOpts)
            .always(function() {
                request = false;
            });
        };
    };
    module.exports = new appAjax();
});
