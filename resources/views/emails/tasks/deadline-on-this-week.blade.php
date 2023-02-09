
<div>
    <p>Необходимо выполнить:</p>
    <hr>
    <?php $counter = 1; ?>
    @foreach($tasks as $task)
        <p>Задача {{$counter++}}</p>
        <p>До: {{$task->deadline_at}}</p>
        <p>{{$task->description}}</p>
        <hr>
    @endforeach
</div>
