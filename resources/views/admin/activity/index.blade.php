@extends('layouts.admin')

@section('title')
    Activité
@endsection

@section('content')
    <table id="activity" class="table table-vcenter bg-white rounded shadow-sm">
        <thead>
            <tr>
                <th></th>
                <th>Créé le</th>
                <th>Description</th>
                <th>Causé par</th>
                <th class="text-center" style="width: 50px"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection