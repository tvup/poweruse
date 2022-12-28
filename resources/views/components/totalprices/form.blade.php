@props(['companies'])

<div>
    <div x-data="{ open: true }" class="overflow-hidden">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Total-prices
                    </h3>
                </div>
            </div>
        </div>

        <div x-show="open" x-cloak class="divide-y divide-gray-200 py-4 px-4">
            <div class="pt-8">

                <form name="add-blog-post-form" id="add-blog-post-form" method="post"
                      action="{{route('totalprices.process')}}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="exampleInputEmail1">Vis som:</label>
                        JSON {{ Form::radio('outputformat', 'JSON' , (old('outputformat') && old('outputformat')=='JSON') ? old('outputformat') : true) }}
                        GRAF {{ Form::radio('outputformat', 'GRAF' , (old('outputformat') && old('outputformat')=='GRAF') ? old('outputformat') : false) }}
                    </div>



                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Hent
                    </button>
                </form>
            </div>
        </div>
    </div>


</div>