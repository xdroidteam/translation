$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    var _text = "",
        _activeInput = false,
        _changed = 0;

    $('.editable').focusin(function() {
        var $this = $(this);

        if (_activeInput)
            _activeInput.parent().children('.action-no').trigger('click');

        _text = $this.val();
        _activeInput = $this;
        $this.parent().children('.action').css('display', 'flex');
    });

    $('body').on('click', function() {
        if (_activeInput)
            _activeInput.parent().children('.action-no').trigger('click');
        }
    );

    $('.editable, .action').on('click', function(e) {
        e.stopPropagation();
    });

    $('.action-no').on('click', function() {
        var $parent = $(this).parent();
        $parent.children('.editable').val(_text);
        $parent.children('.action').css('display', 'none');
    });

    $('.action-yes').on('click', function() {
        var $this = $(this);
        if(_activeInput.val() == _text){
            _activeInput.parent().children('.action-no').trigger('click');
            return;
        }
        _activeInput = false;
        $this.parent().children('.action-no').css('display', 'none');
        $this.toggleClass('action-active');

        var $input = $this.next('input');

        $.post("/translations/update-or-create", {
            locale: $input.data('locale'),
            group: $input.data('group'),
            key: $input.data('key'),
            translation: $input.val()
        }).done(function(data) {
            $this.hide();
            $this.toggleClass('action-active');
            transChanged($input);
        }).fail(function(data) {});
    });

    var transChanged = function($input){
        if($input.hasClass('changed'))
            return;

        _changed++;
        $('#changedTrans').html(_changed);
        $input.addClass('changed')
    }

    var groupHeight = $('.groups-list').height(),
        tableHeight = $('.table-wrapper').height();

    $('.groups-list').slimScroll({height: groupHeight, distance: '0px', color: '#47525E', borderRadius: '0'});

    $('.table-wrapper').slimScroll({height: tableHeight, distance: '0px', color: '#47525E', borderRadius: '0'});
});

$(document).on('keyup', '.editable', function(event) {
    if (event.keyCode == 13) {
        $(this).siblings('.action-yes').trigger('click');
        $(this).blur();
    }
    if (event.keyCode == 27) {
        $(this).siblings('.action-no').trigger('click');
        $(this).blur();
    }
});
