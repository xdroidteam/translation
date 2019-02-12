<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Translation Manager</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:300,400,500|Roboto:300,400,500&subset=cyrillic-ext,latin-ext" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" media="screen" title="no title" charset="utf-8">

    <style>
        html,
        body {
            height: 100%;
            color: #47525E;
            background-color: #fff;
            font-family: 'Roboto', sans-serif;
            font-size: 100%;
            line-height: 1.5;
        }
        .title {
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            height: 9%;
            margin: 0 1em;
            font-size: 2em;
            font-weight: 300;
            line-height: 1;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
        .subtitle {
            position: relative;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            width: 100%;
            height: 8%;
            padding: 0;
            text-transform: capitalize;
            font-size: 1.5em;
            font-weight: 500;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
        }
        .subtitle .status-summary {
            position: absolute;
            top: 0;
            right: 0;
            padding: .5em;
            text-align: left;
        }
        .subtitle .status-summary div {
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            color: rgba(71, 82, 94, 0.5);
            font-size: .6em;
            font-weight: 400;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            -ms-flex-pack: justify;
            -webkit-justify-content: space-between;
            justify-content: space-between;
        }
        .subtitle .status-summary div span {
            margin-left: .5em;
        }
        .wrapper {
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            height: 91%;
            -ms-flex-pack: start;
            -webkit-justify-content: flex-start;
            justify-content: flex-start;
        }
        .groups {
            height: 100%;
            background-color: #E8F1F2;
            -ms-flex-preferred-size: 300px;
            -webkit-flex-basis: 300px;
            flex-basis: 300px;
        }
        .groups ul {
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            height: 92%;
            margin: 0;
            padding: 0;
            list-style-type: none;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
        }
        .groups ul li {
            width: 100%;
            margin: 0;
            padding: 0;
            text-align: center;
            font-size: 1em;
            line-height: 2em;
        }
        .groups ul li a {
            display: block;
            width: 100%;
            height: 100%;
            transition: all .2s ease;
        }
        .groups ul li a:hover {
            cursor: pointer;
            background-color: #D1D1D1;
        }
        .groups ul li .active {
            background-color: #D1D1D1;
        }
        .table-section {
            background-color: #D1D1D1;
            -ms-flex: 2;
            -webkit-flex: 2;
            flex: 2;
        }
        .table-wrapper {
            height: 82%;
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            text-align: left;
            border: 0;
            border-collapse: collapse;
            font-family: 'Roboto Mono', monospace;
        }
        .table tbody tr {
            border-bottom: 1px solid #c4c4c4;
        }
        .table thead tr th {
            padding: 1em;
            border: 0;
            font-size: 1em;
            font-weight: 500;
            line-height: 1em;
        }
        .table tbody tr td {
            position: relative;
            padding: 0;
            cursor: pointer;
            text-align: center;
            border: 0;
            font-size: .9em;
            font-weight: 400;
            line-height: 0;
        }
        .table tbody tr td:nth-of-type(2n) {
            background-color: #d6d6d6;
        }
        .editable {
            display: block;
            box-sizing: border-box;
            width: 100%;
            padding: 1em;
            cursor: pointer;
            transition: all .2s ease;
            color: inherit;
            border: 0;
            outline: 0;
            background: 0;
            box-shadow: none;
            font-size: 1em;
            line-height: 1em;
        }
        .editable:focus,
        .editable:active {
            cursor: text;
            border: 0;
            outline: 0;
            background-color: #fff;
            box-shadow: inset 0 0 0 1px #47525E;
        }
        .editable:hover {
            background-color: #fff;
        }
        .editable:disabled:hover,
        .editable:disabled:focus,
        .editable:disabled:active {
            cursor: default;
            background: 0;
        }
        .action {
            position: absolute;
            z-index: 10;
            top: 100%;
            display: none;
            width: 50%;
            height: 30px;
            margin: 0;
            padding: 0;
            cursor: pointer;
            transition: all .2s ease;
            color: #fff;
            border: 0;
            outline: 0;
            background-color: #47525E;
            box-shadow: inset 0 0 0 1px #47525E;
            font-size: 1em;
            line-height: 1;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -ms-grid-row-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
        }
        .action-yes {
            right: 50%;
        }
        .action-yes:hover {
            background-color: #8FD694;
        }
        .action-active {
            right: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #8FD694;
        }
        .action-active::before {
            position: absolute;
            z-index: 15;
            right: 0;
            top: 0;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            width: 100%;
            height: 100%;
            content: "Saving...";
            background-color: #8FD694;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
        }
        .action-no {
            right: 0;
        }
        .action-no:hover {
            background-color: #F2545B;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        .table-btn {
            position: absolute;
            top: 25%;
            left: 1em;
            border: 1px solid #47525E;
            font-size: 14px;
            background-color: transparent;
            padding: 3px 8px;
            font-weight: normal;
            cursor: pointer;
            transition: all .25s ease;
        }

        .table-btn:hover {
            background-color: #47525E;
            color: #fff;
        }

        .count {
            font-weight: bold;
            margin-left: 5px;
            background: #D05353;
            padding: 2px 4px;
            font-size: 14px;
            color: #d6d6d6;
        }
        .missing {
            box-shadow: inset 0 0 0 1px #D05353;
        }
        .action-btn {
            position: relative;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            width: 100%;
            height: 6%;
            padding: 0;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        .action-btn a {
            cursor: pointer;
            transition: all .25s ease;
            position: absolute;
            top: 33%;
            padding: 3px 8px;
            margin: 0;
            font-size: 14px;
            border: 1px solid #47525E
        }

        .action-btn a:hover {
            background-color: #47525E;
            color: #fff;
        }

        .action-btn .active {
            background-color: #47525E;
            color: #fff;
        }

        .action-btn .active:hover {
            background: transparent;
            color: #47525E;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js" charset="utf-8"></script>
</head>
<body>
    <div class="title">
        <a href="/">
            Translation Manager
        </a>
    </div>
    <div class="wrapper">
        <div class="groups">
            <div class="action-btn">
                <a  href="/{{{ str_finish(config('xdroidteam-translation.route.prefix', '/'), '/') }}}missing"
                    class="{{{ starts_with('/' . \Request::path(), '/' . str_finish(config('xdroidteam-translation.route.prefix', '/'), '/') . 'missing') ? 'active' : '' }}}">
                    Missing
                    @if ($missingCount > 0)
                        <span class="count">{{{$missingCount}}}</span>
                    @endif
                </a>
            </div>
            <div class="action-btn">
                <a  href="/{{{ str_finish(config('xdroidteam-translation.route.prefix', '/'), '/') }}}all"
                    class="{{{ starts_with('/' . \Request::path(), '/' . str_finish(config('xdroidteam-translation.route.prefix', '/'), '/') . 'all') ? 'active' : '' }}}">
                    All
                </a>
            </div>
            <div class="subtitle">
                Groups
            </div>
            <ul class="groups-list">
                @foreach($groups as $group => $missingTrans)
                    <li>
                        <a href="/{{{ str_finish(config('xdroidteam-translation.route.prefix', '/'), '/') }}}group/{{{ $group }}}"
                            class="{{{ $selectedGroup == $group && ! (starts_with('/' . \Request::path(), '/' . str_finish(config('xdroidteam-translation.route.prefix', '/'), '/') . 'missing') ) ? 'active' : null }}}">
                            {{{ $group }}}
                            @if ($missingTrans > 0)
                                <span class="count {{{ $group }}}">{{{$missingTrans}}}</span>
                            @else
                                <span class="count {{{ $group }}}" style="display:none;">0</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @yield('table')
    </div>
    <script>
        var _xdroidTeamTranslationBaseRoute = '/{{{ config("xdroidteam-translation.route.prefix")}}}';

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
            });

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
                if (_activeInput.val() == _text) {
                    _activeInput.parent().children('.action-no').trigger('click');
                    return;
                }

                updateCounters();

                if (_activeInput.val())
                    _activeInput.removeClass('missing');
                else
                    _activeInput.addClass('missing');

                _activeInput = false;
                $this.parent().children('.action-no').css('display', 'none');
                $this.toggleClass('action-active');

                var $input = $this.next('input');

                $.post(_xdroidTeamTranslationBaseRoute + "/update-or-create", {
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

            var updateCounters = function(){
                localeCount = $('.count.' + _activeInput.data('locale')).html() * 1;
                groupCount = $('a.active .count').html() * 1;

                if (_activeInput.val() && _activeInput.hasClass('missing')){
                    if (localeCount - 1 == 0)
                        $('.count.' + _activeInput.data('locale')).hide();

                    $('.count.' + _activeInput.data('locale')).html(localeCount - 1);

                    if (groupCount - 1 == 0)
                        $('a.active .count').hide()

                    $('a.active .count').html(groupCount - 1);
                } else if(!_activeInput.val() && !_activeInput.hasClass('missing')){
                    if (localeCount == 0)
                        $('.count.' + _activeInput.data('locale')).show();

                    $('.count.' + _activeInput.data('locale')).html(localeCount + 1);

                    if (groupCount == 0)
                        $('a.active .count').show()

                    $('a.active .count').html(groupCount + 1);
                }

            }

            var transChanged = function($input) {
                if ($input.hasClass('changed'))
                    return;

                _changed++;
                $('#changedTrans').html(_changed);
                $input.addClass('changed')
            }

            var groupHeight = $('.groups-list').height(),
                tableHeight = $('.table-wrapper').height();

            $('.groups-list').slimScroll({
                height: groupHeight - 120,
                distance: '0px',
                color: '#47525E',
                borderRadius: '0'
            });

            $('.table-wrapper').slimScroll({
                height: tableHeight,
                distance: '0px',
                color: '#47525E',
                borderRadius: '0'
            });
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

        $(document).on('click', '#show-only-missing', function(e){
            $('.translation-row').each(function( index, obj ) {
                if (!$(this).find('input').hasClass('missing'))
                    $(this).hide();
            });
            $(this).hide();
            $('#show-all').show();
        });

        $(document).on('click', '#show-all', function(e){
            $('.translation-row').each(function( index, obj ) {
                $(this).show();
            });
            $(this).hide();
            $('#show-only-missing').show();
        });
    </script>
</body>
</html>
