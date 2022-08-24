{{--  @if(!empty($seo))  --}}
    <title> {{ $settings->sitename(__($page_title)) }}</title>
    <meta name="title" Content="{{ $settings->sitename(__($page_title)) }}">
    <meta name="description" content="{{ $settings->description }}">
    <meta name="keywords" content="{{ implode(',',explode(',',$settings->keywords)) }}">
    <link rel="shortcut icon" href="{{ asset($settings->favicon) }}" type="image/x-icon">

    {{--<!-- Apple Stuff -->--}}
    <link rel="apple-touch-icon" href="{{ asset($settings->favicon) }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ $settings->sitename($page_title) }}">
    {{--<!-- Google / Search Engine Tags -->--}}
    <meta itemprop="name" content="{{ $settings->sitename($page_title) }}">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset($settings->favicon) }}">
    {{--<!-- Facebook Meta Tags -->--}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $settings->sitename() }}">
    <meta property="og:description" content="{{ $settings->description }}">
    <meta property="og:image" content="{{ asset($settings->favicon) }}"/>
    <meta property="og:image:type" content="png" />
    {{--  @php $social_image_size = explode('x', imagePath()['seo']['size']) @endphp
    <meta property="og:image:width" content="{{ $social_image_size[0] }}" />
    <meta property="og:image:height" content="{{ $social_image_size[1] }}" />  --}}
    <meta property="og:url" content="{{ url()->current() }}">
    {{--<!-- Twitter Meta Tags -->--}}
    <meta name="twitter:card" content="summary_large_image">
{{--  @endif  --}}
