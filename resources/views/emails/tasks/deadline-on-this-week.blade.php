<div>
    @if(isset($tasks['overdue']) && count($tasks['overdue']) > 0)
    <h3>В данный момент у Вас <b style="color: red;">просрочено</b> выполнение следующих задач:</h3>
    <table style="border-collapse: collapse;">
        <tr>
            <th style="border: 1px solid">№<br>п/п</th>
            <th style="border: 1px solid">Задача</th>
            <th style="border: 1px solid">Срок исполнения</th>
        </tr>
        <?php $counter = 1; ?>
        @foreach($tasks as $key => $value)
            @if($key === 'overdue')
                @foreach($value as $key2 => $value2)
                    <tr>
                        <td style="border: 1px solid">{{$counter++}}</td>
                        <td style="border: 1px solid">{{$value2->description}}</td>
                        <td style="color: red; border: 1px solid">{{date('d.m.Y H:i', strtotime($value2->deadline_at))}} мск</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </table>
    @endif

    <br>
    @if(isset($tasks['current']) && count($tasks['current']) > 0)
    <h3>На этой неделе у Вас запланировано выполнение следующих задач:</h3>
    <table style="border-collapse: collapse;">
        <tr>
            <th style="border: 1px solid">№<br>п/п</th>
            <th style="border: 1px solid">Задача</th>
            <th style="border: 1px solid">Срок исполнения</th>
        </tr>
        <?php $counter = 1; ?>
        @foreach($tasks as $key => $value)
            @if($key === 'current')
                @foreach($value as $key2 => $value2)
                    <tr>
                        <td style="border: 1px solid">{{$counter++}}</td>
                        <td style="border: 1px solid">{{$value2->description}}</td>
                        <td style="border: 1px solid">{{date('d.m.Y H:i', strtotime($value2->deadline_at))}} мск</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </table>
    @endif
</div>