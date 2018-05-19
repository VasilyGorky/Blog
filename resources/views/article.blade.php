@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach

                </ul>
            </div>
        @endif
        <p><a class="btn btn-default" href="{{ url('/') }}" role="button">&laquo; Back</a></p>
        <div>
            <div>
                <h2 style="border-bottom: 1px solid #d6d8db">{{$article->description}}</h2><br>
                <h3>"{{$article->title}}"</h3>
                <p>{{$article->image}}</p>
                <p>{!!  $article->text!!}  </p>
                <p><b>Publication date: </b> {{$article->created_at}}</p>
            </div>
        </div>
        <div align="right">
            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin())


                {!! Form::open(['url' => 'article/'.$article->id, 'method'=>'delete', 'style' => 'margin-right: 120px; margin-bottom: -36px;']) !!}
                {{ Form::submit('Delete x', ['class' => 'btn']) }}
                {!! Form::close() !!}

                {!! Form::open(['url' => 'article/'.$article->id.'/edit', 'method'=>'get']) !!}
                {{ Form::submit('Edit article', ['class' => 'btn']) }}
                {!! Form::close() !!}

            @endif
        </div>
    </div>
@endsection
