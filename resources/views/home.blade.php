@extends('layouts.app')

@section('content')
    <div class="container">

        <div style="font-size: 84px;  text-align: center; margin-bottom: 50px;">
            Basilik Blog
        </div>

        @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin())

            {!! Form::open(['route' => 'articles.create', 'method'=>'get']) !!}

            {{ Form::submit('Add Article +', ['class' => 'btn btn-primary']) }}

            {!! Form::close() !!}<br>
        @endif

        <div align="right">
            {{ $articles->links() }}
        </div>

        @foreach($articles as $article)
            <div class="" style="border-bottom: 1px solid #d6d8db;">

                <a class="btn btn-default" href="{{ url('articles/'.$article->id) }}" role="button"><h2>
                        "{{$article->title}}"</h2></a>
                <p>{{$article->description}}  </p>
                <p><b>Publication date: </b>{{$article->created_at}}</p>

                <div align="left">
                    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin())

                        {!! Form::open(['url' => 'articles/'.$article->id, 'method'=>'delete']) !!}
                        {{ Form::submit('Delete x', ['class' => 'btn']) }}
                        {!! Form::close() !!}

                        {!! Form::open(['url' => 'articles/'.$article->id.'/edit', 'method'=>'get']) !!}
                        {{ Form::submit('Edit article', ['class' => 'btn','style'=>'margin-left: 100px; margin-top: -63px;']) }}
                        {!! Form::close() !!}

                    @endif
                </div>
                <div align="right">
                    <a class="btn btn-default" style="margin-top: -200px;" href="{{ url('articles/'.$article->id) }}"
                       role="button">Read article &raquo;</a>
                </div>
            </div>
        @endforeach
        <div align="right">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
