@extends('layouts.app')



@section('content')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'print preview directionality  image link media template  table  hr  anchor toc  lists  help',
            menubar: true
        });
    </script>
    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin())

        <div class="container">
            <div class="content">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error}}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif


                {!! Form::open(['route'=>'article.store','method' => 'post']) !!}
                @csrf
                {{ Form::label('title','Title:') }}
                {{ Form::text('title','', ['required' => 'required', 'class' => 'form-control']) }}<br>

                {{ Form::label('description','Description:') }}
                {{ Form::text('description','', ['required' => 'required', 'class' => 'form-control']) }}<br>

                {{ Form::label('text','Text:') }}
                <div class="col-xs-8">
                    {{ Form::textarea('text','', ['class' => 'form-control', 'id'=>'editor'])  }}<br>
                </div>

                {{ Form::submit('Add Article', ['class' => 'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@endsection

