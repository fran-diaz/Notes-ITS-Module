$(document).on('keypress','.notes__input',function(e){
    if (e.which === 13) {
        
        var d = $(this).closest('.component').find('.notes__box').attr('data-d');
        var component = $(this).closest('.component').data('component');
        var msg = $(this).val();
        var that = $(this);
    
        $.ajax({
            type: 'POST',
            url: '/ajax',
            data: 'DEBUG=0&action=table/save-note&d='+d+'&msg='+msg,
            success: function(data){
                that.closest('.component').find('.notes__box').prepend(data);
            }
        });
    }
});

$(document).on('click','.notes__btn',function(e){
    var d = $(this).closest('.component').find('.notes__box').attr('data-d');
    var component = $(this).closest('.component').data('component');
    var msg = $(this).closest('.input-group').find('input').val();
    var that = $(this);
    
    $.ajax({
        type: 'POST',
        url: '/ajax',
        data: 'DEBUG=0&action=table/save-note&d='+d+'&msg='+msg,
        success: function(data){
            that.closest('.component').find('.notes__box').prepend(data);
        }
    });
});