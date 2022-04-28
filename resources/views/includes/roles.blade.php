@php
  $role = explode(",", auth()->user()->role);
  print_r($role);
@endphp