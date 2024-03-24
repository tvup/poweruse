@props(['companies'])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Grid area options') }}
                </h3>
                {{ html()->form('POST', route('totalprices.process'))->id('totalprices-form')->open() }}
                {{ csrf_field() }}

                <div class="sm:col-span-3">
                    <label for="show_as" class="block text-sm font-medium text-gray-700">
                        {{ __('Show as:') }}
                    </label>
                    {{ html()->radio('outputformat', (old('outputformat') == 'JSON') || (Cookie::get('outputformat') ?? true), 'JSON')->class('shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md') }}
                    JSON
                    {{ html()->radio('outputformat', (old('outputformat') == 'GRAF') || (Cookie::get('outputformat') ?? false), 'GRAF')->class('shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md') }}
                    GRAF
                </div>

                <div class="form-group">
                    <label for="area">Prisområde:</label>
                    {{ html()->radio('area', (old('area') == 'DK1') || (Cookie::get('area') ?? false), 'DK1') }}
                    DK1
                    {{ html()->radio('area', (old('area') == 'DK2') || (Cookie::get('area') ?? true), 'DK2') }}
                    DK2
                </div>

                <div class="sm:col-span-3">
                    <label for="grid_operator" class="block text-sm font-medium text-gray-700">
                        {{ __('Grid operator') }}
                    </label>
                    {{ html()->select('netcompany', $companies, old('netcompany') ?: (Cookie::get('netcompany') ?? null))->class('form-select shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md') }}
                </div>

                {{ html()->button(__('Get'), 'submit')->class('btn btn-primary mt-2') }}
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
