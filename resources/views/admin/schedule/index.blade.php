@extends('adminlte::page')

@section('title', '- Agenda')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('fullcalendar/fullcalendar.min.css') }}" />
    <style>
        .fc-day-grid-event {
            border-color: rgb(0, 123, 255);
            background-color: rgb(0, 123, 255);
            font-weight: bold;
            cursor: pointer;
            padding: 2px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-calendar"></i> Agenda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Agenda</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Agenda de Eventos</h3>
                                @can('Criar Eventos na Agenda')
                                    <a href="{{ route('admin.schedule.create') }}" title="Novo Evento"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Evento</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

    </section>

@endsection

@section('custom_js')
    <script src="{{ asset('fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/pt-br.js') }}"></script>
    <script>
        $(document).ready(function() {
            const calendar = $('#calendar').fullCalendar({
                editable: false,
                events: window.location.href,
                displayEventTime: true,
                eventRender: function(e) {
                    if (e.allDay === 'true') {
                        e.allDay = true;
                    } else {
                        e.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function(s) {
                    window.location.href = window.location.href + '-day/' + $.fullCalendar.formatDate(s,
                        "Y-MM-DD");
                },
                eventClick: function(e) {
                    window.location.href = window.location.href + '/' + e.id
                }
            });
        });
    </script>

@endsection
