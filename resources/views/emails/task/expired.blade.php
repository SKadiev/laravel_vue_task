
@component('mail::message')

<h2>User : {{ $user->name }}</h2>

<h4>Expired Tasks</h4>
@foreach ($tasks as $task )
<hr>
<p><strong>Id: </strong> {{ $task['id'] }}</p>
<p><strong>Title: </strong>  {{ $task['title'] }}</p>
<p><strong>Description: </strong> {{ $task['description'] }}</p>
@endforeach
