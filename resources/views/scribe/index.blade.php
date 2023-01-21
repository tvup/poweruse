<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Poweruse Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var baseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-4.12.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-4.12.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET api/user</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el-totalprice--GLNNumber-">
                                <a href="#endpoints-GETapi-el-totalprice--GLNNumber-">GET api/el/totalprice/{GLNNumber}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el-Elspotprices">
                                <a href="#endpoints-GETapi-el-Elspotprices">GET api/el/Elspotprices</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el--refreshToken-">
                                <a href="#endpoints-GETapi-el--refreshToken-">GET api/el/{refreshToken}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el--refreshToken--smartme">
                                <a href="#endpoints-GETapi-el--refreshToken--smartme">GET api/el/{refreshToken}/smartme</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el-charges--refreshToken-">
                                <a href="#endpoints-GETapi-el-charges--refreshToken-">GET api/el/charges/{refreshToken}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el--start_date---end_date---price_area---refreshToken-">
                                <a href="#endpoints-GETapi-el--start_date---end_date---price_area---refreshToken-">GET api/el/{start_date}/{end_date}/{price_area}/{refreshToken}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-el--refreshToken--delete">
                                <a href="#endpoints-GETapi-el--refreshToken--delete">GET api/el/{refreshToken}/delete</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-meteringPoint--refresh_token--">
                                <a href="#endpoints-GETapi-meteringPoint--refresh_token--">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-meteringPoint">
                                <a href="#endpoints-POSTapi-meteringPoint">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-meteringPoint--id-">
                                <a href="#endpoints-GETapi-meteringPoint--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-meteringPoint--id-">
                                <a href="#endpoints-PUTapi-meteringPoint--id-">Update the specified resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-meteringPoint--id-">
                                <a href="#endpoints-DELETEapi-meteringPoint--id-">Remove the specified resource from storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-charge--refresh_token--">
                                <a href="#endpoints-GETapi-charge--refresh_token--">isplay a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-charges--metering_point--">
                                <a href="#endpoints-DELETEapi-charges--metering_point--">Remove the specified resources from storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-charge">
                                <a href="#endpoints-POSTapi-charge">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-charge--id-">
                                <a href="#endpoints-GETapi-charge--id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-charge--id-">
                                <a href="#endpoints-PUTapi-charge--id-">Update the specified resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-charge--id-">
                                <a href="#endpoints-DELETEapi-charge--id-">Remove the specified resource from storage.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: January 21, 2023</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user"></code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-el-totalprice--GLNNumber-">GET api/el/totalprice/{GLNNumber}</h2>

<p>
</p>



<span id="example-requests-GETapi-el-totalprice--GLNNumber-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/totalprice/vel" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/totalprice/vel"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el-totalprice--GLNNumber-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Undefined array key \&quot;vel\&quot;&quot;,
    &quot;exception&quot;: &quot;ErrorException&quot;,
    &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
    &quot;line&quot;: 757,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php&quot;,
            &quot;line&quot;: 266,
            &quot;function&quot;: &quot;handleError&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 757,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;apiGetTotalPriceToday&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el-totalprice--GLNNumber-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el-totalprice--GLNNumber-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el-totalprice--GLNNumber-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el-totalprice--GLNNumber-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el-totalprice--GLNNumber-"></code></pre>
</span>
<form id="form-GETapi-el-totalprice--GLNNumber-" data-method="GET"
      data-path="api/el/totalprice/{GLNNumber}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el-totalprice--GLNNumber-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el-totalprice--GLNNumber-"
                    onclick="tryItOut('GETapi-el-totalprice--GLNNumber-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el-totalprice--GLNNumber-"
                    onclick="cancelTryOut('GETapi-el-totalprice--GLNNumber-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el-totalprice--GLNNumber-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/totalprice/{GLNNumber}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el-totalprice--GLNNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el-totalprice--GLNNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>GLNNumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="GLNNumber"                data-endpoint="GETapi-el-totalprice--GLNNumber-"
               value="vel"
               data-component="url">
    <br>
<p>Example: <code>vel</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-el-Elspotprices">GET api/el/Elspotprices</h2>

<p>
</p>



<span id="example-requests-GETapi-el-Elspotprices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/Elspotprices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/Elspotprices"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el-Elspotprices">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;total&quot;: 222,
    &quot;dataset&quot;: &quot;Elspotprices&quot;,
    &quot;records&quot;: [
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1103.339966,
            &quot;SpotPriceEUR&quot;: 148.300003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1103.339966,
            &quot;SpotPriceEUR&quot;: 148.300003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1014.950012,
            &quot;SpotPriceEUR&quot;: 136.419998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 377.869995,
            &quot;SpotPriceEUR&quot;: 50.790001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1093.439941,
            &quot;SpotPriceEUR&quot;: 146.970001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 767.869995,
            &quot;SpotPriceEUR&quot;: 103.209999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1170.670044,
            &quot;SpotPriceEUR&quot;: 157.350006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1170.670044,
            &quot;SpotPriceEUR&quot;: 157.350006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1022.76001,
            &quot;SpotPriceEUR&quot;: 137.470001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 397.440002,
            &quot;SpotPriceEUR&quot;: 53.419998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1170.670044,
            &quot;SpotPriceEUR&quot;: 157.350006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 787.219971,
            &quot;SpotPriceEUR&quot;: 105.809998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1238,
            &quot;SpotPriceEUR&quot;: 166.399994
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1238,
            &quot;SpotPriceEUR&quot;: 166.399994
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1039.280029,
            &quot;SpotPriceEUR&quot;: 139.690002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 412.769989,
            &quot;SpotPriceEUR&quot;: 55.48
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1229.439941,
            &quot;SpotPriceEUR&quot;: 165.25
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 817.570007,
            &quot;SpotPriceEUR&quot;: 109.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1299.819946,
            &quot;SpotPriceEUR&quot;: 174.710007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1299.819946,
            &quot;SpotPriceEUR&quot;: 174.710007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1074.920044,
            &quot;SpotPriceEUR&quot;: 144.479996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 855.369995,
            &quot;SpotPriceEUR&quot;: 114.970001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1299.819946,
            &quot;SpotPriceEUR&quot;: 174.710007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 833.419983,
            &quot;SpotPriceEUR&quot;: 112.019997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1481.800049,
            &quot;SpotPriceEUR&quot;: 199.169998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1481.800049,
            &quot;SpotPriceEUR&quot;: 199.169998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1422.959961,
            &quot;SpotPriceEUR&quot;: 191.259995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1422.959961,
            &quot;SpotPriceEUR&quot;: 191.259995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1481.800049,
            &quot;SpotPriceEUR&quot;: 199.169998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 854.169983,
            &quot;SpotPriceEUR&quot;: 114.809998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1503.380005,
            &quot;SpotPriceEUR&quot;: 202.070007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1503.380005,
            &quot;SpotPriceEUR&quot;: 202.070007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1456.810059,
            &quot;SpotPriceEUR&quot;: 195.809998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1456.810059,
            &quot;SpotPriceEUR&quot;: 195.809998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1481.51001,
            &quot;SpotPriceEUR&quot;: 199.130005
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 876.119995,
            &quot;SpotPriceEUR&quot;: 117.760002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1428.390015,
            &quot;SpotPriceEUR&quot;: 191.990005
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1428.390015,
            &quot;SpotPriceEUR&quot;: 191.990005
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1384.119995,
            &quot;SpotPriceEUR&quot;: 186.039993
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1384.119995,
            &quot;SpotPriceEUR&quot;: 186.039993
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1428.390015,
            &quot;SpotPriceEUR&quot;: 191.990005
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 875.080017,
            &quot;SpotPriceEUR&quot;: 117.620003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1272.449951,
            &quot;SpotPriceEUR&quot;: 171.029999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1272.449951,
            &quot;SpotPriceEUR&quot;: 171.029999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1233.01001,
            &quot;SpotPriceEUR&quot;: 165.729996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1233.01001,
            &quot;SpotPriceEUR&quot;: 165.729996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1272.449951,
            &quot;SpotPriceEUR&quot;: 171.029999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 866.299988,
            &quot;SpotPriceEUR&quot;: 116.440002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1171.709961,
            &quot;SpotPriceEUR&quot;: 157.490005
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1143.589966,
            &quot;SpotPriceEUR&quot;: 153.710007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1132.949951,
            &quot;SpotPriceEUR&quot;: 152.279999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1132.949951,
            &quot;SpotPriceEUR&quot;: 152.279999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1143.589966,
            &quot;SpotPriceEUR&quot;: 153.710007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 875.530029,
            &quot;SpotPriceEUR&quot;: 117.68
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1152.439941,
            &quot;SpotPriceEUR&quot;: 154.899994
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1124.839966,
            &quot;SpotPriceEUR&quot;: 151.190002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1039.949951,
            &quot;SpotPriceEUR&quot;: 139.779999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1039.949951,
            &quot;SpotPriceEUR&quot;: 139.779999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1124.839966,
            &quot;SpotPriceEUR&quot;: 151.190002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 869.950012,
            &quot;SpotPriceEUR&quot;: 116.93
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1115.97998,
            &quot;SpotPriceEUR&quot;: 150
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 892.640015,
            &quot;SpotPriceEUR&quot;: 119.980003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1033.329956,
            &quot;SpotPriceEUR&quot;: 138.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 892.640015,
            &quot;SpotPriceEUR&quot;: 119.980003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 892.640015,
            &quot;SpotPriceEUR&quot;: 119.980003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 854.919983,
            &quot;SpotPriceEUR&quot;: 114.910004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1088.459961,
            &quot;SpotPriceEUR&quot;: 146.300003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 807.900024,
            &quot;SpotPriceEUR&quot;: 108.589996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1045.900024,
            &quot;SpotPriceEUR&quot;: 140.580002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 807.900024,
            &quot;SpotPriceEUR&quot;: 108.589996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 807.900024,
            &quot;SpotPriceEUR&quot;: 108.589996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 875.900024,
            &quot;SpotPriceEUR&quot;: 117.730003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1139.050049,
            &quot;SpotPriceEUR&quot;: 153.100006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 925.450012,
            &quot;SpotPriceEUR&quot;: 124.389999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1102.52002,
            &quot;SpotPriceEUR&quot;: 148.190002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 892.789978,
            &quot;SpotPriceEUR&quot;: 120
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 925.450012,
            &quot;SpotPriceEUR&quot;: 124.389999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 893.380005,
            &quot;SpotPriceEUR&quot;: 120.080002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1125.51001,
            &quot;SpotPriceEUR&quot;: 151.279999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1024.030029,
            &quot;SpotPriceEUR&quot;: 137.639999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1054.380005,
            &quot;SpotPriceEUR&quot;: 141.720001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 669.440002,
            &quot;SpotPriceEUR&quot;: 89.980003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1024.030029,
            &quot;SpotPriceEUR&quot;: 137.639999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T10:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 876.200012,
            &quot;SpotPriceEUR&quot;: 117.769997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1084.890015,
            &quot;SpotPriceEUR&quot;: 145.820007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 900.150024,
            &quot;SpotPriceEUR&quot;: 120.989998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1032.430054,
            &quot;SpotPriceEUR&quot;: 138.770004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 594.75,
            &quot;SpotPriceEUR&quot;: 79.940002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 900.150024,
            &quot;SpotPriceEUR&quot;: 120.989998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T09:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 857.599976,
            &quot;SpotPriceEUR&quot;: 115.269997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1023.059998,
            &quot;SpotPriceEUR&quot;: 137.509995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 639.909973,
            &quot;SpotPriceEUR&quot;: 86.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 993.450012,
            &quot;SpotPriceEUR&quot;: 133.529999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 478.910004,
            &quot;SpotPriceEUR&quot;: 64.370003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 639.909973,
            &quot;SpotPriceEUR&quot;: 86.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T08:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 803.429993,
            &quot;SpotPriceEUR&quot;: 107.989998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 949.330017,
            &quot;SpotPriceEUR&quot;: 127.599998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 483,
            &quot;SpotPriceEUR&quot;: 64.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 921.650024,
            &quot;SpotPriceEUR&quot;: 123.879997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 483,
            &quot;SpotPriceEUR&quot;: 64.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 483,
            &quot;SpotPriceEUR&quot;: 64.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T07:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 774.869995,
            &quot;SpotPriceEUR&quot;: 104.150002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 949.330017,
            &quot;SpotPriceEUR&quot;: 127.599998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 456.959991,
            &quot;SpotPriceEUR&quot;: 61.419998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 921.950012,
            &quot;SpotPriceEUR&quot;: 123.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 456.959991,
            &quot;SpotPriceEUR&quot;: 61.419998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 456.959991,
            &quot;SpotPriceEUR&quot;: 61.419998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T06:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 755.299988,
            &quot;SpotPriceEUR&quot;: 101.519997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 876.349976,
            &quot;SpotPriceEUR&quot;: 117.790001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 465.660004,
            &quot;SpotPriceEUR&quot;: 62.59
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 876.349976,
            &quot;SpotPriceEUR&quot;: 117.790001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 465.660004,
            &quot;SpotPriceEUR&quot;: 62.59
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 465.660004,
            &quot;SpotPriceEUR&quot;: 62.59
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T05:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 711.630005,
            &quot;SpotPriceEUR&quot;: 95.650002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 908.559998,
            &quot;SpotPriceEUR&quot;: 122.120003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 520.869995,
            &quot;SpotPriceEUR&quot;: 70.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 882.219971,
            &quot;SpotPriceEUR&quot;: 118.580002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 520.869995,
            &quot;SpotPriceEUR&quot;: 70.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 520.869995,
            &quot;SpotPriceEUR&quot;: 70.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T04:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 732.309998,
            &quot;SpotPriceEUR&quot;: 98.43
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 880.51001,
            &quot;SpotPriceEUR&quot;: 118.349998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 531.580017,
            &quot;SpotPriceEUR&quot;: 71.449997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 880.51001,
            &quot;SpotPriceEUR&quot;: 118.349998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 531.580017,
            &quot;SpotPriceEUR&quot;: 71.449997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 531.580017,
            &quot;SpotPriceEUR&quot;: 71.449997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T03:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 735.580017,
            &quot;SpotPriceEUR&quot;: 98.870003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 868.76001,
            &quot;SpotPriceEUR&quot;: 116.769997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 543.559998,
            &quot;SpotPriceEUR&quot;: 73.059998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 868.76001,
            &quot;SpotPriceEUR&quot;: 116.769997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 543.559998,
            &quot;SpotPriceEUR&quot;: 73.059998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 543.559998,
            &quot;SpotPriceEUR&quot;: 73.059998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T02:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 731.419983,
            &quot;SpotPriceEUR&quot;: 98.309998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 885.419983,
            &quot;SpotPriceEUR&quot;: 119.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 589.02002,
            &quot;SpotPriceEUR&quot;: 79.169998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 885.419983,
            &quot;SpotPriceEUR&quot;: 119.010002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 589.02002,
            &quot;SpotPriceEUR&quot;: 79.169998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 589.02002,
            &quot;SpotPriceEUR&quot;: 79.169998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T01:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 748.75,
            &quot;SpotPriceEUR&quot;: 100.639999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 949.330017,
            &quot;SpotPriceEUR&quot;: 127.599998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 590.72998,
            &quot;SpotPriceEUR&quot;: 79.400002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 921.799988,
            &quot;SpotPriceEUR&quot;: 123.900002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 590.72998,
            &quot;SpotPriceEUR&quot;: 79.400002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 590.72998,
            &quot;SpotPriceEUR&quot;: 79.400002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-22T00:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 777.400024,
            &quot;SpotPriceEUR&quot;: 104.489998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 876.049988,
            &quot;SpotPriceEUR&quot;: 117.760002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 668.940002,
            &quot;SpotPriceEUR&quot;: 89.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 876.049988,
            &quot;SpotPriceEUR&quot;: 117.760002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 668.940002,
            &quot;SpotPriceEUR&quot;: 89.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 668.940002,
            &quot;SpotPriceEUR&quot;: 89.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T23:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 752.26001,
            &quot;SpotPriceEUR&quot;: 101.120003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 981.090027,
            &quot;SpotPriceEUR&quot;: 131.880005
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 802.469971,
            &quot;SpotPriceEUR&quot;: 107.870003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 952.599976,
            &quot;SpotPriceEUR&quot;: 128.050003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 802.469971,
            &quot;SpotPriceEUR&quot;: 107.870003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 802.469971,
            &quot;SpotPriceEUR&quot;: 107.870003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T22:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 799.280029,
            &quot;SpotPriceEUR&quot;: 107.440002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1012.039978,
            &quot;SpotPriceEUR&quot;: 136.039993
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 962.200012,
            &quot;SpotPriceEUR&quot;: 129.339996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 982.650024,
            &quot;SpotPriceEUR&quot;: 132.089996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 962.200012,
            &quot;SpotPriceEUR&quot;: 129.339996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 962.200012,
            &quot;SpotPriceEUR&quot;: 129.339996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T21:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 832.830017,
            &quot;SpotPriceEUR&quot;: 111.949997
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1030.560059,
            &quot;SpotPriceEUR&quot;: 138.529999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1000.659973,
            &quot;SpotPriceEUR&quot;: 134.509995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1000.659973,
            &quot;SpotPriceEUR&quot;: 134.509995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1000.659973,
            &quot;SpotPriceEUR&quot;: 134.509995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1000.659973,
            &quot;SpotPriceEUR&quot;: 134.509995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T20:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 858.640015,
            &quot;SpotPriceEUR&quot;: 115.419998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1067.680054,
            &quot;SpotPriceEUR&quot;: 143.520004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1042.089966,
            &quot;SpotPriceEUR&quot;: 140.080002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1039.410034,
            &quot;SpotPriceEUR&quot;: 139.720001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1042.089966,
            &quot;SpotPriceEUR&quot;: 140.080002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1042.089966,
            &quot;SpotPriceEUR&quot;: 140.080002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T19:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 930.359985,
            &quot;SpotPriceEUR&quot;: 125.059998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1330.810059,
            &quot;SpotPriceEUR&quot;: 178.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1330.810059,
            &quot;SpotPriceEUR&quot;: 178.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1289.599976,
            &quot;SpotPriceEUR&quot;: 173.350006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1298.900024,
            &quot;SpotPriceEUR&quot;: 174.600006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1298.900024,
            &quot;SpotPriceEUR&quot;: 174.600006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T18:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 997.22998,
            &quot;SpotPriceEUR&quot;: 134.050003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1293.839966,
            &quot;SpotPriceEUR&quot;: 173.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1293.839966,
            &quot;SpotPriceEUR&quot;: 173.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1256.27002,
            &quot;SpotPriceEUR&quot;: 168.869995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1293.839966,
            &quot;SpotPriceEUR&quot;: 173.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1293.839966,
            &quot;SpotPriceEUR&quot;: 173.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T17:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 1023.570007,
            &quot;SpotPriceEUR&quot;: 137.589996
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1072.890015,
            &quot;SpotPriceEUR&quot;: 144.220001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1072.890015,
            &quot;SpotPriceEUR&quot;: 144.220001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1039.790039,
            &quot;SpotPriceEUR&quot;: 139.770004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1047.150024,
            &quot;SpotPriceEUR&quot;: 140.759995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1047.150024,
            &quot;SpotPriceEUR&quot;: 140.759995
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T16:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 985.409973,
            &quot;SpotPriceEUR&quot;: 132.460007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1011,
            &quot;SpotPriceEUR&quot;: 135.899994
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1011,
            &quot;SpotPriceEUR&quot;: 135.899994
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 986.73999,
            &quot;SpotPriceEUR&quot;: 132.639999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 986.73999,
            &quot;SpotPriceEUR&quot;: 132.639999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 986.73999,
            &quot;SpotPriceEUR&quot;: 132.639999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T15:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 917.190002,
            &quot;SpotPriceEUR&quot;: 123.290001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1016.059998,
            &quot;SpotPriceEUR&quot;: 136.580002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1016.059998,
            &quot;SpotPriceEUR&quot;: 136.580002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 983.549988,
            &quot;SpotPriceEUR&quot;: 132.210007
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 976.179993,
            &quot;SpotPriceEUR&quot;: 131.220001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 976.179993,
            &quot;SpotPriceEUR&quot;: 131.220001
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T14:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 913.390015,
            &quot;SpotPriceEUR&quot;: 122.779999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1019.330017,
            &quot;SpotPriceEUR&quot;: 137.020004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1019.330017,
            &quot;SpotPriceEUR&quot;: 137.020004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 989.789978,
            &quot;SpotPriceEUR&quot;: 133.050003
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 974.98999,
            &quot;SpotPriceEUR&quot;: 131.059998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 974.98999,
            &quot;SpotPriceEUR&quot;: 131.059998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T13:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 915.030029,
            &quot;SpotPriceEUR&quot;: 123
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1100.339966,
            &quot;SpotPriceEUR&quot;: 147.910004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1100.339966,
            &quot;SpotPriceEUR&quot;: 147.910004
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1063,
            &quot;SpotPriceEUR&quot;: 142.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1063,
            &quot;SpotPriceEUR&quot;: 142.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1063,
            &quot;SpotPriceEUR&quot;: 142.889999
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T12:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 988.309998,
            &quot;SpotPriceEUR&quot;: 132.850006
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK1&quot;,
            &quot;SpotPriceDKK&quot;: 1167.52002,
            &quot;SpotPriceEUR&quot;: 156.940002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;DK2&quot;,
            &quot;SpotPriceDKK&quot;: 1167.52002,
            &quot;SpotPriceEUR&quot;: 156.940002
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;NO2&quot;,
            &quot;SpotPriceDKK&quot;: 1130.170044,
            &quot;SpotPriceEUR&quot;: 151.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE3&quot;,
            &quot;SpotPriceDKK&quot;: 1130.170044,
            &quot;SpotPriceEUR&quot;: 151.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SE4&quot;,
            &quot;SpotPriceDKK&quot;: 1130.170044,
            &quot;SpotPriceEUR&quot;: 151.919998
        },
        {
            &quot;HourUTC&quot;: &quot;2023-01-21T10:00:00&quot;,
            &quot;HourDK&quot;: &quot;2023-01-21T11:00:00&quot;,
            &quot;PriceArea&quot;: &quot;SYSTEM&quot;,
            &quot;SpotPriceDKK&quot;: 1010.77002,
            &quot;SpotPriceEUR&quot;: 135.869995
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el-Elspotprices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el-Elspotprices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el-Elspotprices" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el-Elspotprices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el-Elspotprices"></code></pre>
</span>
<form id="form-GETapi-el-Elspotprices" data-method="GET"
      data-path="api/el/Elspotprices"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el-Elspotprices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el-Elspotprices"
                    onclick="tryItOut('GETapi-el-Elspotprices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el-Elspotprices"
                    onclick="cancelTryOut('GETapi-el-Elspotprices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el-Elspotprices" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/Elspotprices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el-Elspotprices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el-Elspotprices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-el--refreshToken-">GET api/el/{refreshToken}</h2>

<p>
</p>



<span id="example-requests-GETapi-el--refreshToken-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/veniam" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/veniam"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el--refreshToken-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 57
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Attempt to read property \&quot;metering_point_id\&quot; on null&quot;,
    &quot;exception&quot;: &quot;ErrorException&quot;,
    &quot;file&quot;: &quot;/var/www/html/app/Services/GetMeteringData.php&quot;,
    &quot;line&quot;: 228,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php&quot;,
            &quot;line&quot;: 266,
            &quot;function&quot;: &quot;handleError&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetMeteringData.php&quot;,
            &quot;line&quot;: 228,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetPreliminaryInvoice.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;getCharges&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetMeteringData&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 408,
            &quot;function&quot;: &quot;getBill&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetPreliminaryInvoice&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 306,
            &quot;function&quot;: &quot;getPreliminaryInvoice&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el--refreshToken-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el--refreshToken-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el--refreshToken-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el--refreshToken-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el--refreshToken-"></code></pre>
</span>
<form id="form-GETapi-el--refreshToken-" data-method="GET"
      data-path="api/el/{refreshToken}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el--refreshToken-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el--refreshToken-"
                    onclick="tryItOut('GETapi-el--refreshToken-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el--refreshToken-"
                    onclick="cancelTryOut('GETapi-el--refreshToken-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el--refreshToken-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/{refreshToken}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el--refreshToken-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el--refreshToken-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refreshToken</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="refreshToken"                data-endpoint="GETapi-el--refreshToken-"
               value="veniam"
               data-component="url">
    <br>
<p>Example: <code>veniam</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-el--refreshToken--smartme">GET api/el/{refreshToken}/smartme</h2>

<p>
</p>



<span id="example-requests-GETapi-el--refreshToken--smartme">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/totam/smartme" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/totam/smartme"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el--refreshToken--smartme">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 56
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Undefined array key \&quot;CounterReading\&quot;&quot;,
    &quot;exception&quot;: &quot;ErrorException&quot;,
    &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Http/Client/Response.php&quot;,
    &quot;line&quot;: 372,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php&quot;,
            &quot;line&quot;: 266,
            &quot;function&quot;: &quot;handleError&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Http/Client/Response.php&quot;,
            &quot;line&quot;: 372,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetSmartMeMeterData.php&quot;,
            &quot;line&quot;: 30,
            &quot;function&quot;: &quot;offsetGet&quot;,
            &quot;class&quot;: &quot;Illuminate\\Http\\Client\\Response&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetSmartMeMeterData.php&quot;,
            &quot;line&quot;: 61,
            &quot;function&quot;: &quot;getFromDate&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetSmartMeMeterData&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetPreliminaryInvoice.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;getInterval&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetSmartMeMeterData&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 408,
            &quot;function&quot;: &quot;getBill&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetPreliminaryInvoice&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 320,
            &quot;function&quot;: &quot;getPreliminaryInvoice&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;getWithSmartMe&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el--refreshToken--smartme" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el--refreshToken--smartme"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el--refreshToken--smartme" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el--refreshToken--smartme" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el--refreshToken--smartme"></code></pre>
</span>
<form id="form-GETapi-el--refreshToken--smartme" data-method="GET"
      data-path="api/el/{refreshToken}/smartme"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el--refreshToken--smartme', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el--refreshToken--smartme"
                    onclick="tryItOut('GETapi-el--refreshToken--smartme');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el--refreshToken--smartme"
                    onclick="cancelTryOut('GETapi-el--refreshToken--smartme');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el--refreshToken--smartme" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/{refreshToken}/smartme</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el--refreshToken--smartme"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el--refreshToken--smartme"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refreshToken</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="refreshToken"                data-endpoint="GETapi-el--refreshToken--smartme"
               value="totam"
               data-component="url">
    <br>
<p>Example: <code>totam</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-el-charges--refreshToken-">GET api/el/charges/{refreshToken}</h2>

<p>
</p>



<span id="example-requests-GETapi-el-charges--refreshToken-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/charges/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/charges/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el-charges--refreshToken-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 55
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Attempt to read property \&quot;metering_point_id\&quot; on null&quot;,
    &quot;exception&quot;: &quot;ErrorException&quot;,
    &quot;file&quot;: &quot;/var/www/html/app/Services/GetMeteringData.php&quot;,
    &quot;line&quot;: 228,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php&quot;,
            &quot;line&quot;: 266,
            &quot;function&quot;: &quot;handleError&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetMeteringData.php&quot;,
            &quot;line&quot;: 228,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Bootstrap\\HandleExceptions&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 435,
            &quot;function&quot;: &quot;getCharges&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetMeteringData&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;getCharges&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el-charges--refreshToken-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el-charges--refreshToken-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el-charges--refreshToken-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el-charges--refreshToken-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el-charges--refreshToken-"></code></pre>
</span>
<form id="form-GETapi-el-charges--refreshToken-" data-method="GET"
      data-path="api/el/charges/{refreshToken}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el-charges--refreshToken-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el-charges--refreshToken-"
                    onclick="tryItOut('GETapi-el-charges--refreshToken-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el-charges--refreshToken-"
                    onclick="cancelTryOut('GETapi-el-charges--refreshToken-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el-charges--refreshToken-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/charges/{refreshToken}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el-charges--refreshToken-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el-charges--refreshToken-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refreshToken</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="refreshToken"                data-endpoint="GETapi-el-charges--refreshToken-"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-el--start_date---end_date---price_area---refreshToken-">GET api/el/{start_date}/{end_date}/{price_area}/{refreshToken}</h2>

<p>
</p>



<span id="example-requests-GETapi-el--start_date---end_date---price_area---refreshToken-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/dolorum/numquam/in/non" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/dolorum/numquam/in/non"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el--start_date---end_date---price_area---refreshToken-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 54
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Could not parse &#039;numquam&#039;: Failed to parse time string (numquam) at position 0 (n): The timezone could not be found in the database&quot;,
    &quot;exception&quot;: &quot;Carbon\\Exceptions\\InvalidFormatException&quot;,
    &quot;file&quot;: &quot;/var/www/html/vendor/nesbot/carbon/src/Carbon/Traits/Creator.php&quot;,
    &quot;line&quot;: 190,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/nesbot/carbon/src/Carbon/Traits/Creator.php&quot;,
            &quot;line&quot;: 216,
            &quot;function&quot;: &quot;rawParse&quot;,
            &quot;class&quot;: &quot;Carbon\\Carbon&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Services/GetPreliminaryInvoice.php&quot;,
            &quot;line&quot;: 64,
            &quot;function&quot;: &quot;parse&quot;,
            &quot;class&quot;: &quot;Carbon\\Carbon&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 408,
            &quot;function&quot;: &quot;getBill&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetPreliminaryInvoice&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/ElController.php&quot;,
            &quot;line&quot;: 348,
            &quot;function&quot;: &quot;getPreliminaryInvoice&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;getFromDate&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\ElController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el--start_date---end_date---price_area---refreshToken-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el--start_date---end_date---price_area---refreshToken-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el--start_date---end_date---price_area---refreshToken-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el--start_date---end_date---price_area---refreshToken-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el--start_date---end_date---price_area---refreshToken-"></code></pre>
</span>
<form id="form-GETapi-el--start_date---end_date---price_area---refreshToken-" data-method="GET"
      data-path="api/el/{start_date}/{end_date}/{price_area}/{refreshToken}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el--start_date---end_date---price_area---refreshToken-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el--start_date---end_date---price_area---refreshToken-"
                    onclick="tryItOut('GETapi-el--start_date---end_date---price_area---refreshToken-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el--start_date---end_date---price_area---refreshToken-"
                    onclick="cancelTryOut('GETapi-el--start_date---end_date---price_area---refreshToken-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el--start_date---end_date---price_area---refreshToken-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/{start_date}/{end_date}/{price_area}/{refreshToken}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el--start_date---end_date---price_area---refreshToken-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el--start_date---end_date---price_area---refreshToken-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>start_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="start_date"                data-endpoint="GETapi-el--start_date---end_date---price_area---refreshToken-"
               value="dolorum"
               data-component="url">
    <br>
<p>Example: <code>dolorum</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>end_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="end_date"                data-endpoint="GETapi-el--start_date---end_date---price_area---refreshToken-"
               value="numquam"
               data-component="url">
    <br>
<p>Example: <code>numquam</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>price_area</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="price_area"                data-endpoint="GETapi-el--start_date---end_date---price_area---refreshToken-"
               value="in"
               data-component="url">
    <br>
<p>Example: <code>in</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refreshToken</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="refreshToken"                data-endpoint="GETapi-el--start_date---end_date---price_area---refreshToken-"
               value="non"
               data-component="url">
    <br>
<p>Example: <code>non</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-el--refreshToken--delete">GET api/el/{refreshToken}/delete</h2>

<p>
</p>



<span id="example-requests-GETapi-el--refreshToken--delete">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/el/eum/delete" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/el/eum/delete"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-el--refreshToken--delete">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: text/plain; charset=UTF-8
x-ratelimit-limit: 60
x-ratelimit-remaining: 53
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">Data access-token not found</code>
 </pre>
    </span>
<span id="execution-results-GETapi-el--refreshToken--delete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-el--refreshToken--delete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-el--refreshToken--delete" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-el--refreshToken--delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-el--refreshToken--delete"></code></pre>
</span>
<form id="form-GETapi-el--refreshToken--delete" data-method="GET"
      data-path="api/el/{refreshToken}/delete"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-el--refreshToken--delete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-el--refreshToken--delete"
                    onclick="tryItOut('GETapi-el--refreshToken--delete');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-el--refreshToken--delete"
                    onclick="cancelTryOut('GETapi-el--refreshToken--delete');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-el--refreshToken--delete" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/el/{refreshToken}/delete</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-el--refreshToken--delete"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-el--refreshToken--delete"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refreshToken</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="refreshToken"                data-endpoint="GETapi-el--refreshToken--delete"
               value="eum"
               data-component="url">
    <br>
<p>Example: <code>eum</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-meteringPoint--refresh_token--">Display a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-meteringPoint--refresh_token--">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/meteringPoint/quis" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/meteringPoint/quis"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-meteringPoint--refresh_token--">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 52
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;When retrieving data from POWERUSE, user must be provided&quot;,
    &quot;exception&quot;: &quot;InvalidArgumentException&quot;,
    &quot;file&quot;: &quot;/var/www/html/app/Services/GetMeteringData.php&quot;,
    &quot;line&quot;: 170,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/Api/MeteringPointController.php&quot;,
            &quot;line&quot;: 61,
            &quot;function&quot;: &quot;getMeteringPointData&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetMeteringData&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;index&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\MeteringPointController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-meteringPoint--refresh_token--" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-meteringPoint--refresh_token--"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-meteringPoint--refresh_token--" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-meteringPoint--refresh_token--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-meteringPoint--refresh_token--"></code></pre>
</span>
<form id="form-GETapi-meteringPoint--refresh_token--" data-method="GET"
      data-path="api/meteringPoint/{refresh_token?}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-meteringPoint--refresh_token--', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-meteringPoint--refresh_token--"
                    onclick="tryItOut('GETapi-meteringPoint--refresh_token--');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-meteringPoint--refresh_token--"
                    onclick="cancelTryOut('GETapi-meteringPoint--refresh_token--');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-meteringPoint--refresh_token--" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/meteringPoint/{refresh_token?}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-meteringPoint--refresh_token--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-meteringPoint--refresh_token--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refresh_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="refresh_token"                data-endpoint="GETapi-meteringPoint--refresh_token--"
               value="quis"
               data-component="url">
    <br>
<p>Example: <code>quis</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-meteringPoint">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-meteringPoint">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/meteringPoint" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"metering_point_id\": \"zftzmebpz\",
    \"parent_id\": \"wyxebblwdutf\",
    \"type_of_mp\": \"n\",
    \"settlement_method\": \"d\",
    \"meter_number\": \"msaq\",
    \"consumer_c_v_r\": \"lrrxpt\",
    \"data_access_c_v_r\": \"iv\",
    \"consumer_start_date\": \"2023-01-21T22:49:49\",
    \"meter_reading_occurrence\": \"glml\",
    \"balance_supplier_name\": \"quam\",
    \"street_code\": \"plf\",
    \"street_name\": \"hhvgndnuzhiygpanajkr\",
    \"building_number\": \"ziwgeg\",
    \"floor_id\": \"gcv\",
    \"room_id\": \"lox\",
    \"city_name\": \"mnzqtlhof\",
    \"city_sub_division_name\": \"qqaybrapvfuz\",
    \"municipality_code\": \"pzi\",
    \"location_description\": \"pimstxtgz\",
    \"first_consumer_party_name\": \"assnyazdhkvkqcsmufth\",
    \"second_consumer_party_name\": \"zk\",
    \"hasRelation\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/meteringPoint"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "metering_point_id": "zftzmebpz",
    "parent_id": "wyxebblwdutf",
    "type_of_mp": "n",
    "settlement_method": "d",
    "meter_number": "msaq",
    "consumer_c_v_r": "lrrxpt",
    "data_access_c_v_r": "iv",
    "consumer_start_date": "2023-01-21T22:49:49",
    "meter_reading_occurrence": "glml",
    "balance_supplier_name": "quam",
    "street_code": "plf",
    "street_name": "hhvgndnuzhiygpanajkr",
    "building_number": "ziwgeg",
    "floor_id": "gcv",
    "room_id": "lox",
    "city_name": "mnzqtlhof",
    "city_sub_division_name": "qqaybrapvfuz",
    "municipality_code": "pzi",
    "location_description": "pimstxtgz",
    "first_consumer_party_name": "assnyazdhkvkqcsmufth",
    "second_consumer_party_name": "zk",
    "hasRelation": false
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-meteringPoint">
</span>
<span id="execution-results-POSTapi-meteringPoint" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-meteringPoint"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-meteringPoint" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-meteringPoint" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-meteringPoint"></code></pre>
</span>
<form id="form-POSTapi-meteringPoint" data-method="POST"
      data-path="api/meteringPoint"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-meteringPoint', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-meteringPoint"
                    onclick="tryItOut('POSTapi-meteringPoint');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-meteringPoint"
                    onclick="cancelTryOut('POSTapi-meteringPoint');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-meteringPoint" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/meteringPoint</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="POSTapi-meteringPoint"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="POSTapi-meteringPoint"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>metering_point_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="metering_point_id"                data-endpoint="POSTapi-meteringPoint"
               value="zftzmebpz"
               data-component="body">
    <br>
<p>Must not be greater than 18 characters. Example: <code>zftzmebpz</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>parent_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="parent_id"                data-endpoint="POSTapi-meteringPoint"
               value="wyxebblwdutf"
               data-component="body">
    <br>
<p>Must not be greater than 18 characters. Example: <code>wyxebblwdutf</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type_of_mp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="type_of_mp"                data-endpoint="POSTapi-meteringPoint"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 3 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>settlement_method</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="settlement_method"                data-endpoint="POSTapi-meteringPoint"
               value="d"
               data-component="body">
    <br>
<p>Must not be greater than 3 characters. Example: <code>d</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>meter_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="meter_number"                data-endpoint="POSTapi-meteringPoint"
               value="msaq"
               data-component="body">
    <br>
<p>Must not be greater than 15 characters. Example: <code>msaq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>consumer_c_v_r</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="consumer_c_v_r"                data-endpoint="POSTapi-meteringPoint"
               value="lrrxpt"
               data-component="body">
    <br>
<p>Must not be greater than 10 characters. Example: <code>lrrxpt</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>data_access_c_v_r</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="data_access_c_v_r"                data-endpoint="POSTapi-meteringPoint"
               value="iv"
               data-component="body">
    <br>
<p>Must not be greater than 10 characters. Example: <code>iv</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>consumer_start_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="consumer_start_date"                data-endpoint="POSTapi-meteringPoint"
               value="2023-01-21T22:49:49"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2023-01-21T22:49:49</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>meter_reading_occurrence</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="meter_reading_occurrence"                data-endpoint="POSTapi-meteringPoint"
               value="glml"
               data-component="body">
    <br>
<p>Must not be greater than 5 characters. Example: <code>glml</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>balance_supplier_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="balance_supplier_name"                data-endpoint="POSTapi-meteringPoint"
               value="quam"
               data-component="body">
    <br>
<p>Example: <code>quam</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>street_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="street_code"                data-endpoint="POSTapi-meteringPoint"
               value="plf"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>plf</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>street_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="street_name"                data-endpoint="POSTapi-meteringPoint"
               value="hhvgndnuzhiygpanajkr"
               data-component="body">
    <br>
<p>Must not be greater than 40 characters. Example: <code>hhvgndnuzhiygpanajkr</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>building_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="building_number"                data-endpoint="POSTapi-meteringPoint"
               value="ziwgeg"
               data-component="body">
    <br>
<p>Must not be greater than 6 characters. Example: <code>ziwgeg</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>floor_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="floor_id"                data-endpoint="POSTapi-meteringPoint"
               value="gcv"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>gcv</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>room_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="room_id"                data-endpoint="POSTapi-meteringPoint"
               value="lox"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>lox</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="city_name"                data-endpoint="POSTapi-meteringPoint"
               value="mnzqtlhof"
               data-component="body">
    <br>
<p>Must not be greater than 25 characters. Example: <code>mnzqtlhof</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_sub_division_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="city_sub_division_name"                data-endpoint="POSTapi-meteringPoint"
               value="qqaybrapvfuz"
               data-component="body">
    <br>
<p>Must not be greater than 34 characters. Example: <code>qqaybrapvfuz</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>municipality_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="municipality_code"                data-endpoint="POSTapi-meteringPoint"
               value="pzi"
               data-component="body">
    <br>
<p>Must not be greater than 3 characters. Example: <code>pzi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location_description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="location_description"                data-endpoint="POSTapi-meteringPoint"
               value="pimstxtgz"
               data-component="body">
    <br>
<p>Must not be greater than 132 characters. Example: <code>pimstxtgz</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_consumer_party_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="first_consumer_party_name"                data-endpoint="POSTapi-meteringPoint"
               value="assnyazdhkvkqcsmufth"
               data-component="body">
    <br>
<p>Must not be greater than 132 characters. Example: <code>assnyazdhkvkqcsmufth</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>second_consumer_party_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="second_consumer_party_name"                data-endpoint="POSTapi-meteringPoint"
               value="zk"
               data-component="body">
    <br>
<p>Must not be greater than 132 characters. Example: <code>zk</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>hasRelation</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-meteringPoint" style="display: none">
            <input type="radio" name="hasRelation"
                   value="true"
                   data-endpoint="POSTapi-meteringPoint"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-meteringPoint" style="display: none">
            <input type="radio" name="hasRelation"
                   value="false"
                   data-endpoint="POSTapi-meteringPoint"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-meteringPoint--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-meteringPoint--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/meteringPoint/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/meteringPoint/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-meteringPoint--id-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 51
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;When retrieving data from POWERUSE, user must be provided&quot;,
    &quot;exception&quot;: &quot;InvalidArgumentException&quot;,
    &quot;file&quot;: &quot;/var/www/html/app/Services/GetMeteringData.php&quot;,
    &quot;line&quot;: 170,
    &quot;trace&quot;: [
        {
            &quot;file&quot;: &quot;/var/www/html/app/Http/Controllers/Api/MeteringPointController.php&quot;,
            &quot;line&quot;: 61,
            &quot;function&quot;: &quot;getMeteringPointData&quot;,
            &quot;class&quot;: &quot;App\\Services\\GetMeteringData&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php&quot;,
            &quot;line&quot;: 54,
            &quot;function&quot;: &quot;index&quot;,
            &quot;class&quot;: &quot;App\\Http\\Controllers\\Api\\MeteringPointController&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php&quot;,
            &quot;line&quot;: 43,
            &quot;function&quot;: &quot;callAction&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Controller&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 260,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\ControllerDispatcher&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php&quot;,
            &quot;line&quot;: 205,
            &quot;function&quot;: &quot;runController&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 798,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Route&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Routing\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php&quot;,
            &quot;line&quot;: 50,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\SubstituteBindings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 126,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php&quot;,
            &quot;line&quot;: 62,
            &quot;function&quot;: &quot;handleRequest&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Middleware\\ThrottleRequests&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 799,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 776,
            &quot;function&quot;: &quot;runRouteWithinStack&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 740,
            &quot;function&quot;: &quot;runRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php&quot;,
            &quot;line&quot;: 729,
            &quot;function&quot;: &quot;dispatchToRoute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 190,
            &quot;function&quot;: &quot;dispatch&quot;,
            &quot;class&quot;: &quot;Illuminate\\Routing\\Router&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 141,
            &quot;function&quot;: &quot;Illuminate\\Foundation\\Http\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/fideloper/proxy/src/TrustProxies.php&quot;,
            &quot;line&quot;: 57,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Fideloper\\Proxy\\TrustProxies&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php&quot;,
            &quot;line&quot;: 31,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php&quot;,
            &quot;line&quot;: 21,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php&quot;,
            &quot;line&quot;: 40,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\TrimStrings&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php&quot;,
            &quot;line&quot;: 27,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php&quot;,
            &quot;line&quot;: 86,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 180,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php&quot;,
            &quot;line&quot;: 116,
            &quot;function&quot;: &quot;Illuminate\\Pipeline\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 165,
            &quot;function&quot;: &quot;then&quot;,
            &quot;class&quot;: &quot;Illuminate\\Pipeline\\Pipeline&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php&quot;,
            &quot;line&quot;: 134,
            &quot;function&quot;: &quot;sendRequestThroughRouter&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 299,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Http\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 287,
            &quot;function&quot;: &quot;callLaravelOrLumenRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 92,
            &quot;function&quot;: &quot;makeApiCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 45,
            &quot;function&quot;: &quot;makeResponseCall&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Strategies/Responses/ResponseCalls.php&quot;,
            &quot;line&quot;: 35,
            &quot;function&quot;: &quot;makeResponseCallIfConditionsPass&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 209,
            &quot;function&quot;: &quot;__invoke&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Strategies\\Responses\\ResponseCalls&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 166,
            &quot;function&quot;: &quot;iterateThroughStrategies&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Extracting/Extractor.php&quot;,
            &quot;line&quot;: 95,
            &quot;function&quot;: &quot;fetchResponses&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 122,
            &quot;function&quot;: &quot;processRoute&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Extracting\\Extractor&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 69,
            &quot;function&quot;: &quot;extractEndpointsInfoFromLaravelApp&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/GroupedEndpoints/GroupedEndpointsFromApp.php&quot;,
            &quot;line&quot;: 47,
            &quot;function&quot;: &quot;extractEndpointsInfoAndWriteToDisk&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/knuckleswtf/scribe/src/Commands/GenerateDocumentation.php&quot;,
            &quot;line&quot;: 51,
            &quot;function&quot;: &quot;get&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\GroupedEndpoints\\GroupedEndpointsFromApp&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 36,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Knuckles\\Scribe\\Commands\\GenerateDocumentation&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Util.php&quot;,
            &quot;line&quot;: 41,
            &quot;function&quot;: &quot;Illuminate\\Container\\{closure}&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 93,
            &quot;function&quot;: &quot;unwrapIfClosure&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Util&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;callBoundMethod&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Container/Container.php&quot;,
            &quot;line&quot;: 663,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\BoundMethod&quot;,
            &quot;type&quot;: &quot;::&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 182,
            &quot;function&quot;: &quot;call&quot;,
            &quot;class&quot;: &quot;Illuminate\\Container\\Container&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Command/Command.php&quot;,
            &quot;line&quot;: 312,
            &quot;function&quot;: &quot;execute&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Command.php&quot;,
            &quot;line&quot;: 152,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Command\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 1022,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Command&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 314,
            &quot;function&quot;: &quot;doRunCommand&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/symfony/console/Application.php&quot;,
            &quot;line&quot;: 168,
            &quot;function&quot;: &quot;doRun&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Console/Application.php&quot;,
            &quot;line&quot;: 102,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Symfony\\Component\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php&quot;,
            &quot;line&quot;: 155,
            &quot;function&quot;: &quot;run&quot;,
            &quot;class&quot;: &quot;Illuminate\\Console\\Application&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        },
        {
            &quot;file&quot;: &quot;/var/www/html/artisan&quot;,
            &quot;line&quot;: 37,
            &quot;function&quot;: &quot;handle&quot;,
            &quot;class&quot;: &quot;Illuminate\\Foundation\\Console\\Kernel&quot;,
            &quot;type&quot;: &quot;-&gt;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-meteringPoint--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-meteringPoint--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-meteringPoint--id-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-meteringPoint--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-meteringPoint--id-"></code></pre>
</span>
<form id="form-GETapi-meteringPoint--id-" data-method="GET"
      data-path="api/meteringPoint/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-meteringPoint--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-meteringPoint--id-"
                    onclick="tryItOut('GETapi-meteringPoint--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-meteringPoint--id-"
                    onclick="cancelTryOut('GETapi-meteringPoint--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-meteringPoint--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/meteringPoint/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-meteringPoint--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-meteringPoint--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="id"                data-endpoint="GETapi-meteringPoint--id-"
               value="4"
               data-component="url">
    <br>
<p>The ID of the meteringPoint. Example: <code>4</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-meteringPoint--id-">Update the specified resource in storage.</h2>

<p>
</p>



<span id="example-requests-PUTapi-meteringPoint--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/meteringPoint/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"metering_point_id\": \"ept\",
    \"parent_id\": \"cunlcrwnepbjoo\",
    \"type_of_mp\": \"i\",
    \"settlement_method\": \"y\",
    \"meter_number\": \"dk\",
    \"consumer_c_v_r\": \"usweiyuj\",
    \"data_access_c_v_r\": \"bnny\",
    \"consumer_start_date\": \"2023-01-21T22:49:49\",
    \"meter_reading_occurrence\": \"rrdip\",
    \"balance_supplier_name\": \"officia\",
    \"street_code\": \"j\",
    \"street_name\": \"gapachjpjcfl\",
    \"building_number\": \"xxoih\",
    \"floor_id\": \"tgd\",
    \"room_id\": \"lglv\",
    \"city_name\": \"mxahddnb\",
    \"city_sub_division_name\": \"taydylgxw\",
    \"municipality_code\": \"tp\",
    \"location_description\": \"qhlqzslrdfwzhclrtvnzzrey\",
    \"first_consumer_party_name\": \"ziantmv\",
    \"second_consumer_party_name\": \"vmihp\",
    \"hasRelation\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/meteringPoint/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "metering_point_id": "ept",
    "parent_id": "cunlcrwnepbjoo",
    "type_of_mp": "i",
    "settlement_method": "y",
    "meter_number": "dk",
    "consumer_c_v_r": "usweiyuj",
    "data_access_c_v_r": "bnny",
    "consumer_start_date": "2023-01-21T22:49:49",
    "meter_reading_occurrence": "rrdip",
    "balance_supplier_name": "officia",
    "street_code": "j",
    "street_name": "gapachjpjcfl",
    "building_number": "xxoih",
    "floor_id": "tgd",
    "room_id": "lglv",
    "city_name": "mxahddnb",
    "city_sub_division_name": "taydylgxw",
    "municipality_code": "tp",
    "location_description": "qhlqzslrdfwzhclrtvnzzrey",
    "first_consumer_party_name": "ziantmv",
    "second_consumer_party_name": "vmihp",
    "hasRelation": false
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-meteringPoint--id-">
</span>
<span id="execution-results-PUTapi-meteringPoint--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-meteringPoint--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-meteringPoint--id-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-meteringPoint--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-meteringPoint--id-"></code></pre>
</span>
<form id="form-PUTapi-meteringPoint--id-" data-method="PUT"
      data-path="api/meteringPoint/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-meteringPoint--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-meteringPoint--id-"
                    onclick="tryItOut('PUTapi-meteringPoint--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-meteringPoint--id-"
                    onclick="cancelTryOut('PUTapi-meteringPoint--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-meteringPoint--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/meteringPoint/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/meteringPoint/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="PUTapi-meteringPoint--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="PUTapi-meteringPoint--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="id"                data-endpoint="PUTapi-meteringPoint--id-"
               value="4"
               data-component="url">
    <br>
<p>The ID of the meteringPoint. Example: <code>4</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>metering_point_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="metering_point_id"                data-endpoint="PUTapi-meteringPoint--id-"
               value="ept"
               data-component="body">
    <br>
<p>Must not be greater than 18 characters. Example: <code>ept</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>parent_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="parent_id"                data-endpoint="PUTapi-meteringPoint--id-"
               value="cunlcrwnepbjoo"
               data-component="body">
    <br>
<p>Must not be greater than 18 characters. Example: <code>cunlcrwnepbjoo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type_of_mp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="type_of_mp"                data-endpoint="PUTapi-meteringPoint--id-"
               value="i"
               data-component="body">
    <br>
<p>Must not be greater than 3 characters. Example: <code>i</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>settlement_method</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="settlement_method"                data-endpoint="PUTapi-meteringPoint--id-"
               value="y"
               data-component="body">
    <br>
<p>Must not be greater than 3 characters. Example: <code>y</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>meter_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="meter_number"                data-endpoint="PUTapi-meteringPoint--id-"
               value="dk"
               data-component="body">
    <br>
<p>Must not be greater than 15 characters. Example: <code>dk</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>consumer_c_v_r</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="consumer_c_v_r"                data-endpoint="PUTapi-meteringPoint--id-"
               value="usweiyuj"
               data-component="body">
    <br>
<p>Must not be greater than 10 characters. Example: <code>usweiyuj</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>data_access_c_v_r</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="data_access_c_v_r"                data-endpoint="PUTapi-meteringPoint--id-"
               value="bnny"
               data-component="body">
    <br>
<p>Must not be greater than 10 characters. Example: <code>bnny</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>consumer_start_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="consumer_start_date"                data-endpoint="PUTapi-meteringPoint--id-"
               value="2023-01-21T22:49:49"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2023-01-21T22:49:49</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>meter_reading_occurrence</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="meter_reading_occurrence"                data-endpoint="PUTapi-meteringPoint--id-"
               value="rrdip"
               data-component="body">
    <br>
<p>Must not be greater than 5 characters. Example: <code>rrdip</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>balance_supplier_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="balance_supplier_name"                data-endpoint="PUTapi-meteringPoint--id-"
               value="officia"
               data-component="body">
    <br>
<p>Example: <code>officia</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>street_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="street_code"                data-endpoint="PUTapi-meteringPoint--id-"
               value="j"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>j</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>street_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="street_name"                data-endpoint="PUTapi-meteringPoint--id-"
               value="gapachjpjcfl"
               data-component="body">
    <br>
<p>Must not be greater than 40 characters. Example: <code>gapachjpjcfl</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>building_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="building_number"                data-endpoint="PUTapi-meteringPoint--id-"
               value="xxoih"
               data-component="body">
    <br>
<p>Must not be greater than 6 characters. Example: <code>xxoih</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>floor_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="floor_id"                data-endpoint="PUTapi-meteringPoint--id-"
               value="tgd"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>tgd</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>room_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="room_id"                data-endpoint="PUTapi-meteringPoint--id-"
               value="lglv"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>lglv</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="city_name"                data-endpoint="PUTapi-meteringPoint--id-"
               value="mxahddnb"
               data-component="body">
    <br>
<p>Must not be greater than 25 characters. Example: <code>mxahddnb</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_sub_division_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="city_sub_division_name"                data-endpoint="PUTapi-meteringPoint--id-"
               value="taydylgxw"
               data-component="body">
    <br>
<p>Must not be greater than 34 characters. Example: <code>taydylgxw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>municipality_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="municipality_code"                data-endpoint="PUTapi-meteringPoint--id-"
               value="tp"
               data-component="body">
    <br>
<p>Must not be greater than 3 characters. Example: <code>tp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location_description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="location_description"                data-endpoint="PUTapi-meteringPoint--id-"
               value="qhlqzslrdfwzhclrtvnzzrey"
               data-component="body">
    <br>
<p>Must not be greater than 132 characters. Example: <code>qhlqzslrdfwzhclrtvnzzrey</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_consumer_party_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="first_consumer_party_name"                data-endpoint="PUTapi-meteringPoint--id-"
               value="ziantmv"
               data-component="body">
    <br>
<p>Must not be greater than 132 characters. Example: <code>ziantmv</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>second_consumer_party_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="second_consumer_party_name"                data-endpoint="PUTapi-meteringPoint--id-"
               value="vmihp"
               data-component="body">
    <br>
<p>Must not be greater than 132 characters. Example: <code>vmihp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>hasRelation</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-meteringPoint--id-" style="display: none">
            <input type="radio" name="hasRelation"
                   value="true"
                   data-endpoint="PUTapi-meteringPoint--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-meteringPoint--id-" style="display: none">
            <input type="radio" name="hasRelation"
                   value="false"
                   data-endpoint="PUTapi-meteringPoint--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-meteringPoint--id-">Remove the specified resource from storage.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-meteringPoint--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/meteringPoint/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/meteringPoint/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-meteringPoint--id-">
</span>
<span id="execution-results-DELETEapi-meteringPoint--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-meteringPoint--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-meteringPoint--id-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-meteringPoint--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-meteringPoint--id-"></code></pre>
</span>
<form id="form-DELETEapi-meteringPoint--id-" data-method="DELETE"
      data-path="api/meteringPoint/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-meteringPoint--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-meteringPoint--id-"
                    onclick="tryItOut('DELETEapi-meteringPoint--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-meteringPoint--id-"
                    onclick="cancelTryOut('DELETEapi-meteringPoint--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-meteringPoint--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/meteringPoint/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="DELETEapi-meteringPoint--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="DELETEapi-meteringPoint--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="id"                data-endpoint="DELETEapi-meteringPoint--id-"
               value="4"
               data-component="url">
    <br>
<p>The ID of the meteringPoint. Example: <code>4</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-charge--refresh_token--">isplay a listing of the resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-charge--refresh_token--">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/charge/deleniti" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/charge/deleniti"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-charge--refresh_token--">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 50
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        [
            {
                &quot;price&quot;: 21,
                &quot;quantity&quot;: 1,
                &quot;name&quot;: &quot;Netabo C forbrug skabelon/flex&quot;,
                &quot;description&quot;: &quot;Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en &aring;rsafl&aelig;st m&aring;ler&quot;,
                &quot;owner&quot;: &quot;5790000705689&quot;,
                &quot;validFromDate&quot;: &quot;2015-05-31T22:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1M&quot;
            }
        ],
        [
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.058
                    }
                ],
                &quot;name&quot;: &quot;Transmissions nettarif&quot;,
                &quot;description&quot;: &quot;Netafgiften, for b&aring;de forbrugere og producenter, d&aelig;kker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.&quot;,
                &quot;owner&quot;: &quot;5790000432752&quot;,
                &quot;validFromDate&quot;: &quot;2014-12-31T23:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1D&quot;
            },
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.054
                    }
                ],
                &quot;name&quot;: &quot;Systemtarif&quot;,
                &quot;description&quot;: &quot;Systemafgiften d&aelig;kker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.&quot;,
                &quot;owner&quot;: &quot;5790000432752&quot;,
                &quot;validFromDate&quot;: &quot;2014-12-31T23:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1D&quot;
            },
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.008
                    }
                ],
                &quot;name&quot;: &quot;Elafgift&quot;,
                &quot;description&quot;: &quot;Elafgiften&quot;,
                &quot;owner&quot;: &quot;5790000432752&quot;,
                &quot;validFromDate&quot;: &quot;2015-05-31T22:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1D&quot;
            },
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;2&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;3&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;4&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;5&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;6&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;7&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;8&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;9&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;10&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;11&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;12&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;13&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;14&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;15&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;16&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;17&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;18&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;19&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;20&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;21&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;22&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;23&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;24&quot;,
                        &quot;price&quot;: 0.5103
                    }
                ],
                &quot;name&quot;: &quot;Nettarif C time&quot;,
                &quot;description&quot;: &quot;Nettarif C time&quot;,
                &quot;owner&quot;: &quot;5790000705689&quot;,
                &quot;validFromDate&quot;: &quot;2019-04-30T22:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;PT1H&quot;
            }
        ],
        [],
        [
            {
                &quot;metering_point_id&quot;: &quot;&quot;
            }
        ],
        [
            {
                &quot;metering_point_gsrn&quot;: &quot;&quot;
            }
        ]
    ],
    &quot;first_page_url&quot;: &quot;http://localhost/api/charge/deleniti?page=1&quot;,
    &quot;from&quot;: 1,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost/api/charge/deleniti?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost/api/charge/deleniti?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;active&quot;: true
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost/api/charge/deleniti&quot;,
    &quot;per_page&quot;: 10,
    &quot;prev_page_url&quot;: null,
    &quot;to&quot;: 5,
    &quot;total&quot;: 5
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-charge--refresh_token--" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-charge--refresh_token--"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-charge--refresh_token--" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-charge--refresh_token--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-charge--refresh_token--"></code></pre>
</span>
<form id="form-GETapi-charge--refresh_token--" data-method="GET"
      data-path="api/charge/{refresh_token?}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-charge--refresh_token--', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-charge--refresh_token--"
                    onclick="tryItOut('GETapi-charge--refresh_token--');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-charge--refresh_token--"
                    onclick="cancelTryOut('GETapi-charge--refresh_token--');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-charge--refresh_token--" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/charge/{refresh_token?}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-charge--refresh_token--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-charge--refresh_token--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>refresh_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="refresh_token"                data-endpoint="GETapi-charge--refresh_token--"
               value="deleniti"
               data-component="url">
    <br>
<p>Example: <code>deleniti</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-DELETEapi-charges--metering_point--">Remove the specified resources from storage.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-charges--metering_point--">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/charges/sed" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/charges/sed"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-charges--metering_point--">
</span>
<span id="execution-results-DELETEapi-charges--metering_point--" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-charges--metering_point--"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-charges--metering_point--" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-charges--metering_point--" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-charges--metering_point--"></code></pre>
</span>
<form id="form-DELETEapi-charges--metering_point--" data-method="DELETE"
      data-path="api/charges/{metering_point?}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-charges--metering_point--', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-charges--metering_point--"
                    onclick="tryItOut('DELETEapi-charges--metering_point--');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-charges--metering_point--"
                    onclick="cancelTryOut('DELETEapi-charges--metering_point--');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-charges--metering_point--" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/charges/{metering_point?}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="DELETEapi-charges--metering_point--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="DELETEapi-charges--metering_point--"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>metering_point</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="metering_point"                data-endpoint="DELETEapi-charges--metering_point--"
               value="sed"
               data-component="url">
    <br>
<p>Example: <code>sed</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-charge">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-charge">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/charge" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"type\": \"necessitatibus\",
    \"name\": \"dolor\",
    \"description\": \"Dolores explicabo unde aut commodi assumenda ipsam exercitationem.\",
    \"owner\": \"rem\",
    \"valid_from\": \"2023-01-21T22:49:50\",
    \"valid_to\": \"2023-01-21T22:49:50\",
    \"period_type\": \"fzq\",
    \"price\": \"eveniet\",
    \"quantity\": \"nd\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/charge"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "necessitatibus",
    "name": "dolor",
    "description": "Dolores explicabo unde aut commodi assumenda ipsam exercitationem.",
    "owner": "rem",
    "valid_from": "2023-01-21T22:49:50",
    "valid_to": "2023-01-21T22:49:50",
    "period_type": "fzq",
    "price": "eveniet",
    "quantity": "nd"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-charge">
</span>
<span id="execution-results-POSTapi-charge" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-charge"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-charge" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-charge" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-charge"></code></pre>
</span>
<form id="form-POSTapi-charge" data-method="POST"
      data-path="api/charge"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-charge', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-charge"
                    onclick="tryItOut('POSTapi-charge');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-charge"
                    onclick="cancelTryOut('POSTapi-charge');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-charge" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/charge</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="POSTapi-charge"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="POSTapi-charge"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="type"                data-endpoint="POSTapi-charge"
               value="necessitatibus"
               data-component="body">
    <br>
<p>Example: <code>necessitatibus</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="name"                data-endpoint="POSTapi-charge"
               value="dolor"
               data-component="body">
    <br>
<p>Example: <code>dolor</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="description"                data-endpoint="POSTapi-charge"
               value="Dolores explicabo unde aut commodi assumenda ipsam exercitationem."
               data-component="body">
    <br>
<p>Example: <code>Dolores explicabo unde aut commodi assumenda ipsam exercitationem.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>owner</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="owner"                data-endpoint="POSTapi-charge"
               value="rem"
               data-component="body">
    <br>
<p>Example: <code>rem</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>valid_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="valid_from"                data-endpoint="POSTapi-charge"
               value="2023-01-21T22:49:50"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2023-01-21T22:49:50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>valid_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="valid_to"                data-endpoint="POSTapi-charge"
               value="2023-01-21T22:49:50"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2023-01-21T22:49:50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>period_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="period_type"                data-endpoint="POSTapi-charge"
               value="fzq"
               data-component="body">
    <br>
<p>Must not be greater than 5 characters. Example: <code>fzq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="price"                data-endpoint="POSTapi-charge"
               value="eveniet"
               data-component="body">
    <br>
<p>Example: <code>eveniet</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="quantity"                data-endpoint="POSTapi-charge"
               value="nd"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>nd</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-charge--id-">Display the specified resource.</h2>

<p>
</p>



<span id="example-requests-GETapi-charge--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/charge/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/charge/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-charge--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 49
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        [
            {
                &quot;price&quot;: 21,
                &quot;quantity&quot;: 1,
                &quot;name&quot;: &quot;Netabo C forbrug skabelon/flex&quot;,
                &quot;description&quot;: &quot;Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en &aring;rsafl&aelig;st m&aring;ler&quot;,
                &quot;owner&quot;: &quot;5790000705689&quot;,
                &quot;validFromDate&quot;: &quot;2015-05-31T22:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1M&quot;
            }
        ],
        [
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.058
                    }
                ],
                &quot;name&quot;: &quot;Transmissions nettarif&quot;,
                &quot;description&quot;: &quot;Netafgiften, for b&aring;de forbrugere og producenter, d&aelig;kker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.&quot;,
                &quot;owner&quot;: &quot;5790000432752&quot;,
                &quot;validFromDate&quot;: &quot;2014-12-31T23:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1D&quot;
            },
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.054
                    }
                ],
                &quot;name&quot;: &quot;Systemtarif&quot;,
                &quot;description&quot;: &quot;Systemafgiften d&aelig;kker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.&quot;,
                &quot;owner&quot;: &quot;5790000432752&quot;,
                &quot;validFromDate&quot;: &quot;2014-12-31T23:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1D&quot;
            },
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.008
                    }
                ],
                &quot;name&quot;: &quot;Elafgift&quot;,
                &quot;description&quot;: &quot;Elafgiften&quot;,
                &quot;owner&quot;: &quot;5790000432752&quot;,
                &quot;validFromDate&quot;: &quot;2015-05-31T22:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;P1D&quot;
            },
            {
                &quot;prices&quot;: [
                    {
                        &quot;position&quot;: &quot;1&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;2&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;3&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;4&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;5&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;6&quot;,
                        &quot;price&quot;: 0.1701
                    },
                    {
                        &quot;position&quot;: &quot;7&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;8&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;9&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;10&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;11&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;12&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;13&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;14&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;15&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;16&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;17&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;18&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;19&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;20&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;21&quot;,
                        &quot;price&quot;: 1.5308
                    },
                    {
                        &quot;position&quot;: &quot;22&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;23&quot;,
                        &quot;price&quot;: 0.5103
                    },
                    {
                        &quot;position&quot;: &quot;24&quot;,
                        &quot;price&quot;: 0.5103
                    }
                ],
                &quot;name&quot;: &quot;Nettarif C time&quot;,
                &quot;description&quot;: &quot;Nettarif C time&quot;,
                &quot;owner&quot;: &quot;5790000705689&quot;,
                &quot;validFromDate&quot;: &quot;2019-04-30T22:00:00.000Z&quot;,
                &quot;validToDate&quot;: null,
                &quot;periodType&quot;: &quot;PT1H&quot;
            }
        ],
        [],
        [
            {
                &quot;metering_point_id&quot;: &quot;&quot;
            }
        ],
        [
            {
                &quot;metering_point_gsrn&quot;: &quot;&quot;
            }
        ]
    ],
    &quot;first_page_url&quot;: &quot;http://localhost/api/charge/1?page=1&quot;,
    &quot;from&quot;: 1,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost/api/charge/1?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost/api/charge/1?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;active&quot;: true
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost/api/charge/1&quot;,
    &quot;per_page&quot;: 10,
    &quot;prev_page_url&quot;: null,
    &quot;to&quot;: 5,
    &quot;total&quot;: 5
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-charge--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-charge--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-charge--id-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-charge--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-charge--id-"></code></pre>
</span>
<form id="form-GETapi-charge--id-" data-method="GET"
      data-path="api/charge/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-charge--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-charge--id-"
                    onclick="tryItOut('GETapi-charge--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-charge--id-"
                    onclick="cancelTryOut('GETapi-charge--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-charge--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/charge/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="GETapi-charge--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="GETapi-charge--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="id"                data-endpoint="GETapi-charge--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the charge. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-charge--id-">Update the specified resource in storage.</h2>

<p>
</p>



<span id="example-requests-PUTapi-charge--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/charge/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"type\": \"iste\",
    \"name\": \"dicta\",
    \"description\": \"Doloremque pariatur incidunt enim perferendis facilis.\",
    \"owner\": \"et\",
    \"valid_from\": \"2023-01-21T22:49:50\",
    \"valid_to\": \"2023-01-21T22:49:50\",
    \"period_type\": \"g\",
    \"price\": \"quis\",
    \"quantity\": \"oj\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/charge/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "iste",
    "name": "dicta",
    "description": "Doloremque pariatur incidunt enim perferendis facilis.",
    "owner": "et",
    "valid_from": "2023-01-21T22:49:50",
    "valid_to": "2023-01-21T22:49:50",
    "period_type": "g",
    "price": "quis",
    "quantity": "oj"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-charge--id-">
</span>
<span id="execution-results-PUTapi-charge--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-charge--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-charge--id-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-charge--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-charge--id-"></code></pre>
</span>
<form id="form-PUTapi-charge--id-" data-method="PUT"
      data-path="api/charge/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-charge--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-charge--id-"
                    onclick="tryItOut('PUTapi-charge--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-charge--id-"
                    onclick="cancelTryOut('PUTapi-charge--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-charge--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/charge/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/charge/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="PUTapi-charge--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="PUTapi-charge--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="id"                data-endpoint="PUTapi-charge--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the charge. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="type"                data-endpoint="PUTapi-charge--id-"
               value="iste"
               data-component="body">
    <br>
<p>Example: <code>iste</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="name"                data-endpoint="PUTapi-charge--id-"
               value="dicta"
               data-component="body">
    <br>
<p>Example: <code>dicta</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="description"                data-endpoint="PUTapi-charge--id-"
               value="Doloremque pariatur incidunt enim perferendis facilis."
               data-component="body">
    <br>
<p>Example: <code>Doloremque pariatur incidunt enim perferendis facilis.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>owner</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="owner"                data-endpoint="PUTapi-charge--id-"
               value="et"
               data-component="body">
    <br>
<p>Example: <code>et</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>valid_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="valid_from"                data-endpoint="PUTapi-charge--id-"
               value="2023-01-21T22:49:50"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2023-01-21T22:49:50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>valid_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="valid_to"                data-endpoint="PUTapi-charge--id-"
               value="2023-01-21T22:49:50"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2023-01-21T22:49:50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>period_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="period_type"                data-endpoint="PUTapi-charge--id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 5 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="price"                data-endpoint="PUTapi-charge--id-"
               value="quis"
               data-component="body">
    <br>
<p>Example: <code>quis</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
               name="quantity"                data-endpoint="PUTapi-charge--id-"
               value="oj"
               data-component="body">
    <br>
<p>Must not be greater than 4 characters. Example: <code>oj</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-charge--id-">Remove the specified resource from storage.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-charge--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/charge/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/charge/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-charge--id-">
</span>
<span id="execution-results-DELETEapi-charge--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-charge--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-charge--id-" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-charge--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-charge--id-"></code></pre>
</span>
<form id="form-DELETEapi-charge--id-" data-method="DELETE"
      data-path="api/charge/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-charge--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-charge--id-"
                    onclick="tryItOut('DELETEapi-charge--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-charge--id-"
                    onclick="cancelTryOut('DELETEapi-charge--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-charge--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/charge/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Content-Type"                data-endpoint="DELETEapi-charge--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
               name="Accept"                data-endpoint="DELETEapi-charge--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               name="id"                data-endpoint="DELETEapi-charge--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the charge. Example: <code>1</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
