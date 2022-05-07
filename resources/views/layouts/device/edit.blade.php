@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Editing device "' . $device->name.'"') }}</div>
                    <div class="card-body">
                        <form method="post" action="#">
                            @csrf
                            <table>
                                <tr>
                                    <td>Name:</td>
                                    <td><input type="text" value="Name"></td>
                                </tr>
                                <tr>
                                    <td>Device type:</td>
                                    <td><select value="Name">
                                            {{ $types = $deviceTypes() }}
                                            @foreach($types as $item)
                                                {{$item}}
                                            @endforeach
                                            <option value=""></option>
                                        </select></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
