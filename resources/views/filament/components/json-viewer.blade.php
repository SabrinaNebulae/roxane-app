@php
    $json = is_string($data)
        ? json_decode($data, true)
        : $data;
@endphp

@vite('resources/css/backend.css')
<details class="fi-section-content mt-3">
    <summary class="fi-btn fi-btn-size-sm fi-btn-color-gray cursor-pointer">
        Afficher les données JSON
    </summary>

    <div class="bg-black text-white mt-3 p-3 rounded-lg overflow-hidden">
        <pre class="fi-code-block text-sm">
{{ json_encode(
    $json,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) }}
        </pre>
    </div>
</details>
