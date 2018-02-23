@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Автобус №</th>
                        <th>Производственных рейсов</th>
                        <th>Продолжительность</th>
                    </tr>
                    </thead>
                    @foreach($buses as $busNum => $bus)
                        <? $stats = $bus->getRidesStats(); ?>
                        <tr>
                            <td>#{!! $busNum !!}</td>
                            <td>{!! $stats['ridesCount'] !!} шт.</td>
                            <td>{!! $stats['duration'] !!}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                Остановки производственных рейсов с 06:00 до 16:00
                @foreach($buses as $busNum => $bus)
                    <br>Автобус №{!! $busNum !!}
                    <? $stats = $bus->getStopsByTime('06:00', '16:00'); ?>

                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Остановка</th>
                            <th>Время</th>
                            <th>Смена</th>
                            <th>Рейс в смене</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stats as $stop)
                            <tr>
                                <td>{!! !empty($stop['name']) ? $stop['name'] . '(' . $stop['st_id'] . ')' : $stop['st_id'] !!}</td>
                                <td>{!! $stop['time'] !!}</td>
                                <td>{!! $stop['workNum'] !!}</td>
                                <td>{!! $stop['rideNum'] !!}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                @endforeach
            </div>
        </div>
    </div>

@stop