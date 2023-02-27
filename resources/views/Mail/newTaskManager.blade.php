@component('mail::message')
<h1>Existe uma nova tarefa para você</h1> 

<p> Olá, o {{ $user->name }} atribuiu uma nova tarefa para você. Veja a seguir os detalhes da tarefa: </p>
<x-mail::table>
| Título        | Descrição     |  Previsão de termino |  Status | Responsavel |
| ------------- |:-------------:| --------------------:| -------:| ------------:|
| {{$task->title}} | {{$task->description}}| {{$task->end_estimate_date}} |  {{$task->status}}  | {{$task->owner}} |
</x-mail::table>
@endcomponent