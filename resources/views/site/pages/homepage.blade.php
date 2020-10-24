@extends('site.app')
@section('title', 'Homepage')

@section('content')
    <h2>Homepage</h2>
    <div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Description </th>
                            <th> Quantity </th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
