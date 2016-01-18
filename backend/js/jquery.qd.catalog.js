(function($) {
    // 插件的定义    
    $.fn.catalog = function(options) {
        //debug(this);
        var opts = $.extend({}, $.fn.catalog.defaults, options);
        return this.each(function() {
            $this = $(this);
            var forobj = $this.attr('id');
            var trace = $this.attr('default').split('_');

            var options = '';
            $.each( opts, function(i, n){
                if (typeof(trace[0]) != 'undefined' && i == trace[0]) {
                    options += '<option value="'+i+'" selected="selected">'+n.name+'</option>';
                } else {
                    options += '<option value="'+i+'">'+n.name+'</option>';
                }
            });
            $this.append(options);

            var option = opts;
            if (trace.length > 0) {
                $obj = $this;
                $.each(trace, function(i, n){
                    if (typeof(option[n]) != 'undefined' && typeof(option[n]['option']) != 'undefined') {
                        option = option[n]['option'];
                        $obj = $.fn.catalog.buildChild($obj, option, forobj, trace[i+1]);
                    }
                });
                $('#'+forobj+'_id').val(trace.pop());
            }

            $this.on('change', function(){
                $('#'+forobj+'_id').val('');
                $(this).nextAll("select").remove();
                if (typeof(opts[$(this).children(":selected").val()]) != 'undefined' && typeof(opts[$(this).children(":selected").val()]['option']) != 'undefined') {
                    $.fn.catalog.buildChild($(this), opts[$(this).children(":selected").val()]['option'], forobj, 0);
                } else {
                    $('#'+forobj+'_id').val($(this).children(":selected").val());
                }
            });
        });
    };
    // 私有函数：debugging    
    function debug($obj) {
        if (window.console && window.console.log)    
            window.console.log('catalog selection count: ' + $obj.size());
    };
    // 定义暴露format函数
    $.fn.catalog.buildChild = function($obj, opts, forobj, selected) {
        var options = '';
        $('#'+forobj+'_id').val('');
        $obj.nextAll("select").remove();
        $child = $('<select id="'+forobj+'_'+$obj.children(":selected").val()+'" for="'+forobj+'_id"><option value="">选择子'+$('#'+forobj+'_id').attr('title')+'</option></select>');
        $.each( opts, function(i, n){
            if (i == selected) {
                options += '<option value="'+i+'" selected="selected">'+n.name+'</option>';
            } else {
                options += '<option value="'+i+'">'+n.name+'</option>';
            }
        });

        $child.append(options);
        $obj.after($child);
        $child.on('change', function(){
            if (typeof(opts[$(this).children(":selected").val()]) != 'undefined' && typeof(opts[$(this).children(":selected").val()]['option']) != 'undefined') {
                $.fn.catalog.buildChild($(this), opts[$(this).children(":selected").val()]['option'], forobj, 0);
            } else {
                $(this).nextAll("select").remove();
                $('#'+forobj+'_id').val($(this).children(":selected").val());
            }
        });
        return $child;
    };
    // 插件的defaults
    $.fn.catalog.defaults = {};
})(jQuery);