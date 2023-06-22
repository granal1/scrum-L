<div>
    <p>{{$author}} добавил(а) новую задачу {{date('d.m.Y H:i', strtotime($created_at))}} мск.<br>
    Срок исполнения до {{date('d.m.Y H:i', strtotime($deadline_at))}} мск., приоритет {{$priority}}.</p>
    <p><a href="{{url("/tasks/{$id}")}}"
        style="text-decoration: none; 
        display: inline-block; 
        background: #0d6efd;
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;" 
        target="_blank">Открыть задачу</a>
    </p>
</div>

{{Log::info('Отправка для ' .$name. ' на адрес ' .$email. ' уведомления о новой задаче '.$id)}}