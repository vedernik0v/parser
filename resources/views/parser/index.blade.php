@extends('layouts.parser')

@section('content')

  <div class="title m-b-md">
    <form action="/" method="POST">
      {{ csrf_field() }}
      <input type="input" name="s" value="{{ old('s') }}"
             placeholder='https://habr.com class="stacked-menu__item-link"'>
      <button>OK</button>
    </form>
  </div>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
      </ul>
    </div>
  @endif
  @isset($s)
    <div class="dev">
      <small>{{ $s }}</small><br>
      {{ $url }} {{ $cssSelector }}
    </div>
    {{ $content }}
  @endisset
@endsection
