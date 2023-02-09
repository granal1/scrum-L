
<div>
    <p>На сегодняшний день у Вас <b style="color: red;">просрочено</b> выполнение следующих задач:</p>
    <hr>
    <?php $counter = 1; ?>
    @foreach($tasks as $key => $value)
        @if($key === 'overdue')
            @foreach($value as $key2 => $value2)
                <p style="color: red;">Задача {{$counter++}}</p>
                <p>До: {{$value2->deadline_at}}</p>
                <p>{{$value2->description}}</p>
                <hr>
            @endforeach
        @endif
    @endforeach
    <br>
    <p>У Вас на этой неделе <b style="color: green;">запланированы</b> следующие задачи:</p>
    <hr>
    <?php $counter = 1; ?>
    @foreach($tasks as $key => $value)
        @if($key === 'current')
            @foreach($value as $key2 => $value2)
                <p style="color: green;">Задача {{$counter++}}</p>
                <p>До: {{$value2->deadline_at}}</p>
                <p>{{$value2->description}}</p>
                <hr>
            @endforeach
        @endif
    @endforeach
</div>
