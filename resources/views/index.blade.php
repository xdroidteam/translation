<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Translation Manager</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:300,400,500|Roboto:300,400,500&subset=cyrillic-ext,latin-ext" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" media="screen" title="no title" charset="utf-8">

    <link rel="stylesheet" href="/vendor/xdroid/translation/translations.css" media="screen" title="no title" charset="utf-8">

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
            <div class="subtitle">
                Groups
            </div>
            <ul class="groups-list">
                @foreach($groups as $groupName)
                    <li>
                        <a href="/translations/{{{ $groupName }}}" class="{{{ $group == $groupName ? 'active' : null }}}">
                            {{{ $groupName }}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="table-section">
            <div class="subtitle">
                {{{ $group }}}
                <div class="status-summary">
                    <div>
                        <span>Total:</span>
                        <span>{{{ count($translations) }}}</span>
                    </div>
                    <div>
                        <span>Changed:</span>
                        <span id="changedTrans">0</span>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th width="{{{ 100 / (count($locals) + 1) }}}%">
                            Key
                        </th>
                        @foreach($locals as $localName => $value)
                            <th width="{{{ 100 / (count($locals) + 1) }}}%">
                                {{{ $localName }}}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            </table>
            <div class="table-wrapper">
                {!!csrf_field() !!}
                <table class="table">
                    <tbody>
                        @foreach($translations as $translationKey => $translation)
                            <tr>
                                <td width="{{{ 100 / (count($locals) + 1) }}}%">
                                    <input type="text"
                                            class="editable"
                                            name="name"
                                            value="{{{ $translationKey }}}"
                                            title="{{{ $translationKey }}}"
                                            disabled="disabled"/>
                                </td>
                                @foreach($locals as $localName => $value)
                                    <td width="{{{ 100 / (count($locals) + 1) }}}%">
                                        <button type="button" name="button" class="action action-yes">
                                            Save
                                        </button>
                                        <input type="text"
                                                class="editable {{{ $translation[$localName] ? '' : 'missing'}}}"
                                                name="{{{ $localName }}}"
                                                data-locale="{{{ $localName }}}"
                                                data-key="{{{ $translationKey }}}"
                                                data-group="{{{ $group }}}"
                                                title="{{{ $translation[$localName] }}}"
                                                value="{{{ $translation[$localName] }}}"/>
                                        <div class="action action-no">
                                            Cancel
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="/vendor/xdroid/translation/translations.js" charset="utf-8"></script>
</body>
</html>
