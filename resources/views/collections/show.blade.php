@extends('layouts_lp.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', $collection->name)

@section('content')
<x-collections.show :collection="$collection" />
@stop