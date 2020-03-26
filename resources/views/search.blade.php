@push('scripts')
    <script>
        $(document).ready(function() {
            function delay(fn, ms) {
                let timer = 0
                return function(...args) {
                    clearTimeout(timer)
                    timer = setTimeout(fn.bind(this, ...args), ms || 0)
                }
            }

            function whereRow(row, searchValues){
                ret = true;
                $.each(searchValues, (field, search) => {
                    if(!search)
                        return;

                    val = $(row).find('.' + field).val();
                    if(val.toLowerCase().indexOf(search.toLowerCase()) === -1){
                        ret = false;
                    }
                });

                return ret;
            }

            function search(){
                searchValues = {};
                searchFields.forEach((item) => {
                    searchValue = $('#' + item + '_search').val();
                    searchValues[item] = searchValue;
                });

                $('.translation-row').each((index, element) => {
                    if(whereRow(element, searchValues)){
                        $(element).show();
                    }else{
                        $(element).hide();
                    }
                });
            }

            selectorArray = [];
            searchFields.forEach((item) => {selectorArray.push('#' + item + '_search')});
            selector = selectorArray.join(',');

            $(selector).on('change keyup paste', delay(function (e) {
                search();
            }, 500));

        });
    </script>
@endpush