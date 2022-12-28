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
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Create a new bookmark.
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Add information about the bookmark to make it easier to understand later.
                    </p>
                </div>
                <form name="add-blog-post-form" id="add-blog-post-form" method="post"
                      action="{{route('totalprices.process')}}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="exampleInputEmail1">Vis som:</label>
                        JSON {{ Form::radio('outputformat', 'JSON' , (old('outputformat') && old('outputformat')=='JSON') ? old('outputformat') : true) }}
                        GRAF {{ Form::radio('outputformat', 'GRAF' , (old('outputformat') && old('outputformat')=='GRAF') ? old('outputformat') : false) }}
                    </div>




                    <button type="submit" class="btn btn-primary">Hent</button>
                </form>
            </div>
        </div>
    </div>


</div>