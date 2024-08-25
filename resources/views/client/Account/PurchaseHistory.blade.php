@extends('client.layout')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-4">
                <div class="card">
                    <img class="avatar mx-auto mt-3" src="{{ url('') . '/' }}img/user/{{ $user->avt }}" alt="Card image">
                    <div class="card-body">
                        <center>
                            <h4 class="">{{ $user->full_name }}</h4>
                        </center>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item "><a href="{{ route('client.account.index') }}">Account info</a></li>
                            <li class="list-group-item "><a href="{{ route('client.account.changepassword') }}">Change
                                    password</a></li>
                            <li class="list-group-item active-list"><a
                                    href="{{ route('client.account.PurchaseHistory') }}">Purchase history</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 ">
                <div id="content-wrapper" class="d-flex flex-column">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Bill</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Bill</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($bills as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>Bill #{{ $item->id }}</td>
                                                <td>{{ number_format($item->total, 0, ',', '.') }}¥</td>
                                                <td
                                                    class="{{ $item->status == 0 ? 'text-danger' : ($item->status == 2 ? 'text-warning' : 'text-success') }} font-weight-bold">
                                                    {{ $item->status == 2 ? 'Đã huỷ' : ($item->status == 0 ? 'Chưa thanh toán' : 'Đã thanh toán') }}
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-info btn-detail" data-toggle="collapse"
                                                        href="#detail{{ $item->id }}" aria-expanded="false"
                                                        aria-controls="detail{{ $item->id }}">Detail</a>
                                                </td>
                                            </tr>
                                            <tr id="detail{{ $item->id }}" class="collapse">
                                                <td colspan="5">
                                                    <!-- Nội dung chi tiết -->
                                                    <p><strong>Name</strong> {{ $item->full_name }}</p>
                                                    <p><strong>Phone</strong> {{ $item->phone }}</p>
                                                    <p><strong>Address</strong> {{ $item->address }}</p>
                                                    <table class="table">
                                                        <thead>
                                                            <th>#</th>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($billDetails[$item->id] as $detailKey => $detail)
                                                                <tr>
                                                                    <th scope="row">{{ $detailKey + 1 }}</th>
                                                                    <td>
                                                                        <img src="{{ asset('img/product/' . $detail['product']->img) }}"
                                                                            width="20%" alt="" />
                                                                        {{ $detail['product']->name }}
                                                                    </td>
                                                                    <td>{{ number_format($detail['product']->price, 0, ',', '.') }}¥
                                                                    </td>
                                                                    <td>{{ $detail['quantity'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
