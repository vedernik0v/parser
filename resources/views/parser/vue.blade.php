@extends('layouts.parser')

@section('content')

  <div class="title m-b-md">
    <form action="/" method="POST">
      {{ csrf_field() }}
      <input type="input" name="s">
      <button>OK</button>
    </form>
  </div>
  @isset($s)
  <div class="dev">
    <small>{{ $s }}</small><br>
    {{ $url }} {{ $cssSelector }}
  </div>
  {{ $content }}
  @endisset

@endsection
