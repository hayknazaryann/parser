@extends('layouts.app')
@section('css-stack')
    <style>
        .post-row{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center m-1">
                <a href="{{route('parse')}}" type="button" class="btn btn-primary">Update</a>
            </div>

            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 10%">#</th>
                    <th scope="col" style="width: 25%">Title</th>
                    <th scope="col" style="width: 45%">Description</th>
                    <th scope="col" style="width: 10%">Author</th>
                    <th scope="col" style="width: 10%">Date</th>
                </tr>
                </thead>
                <tbody>
                @if($posts->count())
                    @foreach($posts as $post)
                        <tr class="post-row" data-href={{$post->link}}>
                            <th scope="row" style="width: 10%">{{$post->id}}</th>
                            <td style="width: 25%">{{$post->title}}</td>
                            <td style="width: 45%">{{$post->description}}</td>
                            <td style="width: 10%">{{$post->author}}</td>
                            <td style="width: 10%">{{$post->pubDate}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" align="center">
                            There are no posts
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
@section('js-stack')
    <script type="text/javascript">
        $(document).ready(function($) {
            $(".post-row").click(function() {
                window.open($(this).data("href"), '_blank');
            });
        });
    </script>
@endsection