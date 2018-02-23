@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Загрузите xml файл:</label>
                    <input type="file" name="file" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" value="Загрузка">
                </div>
            </form>
        </div>
    </div>

@stop