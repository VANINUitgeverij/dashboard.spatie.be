@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="2" rows="3">
    {{--<uptime position="a1:a3"></uptime>--}}
    {{-- <github-project position="a1" projects="SOL2"></github-project> --}}
    <time-weather position="b1" date-format="DD/MM/YYYY" time-format="HH:mm:ss" time-zone="Europe/Brussels" weather-city="Gent"></time-weather>
    <count-down :overlay-minutes="5" name="Standup" cron="0 11 * * 1-4" :timer-minutes="15" ></count-down>
    {{-- <count-down position="b3" name="Development vergadering" cron="0 10 * * 5"></count-down> --}}
    <internet-connection></internet-connection>
</dashboard>

@endsection
