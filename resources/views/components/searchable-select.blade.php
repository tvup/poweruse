@props(['name', 'options' => [], 'selected' => null, 'placeholder' => __('Type to search...')])

@php
    $flatOptions = [];
    foreach ($options as $option) {
        if (is_array($option)) {
            foreach ($option as $value => $label) {
                $flatOptions[] = ['value' => $value, 'label' => $label];
            }
        }
    }
    $uid = 'ss_' . md5($name . \Illuminate\Support\Str::random(8));
@endphp

<div id="{{ $uid }}" class="position-relative">
    <input type="hidden" name="{{ $name }}" id="{{ $uid }}_value" value="{{ $selected ?? '' }}">

    <div class="input-group">
        <input type="text"
               id="{{ $uid }}_search"
               placeholder="{{ $placeholder }}"
               aria-label="{{ $placeholder }}"
               role="combobox"
               aria-expanded="false"
               aria-controls="{{ $uid }}_list"
               class="form-control"
               autocomplete="off"
               value="">
        <button type="button"
                id="{{ $uid }}_clear"
                class="btn btn-outline-secondary"
                style="display:none"
                tabindex="-1">
            &times;
        </button>
    </div>

    <ul id="{{ $uid }}_list"
        role="listbox"
        class="list-group position-absolute w-100 shadow-sm overflow-auto"
        style="max-height: 280px; z-index: 1050; cursor: pointer; display: none;">
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = @js($flatOptions);
    var uid = @js($uid);
    var selectedValue = @js($selected ?? '');

    var container = document.getElementById(uid);
    var hiddenInput = document.getElementById(uid + '_value');
    var searchInput = document.getElementById(uid + '_search');
    var clearBtn = document.getElementById(uid + '_clear');
    var listEl = document.getElementById(uid + '_list');
    var highlightIndex = -1;
    var selectedLabel = '';

    function filter(term) {
        if (!term) return options;
        var terms = term.toLowerCase().split(/\s+/);
        return options.filter(function(o) {
            var label = String(o.label).toLowerCase();
            return terms.every(function(t) { return label.indexOf(t) !== -1; });
        });
    }

    function showList() {
        listEl.style.display = 'block';
        searchInput.setAttribute('aria-expanded', 'true');
    }

    function hideList() {
        listEl.style.display = 'none';
        searchInput.setAttribute('aria-expanded', 'false');
    }

    function render(filtered) {
        listEl.innerHTML = '';
        if (filtered.length === 0) {
            listEl.innerHTML = '<li class="list-group-item py-2 px-3 small text-muted">' + @js(__('No results')) + '</li>';
            showList();
            return;
        }
        filtered.forEach(function(option, index) {
            var li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action py-2 px-3 small';
            li.textContent = option.label;
            if (index === highlightIndex) li.classList.add('active');
            li.addEventListener('click', function() { select(option); });
            li.addEventListener('mouseenter', function() {
                highlightIndex = index;
                updateHighlight();
            });
            listEl.appendChild(li);
        });
        showList();
    }

    function updateHighlight() {
        var items = listEl.querySelectorAll('.list-group-item-action');
        items.forEach(function(item, i) {
            item.classList.toggle('active', i === highlightIndex);
        });
        if (items[highlightIndex]) items[highlightIndex].scrollIntoView({ block: 'nearest' });
    }

    function select(option) {
        hiddenInput.value = option.value;
        searchInput.value = option.label;
        selectedLabel = option.label;
        selectedValue = option.value;
        hideList();
        highlightIndex = -1;
        clearBtn.style.display = 'inline-block';
    }

    function openList() {
        var filtered = filter(searchInput.value);
        highlightIndex = -1;
        render(filtered);
    }

    searchInput.addEventListener('focus', openList);
    searchInput.addEventListener('input', function() {
        if (searchInput.value !== selectedLabel) {
            hiddenInput.value = '';
            clearBtn.style.display = 'none';
        }
        highlightIndex = 0;
        render(filter(searchInput.value));
    });

    searchInput.addEventListener('keydown', function(e) {
        var isOpen = listEl.style.display !== 'none';
        if (!isOpen) return;

        var filtered = filter(searchInput.value);
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightIndex = Math.min(highlightIndex + 1, filtered.length - 1);
            updateHighlight();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightIndex = Math.max(highlightIndex - 1, 0);
            updateHighlight();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightIndex >= 0 && filtered[highlightIndex]) {
                select(filtered[highlightIndex]);
            }
        } else if (e.key === 'Escape') {
            hideList();
            highlightIndex = -1;
        }
    });

    clearBtn.addEventListener('click', function() {
        hiddenInput.value = '';
        searchInput.value = '';
        selectedLabel = '';
        selectedValue = '';
        clearBtn.style.display = 'none';
        searchInput.focus();
        openList();
    });

    document.addEventListener('click', function(e) {
        if (!container.contains(e.target)) {
            hideList();
        }
    });

    // Init: set label for pre-selected value
    if (selectedValue) {
        var found = options.find(function(o) { return o.value === selectedValue; });
        if (found) {
            searchInput.value = found.label;
            selectedLabel = found.label;
            clearBtn.style.display = 'inline-block';
        }
    }
});
</script>
