@extends('templates.admin.layout')

@section('content')
<div class="">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Products 
                    @permission(('create'))
                    <a href="{{route('products.create')}}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Create New </a></h2>
                    @endpermission
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Barcode</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if(count($products))
                            @foreach ($products as $row)
                            <tr>
                                <td>{{$row->barcode}}</td>
                                <td>{{$row->product_name}}</td>
                                <td>{{$row->description}}</td>
                                <td>{{number_format($row->price,2)}}</td>
                                <td>{{$row->stock}}</td>
                                <td>{{$row->brand->name}}</td>
                                <td>{{$row->category->name}}</td>
                                <td>
                                    @permission(('edit'))
                                    <a href="{{ route('products.edit', ['id' => $row->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil" title="Edit"></i> </a>
                                    @endpermission
                                    @permission(('delete'))
                                    <a href="{{ route('products.show', ['id' => $row->id]) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" title="Delete"></i> </a>
                                    @endpermission
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop