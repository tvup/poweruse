@props(['companies'])

<div>
    <div x-data="{ open: true }" class="overflow-hidden">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="ml-4 mt-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('Grid area options') }}
                    </h3>
                </div>
            </div>
        </div>

        <div x-show="open" x-cloak class="divide-y divide-gray-200 py-4 px-4">
            <div class="pt-8">

                <form name="add-blog-post-form" id="add-blog-post-form" method="post"
                      action="{{route('totalprices.process')}}">
                    {{ csrf_field() }}

                    <div class="sm:col-span-3">
                        <label for="show_as" class="block text-sm font-medium text-gray-700">
                            {{__('Show as:') }}
                        </label>
                        JSON {{ Form::radio('outputformat', 'JSON' , (old('outputformat') && old('outputformat')=='JSON') ? old('outputformat') : (Cookie::get('outputformat') ?? true), ['class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md']) }}
                        GRAF {{ Form::radio('outputformat', 'GRAF' , (old('outputformat') && old('outputformat')=='GRAF') ? old('outputformat') : (Cookie::get('outputformat') ?? false), ['class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md']) }}
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Prisområde:</label>
                        DK1 {{ Form::radio('area', 'DK1' , (old('area') && old('area')=='DK1') ? old('area') : false) }}
                        DK2 {{ Form::radio('area', 'DK2' , (old('area') && old('area')=='DK2') ? old('area') : true) }}
                    </div>

                    <div class="sm:col-span-3">
                        <label for="grid_operator" class="block text-sm font-medium text-gray-700">
                            {{ __('Grid operator') }}
                        </label>
                        {!! Form::select('netcompany', $companies, old('netcompany') ? : (Cookie::get('netcompany') ?? null), ['class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md']) !!}
                    </div>



                    <button type="submit" class="btn btn-primary">
                        {{ __('Get')}}
                    </button>
                </form>
            </div>
        </div>
    </div>


</div>