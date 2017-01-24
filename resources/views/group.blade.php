@extends('translation::index')
@section('table')
    <div class="table-section">
        <div class="subtitle">
            {{{ $selectedGroup }}}
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
            <button id="show-only-missing" class="table-btn">
                Show only missing translations
            </button>
            <button id="show-all" style="display:none" class="table-btn">
                Show all translations
            </button>
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
                            @if ($missingByLocal[$localName])
                                <span class="count {{{ $localName }}}">
                                    {{{ $missingByLocal[$localName] }}}
                                </span>
                            @else
                                <span class="count {{{ $localName }}}" style="display:none;">
                                    0
                                </span>
                            @endif
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
                        <tr  class="translation-row">
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
                                    data-group="{{{ $selectedGroup }}}"
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
@endsection
