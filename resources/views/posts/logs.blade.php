@extends('layouts.app')
@section('css-stack')
    <style>
        .log-row{
            cursor: pointer;
        }
        div.xml{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            cursor: pointer;
            padding-left: 5px;
            float:left;
            margin:5px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr style="width: 100%">
                        <th scope="col" style="width: 10%">Method</th>
                        <th scope="col" style="width: 20%">URL</th>
                        <th scope="col" style="width: 15%">Response Code</th>
                        <th scope="col" style="width: 35%">Response Body</th>
                        <th scope="col" style="width: 20%">Date</th>
                    </tr>
                </thead>
                <tbody>
                @if($logs->count())
                    @foreach($logs as $log)
                        <tr class="log-row">
                            <td>{{$log->method}}</td>
                            <td>
                                <a href="{{$log->url}}" target="_blank">{{$log->url}}</a>
                            </td>
                            <td>{{$log->response_code}}</td>
                            <td>
                                <div class="xml">
                                    {{$log->response_body}}
                                </div>
                            </td>
                            <td>{{$log->request_date}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" align="center">
                            There are no logs
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $logs->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
@section('js-stack')
<script>
    var long = false;

    $(document).on("click", ".xml", function (e) {
        if(!long){
            long=true;
            let max = 0;
            $(this).css("-webkit-line-clamp", "99");
            $($(this).parent()).find(".xml").each(function(){
                $(this).css("-webkit-line-clamp", "99");
                max = Math.max(max, parseInt($(this).css( "height" )) );
            });
            $($(this).parent()).find(".xml").each(function(){
                $(this).height(max);
            });
        }
        else{
            long=false;
            $(this).css("-webkit-line-clamp", "1");
            $(this).height('auto');
            $($(this).parent()).find(".xml").each(function(){
                $(this).css("-webkit-line-clamp", "1").height('auto');
            });
        }
    });
</script>
@endsection
