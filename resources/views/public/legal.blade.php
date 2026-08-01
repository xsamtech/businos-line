@extends('layouts.public')

@section('title', $subject->subject)

@section('content')
    <section class="py-5">
        <div class="container">
            <h1>{{ $subject->subject }}</h1>
            <p class="lead">{{ $subject->description }}</p>

            @foreach($subject->titles as $title)
                <article class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h2>{{ $title->title }}</h2>
                        @foreach($title->contents as $content)
                            @if($content->subtitle)<h3 class="h5">{{ $content->subtitle }}</h3>@endif
                            <p>{{ $content->content }}</p>
                            @if($content->dashes->isNotEmpty())
                                <ul>
                                    @foreach($content->dashes as $dash)
                                        <li>{{ $dash->dash_content }}
                                            @if($dash->children->isNotEmpty())
                                                <ul>@foreach($dash->children as $child)<li>{{ $child->dash_content }}</li>@endforeach</ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
