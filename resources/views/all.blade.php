@extends('translation::index')
@section('table')
    <div class="table-section">
        <div class="subtitle">
            All translations
            <div class="status-summary">
                <div>
                    <span>Total:</span>
                    <span>{{{ count($allTranslations) }}}</span>
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
                    @foreach($allTranslations as $allTranslation)
                        <tr  class="translation-row">
                            <td width="25%">
                                <input type="text"
                                class="editable locale"
                                name="name"
                                value="{{{ $allTranslation->locale }}}"
                                title="{{{ $allTranslation->locale }}}"
                                disabled="disabled"/>
                            </td>
                            <td width="25%">
                                <input type="text"
                                class="editable group"
                                name="name"
                                value="{{{ $allTranslation->group }}}"
                                title="{{{ $allTranslation->group }}}"
                                disabled="disabled"/>
                            </td>
                            <td width="25%">
                                <input type="text"
                                class="editable key"
                                name="name"
                                value="{{{ $allTranslation->key }}}"
                                title="{{{ $allTranslation->key }}}"
                                disabled="disabled"/>
                            </td>
                            <td width="25%">
                                <button type="button" name="button" class="action action-yes">
                                    Save
                                </button>
                                <input type="text"
                                class="editable trans"
                                name="{{{ $allTranslation->locale }}}"
                                data-locale="{{{ $allTranslation->locale }}}"
                                data-key="{{{ $allTranslation->key }}}"
                                data-group="{{{ $allTranslation->group }}}"
                                title="{{{ $allTranslation->translation }}}"
                                value="{{{ $allTranslation->translation }}}"/>
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
