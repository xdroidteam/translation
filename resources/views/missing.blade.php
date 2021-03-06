@extends('translation::index')
@section('table')
    <div class="table-section">
        <div class="subtitle">
            Missing translations
            <div class="status-summary">
                <div>
                    <span>Total:</span>
                    <span>{{{ count($missingTranslations) }}}</span>
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
                    <th width="25%">
                        Locale
                    </th>
                    <th width="25%">
                        Group
                    </th>
                    <th width="25%">
                        Key
                    </th>
                    <th width="25%">
                        Translation
                    </th>
                </tr>
                <tr>
                    <th width="25%">
                        <input type="text"
                        class="editable"
                        name="locale_search"
                        id="locale_search"
                        placeholder="Search..."
                        value=""/>
                    </th>
                    <th width="25%">
                        <input type="text"
                        class="editable"
                        name="group_search"
                        id="group_search"
                        placeholder="Search..."
                        value=""/>
                    </th>
                    <th width="25%">
                        <input type="text"
                        class="editable"
                        name="key_search"
                        id="key_search"
                        value=""
                        placeholder="Search..."/>
                    </th>
                    <th width="25%">
                        <input type="text"
                        class="editable"
                        name="trans_search"
                        id="trans_search"
                        value=""
                        placeholder="Search..."/>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="table-wrapper">
            {!!csrf_field() !!}
            <table class="table">
                <tbody>
                    @foreach($missingTranslations as $missingTranslation)
                        <tr  class="translation-row">
                            <td width="25%">
                                <input type="text"
                                class="editable locale"
                                name="name"
                                value="{{{ $missingTranslation->locale }}}"
                                title="{{{ $missingTranslation->locale }}}"
                                disabled="disabled"/>
                            </td>
                            <td width="25%">
                                <input type="text"
                                class="editable group"
                                name="name"
                                value="{{{ $missingTranslation->group }}}"
                                title="{{{ $missingTranslation->group }}}"
                                disabled="disabled"/>
                            </td>
                            <td width="25%">
                                <input type="text"
                                class="editable key"
                                name="name"
                                value="{{{ $missingTranslation->key }}}"
                                title="{{{ $missingTranslation->key }}}"
                                disabled="disabled"/>
                            </td>
                            <td width="25%">
                                <button type="button" name="button" class="action action-yes">
                                    Save
                                </button>
                                <input type="text"
                                class="editable trans"
                                name="{{{ $missingTranslation->locale }}}"
                                data-locale="{{{ $missingTranslation->locale }}}"
                                data-key="{{{ $missingTranslation->key }}}"
                                data-group="{{{ $missingTranslation->group }}}"
                                title="{{{ $missingTranslation->translation }}}"
                                value="{{{ $missingTranslation->translation }}}"/>
                                <div class="action action-no">
                                    Cancel
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var searchFields = ['locale', 'group', 'key', 'trans'];
</script>
@endpush
@include('translation::search')